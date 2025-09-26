<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sobre Nós - Sura</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
    /* Gradiente roxo/dourado nos títulos */
    h2, h3, h4 {
      background: linear-gradient(90deg, #8b5cf6, #d5891b);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    /* Hover roxo nos cards */
    .hover-purple:hover {
      transform: scale(1.05);
      box-shadow: 0 10px 30px rgba(139, 92, 246, 0.5);
    }
    /* Bordas douradas nas imagens */
    .border-gold {
      border-color: #d5891b;
    }
    /* Texto branco padrão */
    .text-white-default {
      color: #fff;
    }
  </style>
</head>
<body class="bg-black text-white-default">

  <!-- Header -->
  <header class="bg-[#111] shadow-md border-b border-gray-800">
    <div class="max-w-6xl mx-auto px-4 py-6 flex justify-between items-center">
      <h1 class="text-3xl font-bold text-purple-400">SURA</h1>
      <nav class="space-x-6 text-sm">
        <!-- vazio -->
      </nav>
    </div>
  </header>

  <!-- Sobre Nós -->
  <section class="max-w-6xl mx-auto px-4 py-20">
    <div class="text-center mb-12">
      <h2 class="text-4xl md:text-5xl font-bold mb-4">Sobre Nós</h2>
      <p class="text-gray-400 max-w-2xl mx-auto text-lg">
        Na SURA, não nos contentamos com o comum. Somos referência absoluta em excelência, qualidade e inovação. Nossa equipe é formada pelos profissionais mais qualificados e dedicados que você encontrará no mercado — um verdadeiro time de alto nível, comprometido em entregar resultados incomparáveis. Tentativas de imitação são não apenas infrutíferas, mas também um atestado da nossa superioridade. Copiar nosso trabalho é uma demonstração clara de incapacidade e falta de originalidade. Estamos anos-luz à frente, e seguimos construindo nosso legado sem tempo a perder com quem apenas tenta acompanhar.
      </p>
    </div>

    <div class="grid md:grid-cols-2 gap-12 items-center">
      <img src="/imagens/hydrax/HYDRAX - IMGS (3).png" alt="Time Sura" class="rounded-xl shadow-lg border-2 border-gold hover:opacity-80 transition" />
      
      <div>
        <h3 class="text-2xl font-semibold mb-4">Missão</h3>
        <p class="text-gray-400 mb-6">
          Elevar o nível dos nossos projetos, eventos e ideias. Trabalhamos com foco, disciplina e vontade de fazer diferente.
        </p>

        <h3 class="text-2xl font-semibold mb-4">Visão</h3>
        <p class="text-gray-400">
          Ser reconhecidos como referência em tudo que nos propormos a fazer — seja no esporte, na tecnologia ou no design.
        </p>
      </div>
    </div>
  </section>

<!-- Equipe -->
<section class="bg-[#111] border-t border-gray-800 py-16">
  <div class="max-w-6xl mx-auto px-4">
    <h2 class="text-3xl font-bold text-center mb-10" style="background: linear-gradient(90deg, #8b5cf6, #5c2cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">NOSSA EQUIPE</h2>
    
    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-8 text-center">
      
      <!-- Membro 1 -->
      <div class="bg-[#1a1a1a] p-6 rounded-xl shadow-lg hover:scale-105 transition-transform flex flex-col items-center">
        <img src="/imagens/hydrax/caio.jpg" 
             onclick="openModal(this.src)" 
             class="w-24 h-24 rounded-full border-2 border-[#8b5cf6] object-cover mb-4 cursor-pointer hover:opacity-80 transition" />
        <h4 class="text-xl font-semibold" style="background: linear-gradient(90deg, #8b5cf6, #5c2cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Caio Daniel</h4>
        <p class="text-gray-400 mt-2">Desenvolvedor Back End & BDA Diretor Back End</p>
      </div>
      
      <!-- Membro 2 -->
      <div class="bg-[#1a1a1a] p-6 rounded-xl shadow-lg hover:scale-105 transition-transform flex flex-col items-center">
        <img src="/imagens/hydrax/yago.webp" 
             onclick="openModal(this.src)" 
             class="w-24 h-24 rounded-full border-2 border-[#8b5cf6] object-cover mb-4 cursor-pointer hover:opacity-80 transition" />
        <h4 class="text-xl font-semibold" style="background: linear-gradient(90deg, #8b5cf6, #5c2cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Yago P.</h4>
        <p class="text-gray-400 mt-2">Desenvolvedor Front End & Designer Diretor front End</p>
      </div>
      
      <!-- Membro 3 -->
      <div class="bg-[#1a1a1a] p-6 rounded-xl shadow-lg hover:scale-105 transition-transform flex flex-col items-center">
        <img src="/imagens/hydrax/gabriel.jpeg" 
             onclick="openModal(this.src)" 
             class="w-24 h-24 rounded-full border-2 border-[#8b5cf6] object-cover mb-4 cursor-pointer hover:opacity-80 transition" />
        <h4 class="text-xl font-semibold" style="background: linear-gradient(90deg, #8b5cf6, #5c2cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Gabriel Aparecido</h4>
        <p class="text-gray-400 mt-2">Diretor de Equipe & Organizador</p>
      </div>

      <!-- Linha centralizada para os outros membros -->
      <div class="md:col-span-3 flex justify-center gap-8 flex-wrap">
        
        <!-- Membro 4 -->
        <div class="bg-[#1a1a1a] p-6 rounded-xl shadow-lg hover:scale-105 transition-transform w-[280px] flex flex-col items-center">
          <img src="/imagens/hydrax/ray.jpeg" 
               onclick="openModal(this.src)" 
               class="w-24 h-24 rounded-full border-2 border-[#8b5cf6] object-cover mb-4 cursor-pointer hover:opacity-80 transition" />
          <h4 class="text-xl font-semibold" style="background: linear-gradient(90deg, #8b5cf6, #5c2cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Ray Jhonatan</h4>
          <p class="text-gray-400 mt-2">Desenvolvedor Back End</p>
        </div>
        
        <!-- Membro 5 -->
        <div class="bg-[#1a1a1a] p-6 rounded-xl shadow-lg hover:scale-105 transition-transform w-[280px] flex flex-col items-center">
          <img src="/imagens/hydrax/kaio.jpg" 
               onclick="openModal(this.src)" 
               class="w-24 h-24 rounded-full border-2 border-[#8b5cf6] object-cover mb-4 cursor-pointer hover:opacity-80 transition" />
          <h4 class="text-xl font-semibold" style="background: linear-gradient(90deg, #8b5cf6, #5c2cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Kaio Yushf</h4>
          <p class="text-gray-400 mt-2">Desenvolvedor Front End</p>
        </div>

      </div>
    </div>
  </div>
</section>

  <!-- Modal -->
  <div id="imgModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.95); display: none; align-items: center; justify-content: center; z-index: 9999; padding: 4px;">
    <div style="position: relative; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
      <button onclick="closeModal()" style="position: absolute; top: 8px; right: 8px; color: white; font-size: 56px; font-weight: bold; background: none; border: none; cursor: pointer; z-index: 10000;">&times;</button>
      <img id="modalImg" src="" style="max-width: 99.5vw; max-height: 99.5vh; border-radius: 12px; border: 5px solid #8b5cf6; box-shadow: 0 10px 30px rgba(213,137,27,0.85);" />
    </div>
  </div>

  <script>
    function openModal(src) {
      const modal = document.getElementById('imgModal');
      const modalImg = document.getElementById('modalImg');
      modalImg.src = src;
      modal.style.display = 'flex';
    }

    function closeModal() {
      const modal = document.getElementById('imgModal');
      modal.style.display = 'none';
    }

    document.getElementById('imgModal').addEventListener('click', function(e) {
      if (e.target.id === 'imgModal') closeModal();
    });
  </script>

  <!-- Timeline -->
  <section id="timeline" class="py-16 px-6 max-w-5xl mx-auto">
    <h2 class="text-3xl font-semibold mb-10">Nossa Jornada</h2>
    <div class="relative border-l-4 border-gold pl-6 space-y-10">
      <div>
        <div class="absolute -left-3 w-6 h-6 bg-gold rounded-full border-4 border-black"></div>
        <h3 class="text-xl font-bold">2023 - Início na programação</h3>
        <p class="text-gray-400">Comecei a estudar HTML, CSS e depois fui para o JavaScript e frameworks.</p>
      </div>
      <div>
        <div class="absolute -left-3 w-6 h-6 bg-gold rounded-full border-4 border-black"></div>
        <h3 class="text-xl font-bold">2024 - Primeiro projeto real</h3>
        <p class="text-gray-400">Desenvolvi sistemas para web usando Laravel e Tailwind, e publiquei meus projetos no GitHub.</p>
      </div>
      <div>
        <div class="absolute -left-3 w-6 h-6 bg-gold rounded-full border-4 border-black"></div>
        <h3 class="text-xl font-bold">2025 - Expansão de portfólio</h3>
        <p class="text-gray-400">Comecei a fazer projetos com dashboard, animações, login com autenticação e painéis modernos.</p>
      </div>
    </div>
  </section>

  <!-- Foto da Equipe -->
  <section class="max-w-6xl mx-auto px-4 py-16">
    <h2 class="text-3xl font-semibold text-center mb-8">SURA - CGKRY</h2>
    <div class="flex justify-center">
      <img 
        src="/imagens/hydrax/CGKRY.jpg" 
        alt="Foto da equipe Sura" 
        class="rounded-xl shadow-lg border-2 border-gold hover:opacity-90 transition"
        style="width: 80%; height: auto; max-height: 380px; object-fit: cover;"
      />
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-[#111] text-white px-6 py-10">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row md:justify-between md:items-start gap-8">
      <!-- Lado esquerdo: logo e contato -->
      <div class="flex-1">
        <div class="flex items-center gap-3 mb-3">
          <svg class="w-10 h-10 text-purple-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 2l7 4v6c0 5-3 9-7 9s-7-4-7-9V6l7-4z" />
          </svg>
          <span class="text-lg font-semibold" style="color: #d5891b;">SURA - CGKRY</span>
        </div>
        <div class="text-gray-400 text-sm space-y-1 max-w-sm">
          <p>Email: <span style="color: #d5891b;">contato@sura.com.br</span></p>
          <p>Telefone: <span style="color: #d5891b;">(11) 99999-9999</span></p>
          <p>Endereço: <span style="color: #d5891b;">Rua Exemplo, 123 - Cidade</span></p>
        </div>
      </div>

      <!-- Lado direito: imagem com degradê -->
      <div class="relative w-full md:w-[320px] h-[200px] rounded-lg overflow-hidden flex-shrink-0">
        <img
          src="/imagens/hydrax/Lv.jpg"
          alt="Imagem representativa"
          class="w-full h-full object-cover"
        />
        <div
          class="absolute inset-0"
          style="background: linear-gradient(to right, rgba(213,137,27,0.85), transparent);"
        ></div>
      </div>
    </div>

    <div class="border-t border-gray-700 mt-8"></div>
    <div class="text-center text-gray-400 text-sm mt-4">
      © 2025 <span style="color: #d5891b;">SURA</span> — Todos os direitos reservados.
    </div>
  </footer>

</body>
</html>
