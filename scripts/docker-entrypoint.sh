#!/bin/sh
set -e

echo "🚀 Iniciando configuração do Laravel..."

# Garantir que os diretórios existam e tenham permissões corretas
echo "🔧 Configurando permissões..."
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/framework/cache
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/bootstrap/cache

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache || true

# Aguardar MySQL estar pronto
echo "⏳ Aguardando MySQL..."
until php artisan db:show &> /dev/null 2>&1 || [ $? -eq 1 ]; do
    echo "MySQL não está pronto ainda. Aguardando..."
    sleep 2
done

echo "✅ MySQL está pronto!"

# Instalar dependências se necessário
if [ ! -d "vendor" ]; then
    echo "📦 Instalando dependências Composer..."
    composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev
fi

# Gerar chave da aplicação se não existir
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    echo "🔑 Gerando chave da aplicação..."
    php artisan key:generate --force || true
fi

# Executar migrations
echo "🗄️  Executando migrations..."
php artisan migrate --force || true

# Limpar e cachear configurações (apenas em produção)
if [ "$APP_ENV" = "production" ]; then
    echo "⚡ Otimizando aplicação..."
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

echo "✅ Configuração concluída!"

# Garantir permissões corretas antes de iniciar PHP-FPM
echo "🔧 Configurando permissões..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache || true

# Executar PHP-FPM como www-data
exec php-fpm

