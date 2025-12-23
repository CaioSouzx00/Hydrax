# Dockerfile para Laravel com PHP 8.2 FPM
FROM php:8.2-fpm

# Definir diretório de trabalho
WORKDIR /var/www/html

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensões PHP necessárias
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    opcache

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar script de entrada primeiro
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Copiar arquivos da aplicação
COPY . /var/www/html

# Configurar permissões (como root antes de mudar usuário)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache || true

# Expor porta 9000 (PHP-FPM)
EXPOSE 9000

# Script de entrada (rodará como root para poder executar comandos)
ENTRYPOINT ["docker-entrypoint.sh"]

