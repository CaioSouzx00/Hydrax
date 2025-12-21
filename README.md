# 🌟 Hydrax — E-commerce de Tênis

<p align="center">
  <img src="https://via.placeholder.com/1000x260?text=Hydrax+-+E-commerce+de+Tênis+em+Laravel" alt="Hydrax Banner">
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-red?style=for-the-badge&logo=laravel">
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css">
  <img src="https://img.shields.io/badge/MySQL-8.x-4479A1?style=for-the-badge&logo=mysql">
  <img src="https://img.shields.io/badge/TCC-Projeto_Acadêmico-blueviolet?style=for-the-badge">
</p>

---

## 🛍️ Sobre o Projeto

O **Hydrax** é um sistema web desenvolvido em **Laravel**, focado na compra e venda de tênis, oferecendo uma experiência **moderna, segura e orientada a dados**.

O projeto foi desenvolvido como **Trabalho de Conclusão de Curso (TCC)**, simulando um **e-commerce real**, com fluxo completo de usuários, fornecedores, pedidos e **dashboards analíticos**.

---

## 🎯 Objetivos

- Gerenciar produtos e estoques em tempo real  
- Oferecer uma experiência de compra fluida  
- Centralizar métricas em dashboards visuais  
- Aplicar boas práticas de desenvolvimento web  

---

## 💻 Tecnologias Utilizadas

- **Backend:** Laravel 12.x  
- **Frontend:** Blade Templates + Tailwind CSS  
- **Banco de Dados:** MySQL / MariaDB  
- **Autenticação:** Laravel Breeze  
- **Pagamentos:** PIX  
- **Emails:** Jobs & Mailables  
- **Gráficos e Dashboards:** Chart.js  
- **Versionamento:** Git & GitHub  

---

## 🔹 Funcionalidades do Sistema

### 👤 Gestão de Usuários e Endereços
- Cadastro, edição e exclusão de usuários  
- Múltiplos endereços por usuário  
- Controle de permissões  

---

### 🏪 Gestão de Fornecedores e Produtos
- Cadastro de fornecedores  
- Cadastro e edição de produtos  
- Controle de estoque em tempo real  
- Cards de produtos estilizados  
- Filtros por marca, tamanho, gênero e estilo  

---

### 🛒 Carrinho e Pedidos
- Adição e remoção de produtos no carrinho  
- Finalização de pedidos via **PIX**  
- Histórico completo de pedidos  
- Notificação de carrinho abandonado por e-mail  

---

## 📊 Dashboard e Visualização de Dados

O Hydrax possui um **dashboard administrativo completo**, permitindo a análise visual dos dados do sistema.

### 📈 Gráficos Implementados

- 📊 **Vendas por período (linha)**
- 📦 **Produtos mais vendidos (barra)**
- 🏷️ **Categorias mais populares (pizza / donut)**
- 🧮 **Pedidos por status**
- 💰 **Faturamento mensal e total**

<p align="center">
  <img src="https://via.placeholder.com/480x300?text=Gr%C3%A1fico+de+Vendas" />
  <img src="https://via.placeholder.com/480x300?text=Produtos+Mais+Vendidos" />
</p>

<p align="center">
  <img src="https://via.placeholder.com/480x300?text=Categorias+Mais+Vendidas" />
  <img src="https://via.placeholder.com/480x300?text=Pedidos+por+Status" />
</p>

---

## 🎨 Interface e Experiência do Usuário

- Layout moderno inspirado em grandes e-commerces  
- Uso de **gradientes, sombras e animações suaves**  
- Cards de produtos com imagens, preços e promoções  
- Interface totalmente responsiva (desktop e mobile)  

<p align="center">
  <img src="https://via.placeholder.com/480x300?text=Card+de+Produto" />
  <img src="https://via.placeholder.com/480x300?text=Dashboard+Administrativo" />
</p>

---

## 🔒 Segurança

- Login e registro seguros  
- Recuperação de senha via código por e-mail  
- Middleware de proteção de rotas  
- Validação de dados no backend  

---

## ⚡ Otimizações de Performance

### Cache para Produção
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer dump-autoload -o
