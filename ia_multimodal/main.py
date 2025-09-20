from dataset import carregar_produtos
from embeddings import carregar_modelo, gerar_embedding_texto, gerar_embedding_imagem
from search import cosine_similarity

from db import get_connection

def carregar_produtos():
    conn = get_connection()
    cursor = conn.cursor(dictionary=True)

    query = """
        SELECT p.id_produtos, p.descricao, r.imagem, r.categoria, r.estilo, r.genero, r.marca
        FROM produtos_fornecedores p
        JOIN produto_imagem_rotulos r ON r.id_produto = p.id_produtos
    """
    cursor.execute(query)
    produtos = cursor.fetchall()

    cursor.close()
    conn.close()
    return produtos

# Carregar dados
produtos = carregar_produtos("produtos.json")

# Carregar modelo
modelo, preprocess = carregar_modelo()

# Prompt do usuário
consulta = "tênis de basquete masculino"
embedding_consulta = gerar_embedding_texto(modelo, consulta)

# Comparar com produtos
resultados = []
for produto in produtos:
    emb_img = gerar_embedding_imagem(modelo, preprocess, produto["imagem"])
    score = cosine_similarity(embedding_consulta, emb_img)
    resultados.append((produto["nome"], score))

# Ordenar
resultados.sort(key=lambda x: x[1], reverse=True)

# Mostrar top 3
print("Resultados mais parecidos:")
for nome, score in resultados[:3]:
    print(f"{nome} - Similaridade: {score:.4f}")
