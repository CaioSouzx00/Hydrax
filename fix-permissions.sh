#!/bin/bash
# Script para corrigir permissões do Laravel no Docker

echo "🔧 Corrigindo permissões do Laravel..."

docker compose exec app sh -c "
    # Criar diretórios se não existirem
    mkdir -p /var/www/html/storage/framework/views
    mkdir -p /var/www/html/storage/framework/cache
    mkdir -p /var/www/html/storage/framework/sessions
    mkdir -p /var/www/html/storage/logs
    mkdir -p /var/www/html/bootstrap/cache

    # Ajustar permissões
    chown -R www-data:www-data /var/www/html/storage
    chown -R www-data:www-data /var/www/html/bootstrap/cache
    chmod -R 775 /var/www/html/storage
    chmod -R 775 /var/www/html/bootstrap/cache

    # Limpar cache de views
    rm -rf /var/www/html/storage/framework/views/*.php
"

echo "✅ Permissões corrigidas!"
echo "🔄 Reiniciando container app..."
docker compose restart app

echo "✅ Pronto! Tente acessar a aplicação novamente."



