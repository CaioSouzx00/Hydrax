import sys
import torch
from transformers import CLIPProcessor, CLIPModel
from PIL import Image
import mysql.connector
import json
import os
import warnings
import logging

warnings.filterwarnings("ignore")
logging.getLogger("transformers").setLevel(logging.WARNING)

# Prompt vindo do Laravel
if len(sys.argv) < 2:
    print(json.dumps([]))
    sys.exit(0)

prompt = sys.argv[1]

# Conexão MySQL
try:
    con = mysql.connector.connect(
        host="127.0.0.1",
        user="root",
        password="",
        database="hydrax"
    )
    cursor = con.cursor(dictionary=True)

    cursor.execute("""
    SELECT 
        p.id_produtos, 
        p.nome, 
        p.categoria, 
        p.preco, 
        pir.imagem, 
        pir.categoria AS rotulo_categoria,
        pir.estilo,
        pir.genero,
        pir.marca
    FROM produtos_fornecedores p
    LEFT JOIN produto_imagem_rotulos pir ON p.id_produtos = pir.id_produto
    """)
    produtos_db = cursor.fetchall()
finally:
    con.close()

device = "cpu"


# Carrega modelo e processor
model = CLIPModel.from_pretrained("openai/clip-vit-base-patch32").to(device)
processor = CLIPProcessor.from_pretrained("openai/clip-vit-base-patch32")


resultados = []

# Embedding do prompt
inputs_prompt = processor(text=[prompt], return_tensors="pt", padding=True).to(device)
with torch.no_grad():
    embedding_prompt = model.get_text_features(**inputs_prompt).cpu()

base_path = "C:/xampp/htdocs/hydrax/storage/app/public/"

for produto in produtos_db:
    texto = f"{produto['nome']} {produto['categoria']} {produto.get('rotulo_categoria','')} {produto.get('estilo','')} {produto.get('genero','')} {produto.get('marca','')}"

    embedding_produto = None
    imagem = None

    # Carrega imagem se existir
    if produto.get('imagem'):
        caminho_imagem = os.path.join(base_path, produto['imagem'].replace("\\", "/"))
        if os.path.isfile(caminho_imagem):
            try:
                imagem = Image.open(caminho_imagem).convert("RGB")
            except Exception as e:
                imagem = None

    # Cria embedding do produto
    if imagem:
        inputs = processor(text=[texto], images=imagem, return_tensors="pt", padding=True).to(device)
        with torch.no_grad():
            outputs = model(**inputs)
            if outputs.text_embeds is not None and outputs.image_embeds is not None:
                embedding_produto = (outputs.text_embeds + outputs.image_embeds).cpu()
            else:
                # fallback para texto
                embedding_produto = model.get_text_features(**processor(text=[texto], return_tensors="pt").to(device)).cpu()
    else:
        inputs = processor(text=[texto], return_tensors="pt", padding=True).to(device)
        with torch.no_grad():
            embedding_produto = model.get_text_features(**inputs).cpu()

    # Calcula similaridade
    score = torch.nn.functional.cosine_similarity(embedding_produto, embedding_prompt).item()
    
    resultados.append({
        "id": produto['id_produtos'],
        "nome": produto['nome'],
        "preco": float(produto['preco']),
        "score": score,
        "imagem": produto.get('imagem'),
        "categoria": produto.get('categoria'),
        "rotulo_categoria": produto.get('rotulo_categoria'),
        "estilo": produto.get('estilo'),
        "genero": produto.get('genero'),
        "marca": produto.get('marca'),
    })

# Ordena pelo score
resultados = sorted(resultados, key=lambda x: x['score'], reverse=True)

# Saída JSON limpa
sys.stdout.write(json.dumps(resultados, ensure_ascii=False))
sys.stdout.flush()
