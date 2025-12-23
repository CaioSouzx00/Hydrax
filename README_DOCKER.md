# 🐳 Hydrax - Guia de Instalação e Execução com Docker

Este documento fornece instruções completas para configurar e executar o projeto Hydrax usando Docker.

## 📋 Pré-requisitos

- Docker Engine 20.10 ou superior
- Docker Compose 2.0 ou superior
- Git (para clonar o repositório)

## 🚀 Instalação Rápida

### 1. Clone o repositório (se ainda não tiver)

```bash
git clone <url-do-repositorio>
cd Hydrax
```

### 2. Configure as variáveis de ambiente

Copie o arquivo `.env.example` para `.env`:

```bash
cp .env.example .env
```

Edite o arquivo `.env` e configure as variáveis necessárias:

```env
APP_NAME=Hydrax
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=hydrax
DB_USERNAME=hydrax_user
DB_PASSWORD=hydrax_password
```

### 3. Suba os serviços Docker

Execute o comando para construir e iniciar todos os serviços:

```bash
docker-compose up -d
```

Este comando irá:
- Construir a imagem PHP com todas as dependências
- Criar e iniciar os containers:
  - **mysql**: Banco de dados MySQL 8.0
  - **app**: Aplicação Laravel (PHP-FPM)
  - **nginx**: Servidor web Nginx
  - **redis**: Cache Redis (opcional)

### 4. Aguarde a inicialização

O processo de inicialização pode levar alguns minutos na primeira execução. Você pode acompanhar os logs:

```bash
docker-compose logs -f app
```

O container `app` irá automaticamente:
- Instalar dependências do Composer
- Gerar a chave da aplicação (se necessário)
- Executar as migrations do banco de dados
- Configurar cache (em produção)

### 5. Acesse a aplicação

Após a inicialização, acesse:

- **Aplicação**: http://localhost
- **Banco de dados**: localhost:3306
- **Redis**: localhost:6379

## 📁 Estrutura Docker

```
Hydrax/
├── docker-compose.yml          # Configuração dos serviços
├── Dockerfile                  # Imagem PHP-FPM customizada
├── docker-entrypoint.sh       # Script de inicialização
├── docker/
│   ├── nginx/
│   │   └── default.conf        # Configuração Nginx
│   ├── php/
│   │   └── php.ini             # Configurações PHP
│   └── mysql/
│       └── init/               # Scripts SQL de inicialização
└── .dockerignore               # Arquivos ignorados no build
```

## 🔧 Comandos Úteis

### Ver logs dos serviços

```bash
# Todos os serviços
docker-compose logs -f

# Apenas aplicação
docker-compose logs -f app

# Apenas banco de dados
docker-compose logs -f mysql
```

### Executar comandos Artisan

```bash
# Via docker-compose exec
docker-compose exec app php artisan <comando>

# Exemplos:
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
docker-compose exec app php artisan cache:clear
```

### Acessar shell do container

```bash
docker-compose exec app sh
```

### Parar os serviços

```bash
docker-compose down
```

### Parar e remover volumes (⚠️ ATENÇÃO: Remove dados do banco)

```bash
docker-compose down -v
```

### Reconstruir containers

```bash
docker-compose up -d --build
```

## 🗄️ Banco de Dados

### Credenciais padrão

- **Host**: mysql (dentro da rede Docker) ou localhost (do host)
- **Porta**: 3306
- **Database**: hydrax
- **Usuário**: hydrax_user
- **Senha**: hydrax_password

### Conectar via cliente MySQL

```bash
mysql -h localhost -P 3306 -u hydrax_user -p hydrax
```

### Backup do banco de dados

```bash
docker-compose exec mysql mysqldump -u hydrax_user -phydrax_password hydrax > backup.sql
```

### Restaurar backup

```bash
docker-compose exec -T mysql mysql -u hydrax_user -phydrax_password hydrax < backup.sql
```

## 🔍 Troubleshooting

### Container não inicia

1. Verifique os logs:
   ```bash
   docker-compose logs app
   ```

2. Verifique se as portas estão disponíveis:
   ```bash
   # Linux/Mac
   lsof -i :80
   lsof -i :3306
   
   # Windows
   netstat -ano | findstr :80
   ```

### Erro de permissões

Se houver problemas com permissões de arquivos:

```bash
docker-compose exec app chmod -R 775 storage bootstrap/cache
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
```

### Erro de conexão com banco

1. Verifique se o MySQL está rodando:
   ```bash
   docker-compose ps mysql
   ```

2. Verifique os logs do MySQL:
   ```bash
   docker-compose logs mysql
   ```

3. Aguarde alguns segundos após iniciar os containers (MySQL precisa de tempo para inicializar)

### Limpar cache e otimizar

```bash
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear
```

## 🏗️ Arquitetura

### Serviços Docker

1. **mysql** (MySQL 8.0)
   - Banco de dados principal
   - Volume persistente: `mysql_data`
   - Porta: 3306

2. **app** (PHP 8.2 FPM)
   - Aplicação Laravel
   - Processa requisições PHP
   - Comunica com MySQL e Redis

3. **nginx** (Nginx Alpine)
   - Servidor web
   - Proxy reverso para PHP-FPM
   - Serve arquivos estáticos
   - Porta: 80

4. **redis** (Redis 7)
   - Cache e sessões
   - Volume persistente: `redis_data`
   - Porta: 6379

### Fluxo de Requisição

```
Cliente → Nginx (porta 80) → PHP-FPM (app:9000) → Laravel → MySQL/Redis
```

## 📝 Variáveis de Ambiente Importantes

| Variável | Descrição | Padrão |
|----------|-----------|--------|
| `APP_ENV` | Ambiente da aplicação | `local` |
| `APP_DEBUG` | Modo debug | `true` |
| `DB_HOST` | Host do banco | `mysql` |
| `DB_DATABASE` | Nome do banco | `hydrax` |
| `DB_USERNAME` | Usuário do banco | `hydrax_user` |
| `DB_PASSWORD` | Senha do banco | `hydrax_password` |
| `APP_PORT` | Porta da aplicação | `80` |

## 🎯 Próximos Passos

Após a instalação:

1. Execute os seeders para dados iniciais:
   ```bash
   docker-compose exec app php artisan db:seed
   ```

2. Acesse a aplicação e teste o login

3. Configure o ambiente de produção alterando:
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - Credenciais de banco de dados seguras

## 📚 Documentação Adicional

- [Laravel Documentation](https://laravel.com/docs)
- [Docker Documentation](https://docs.docker.com/)
- [Docker Compose Documentation](https://docs.docker.com/compose/)

## 🆘 Suporte

Em caso de problemas, verifique:
1. Logs dos containers
2. Configurações do `.env`
3. Permissões de arquivos
4. Portas disponíveis

---

**Desenvolvido para TCC - Sistema Hydrax**



