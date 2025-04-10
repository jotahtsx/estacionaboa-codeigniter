# Etapa 1: Baixar Composer
FROM composer:latest AS composer

# Etapa 2: Ambiente PHP + Apache com Composer embutido
FROM php:8.1-apache

# Copiar Composer da imagem anterior
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libicu-dev \
    libxslt-dev \
    libonig-dev

# Configurar e instalar extensões PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd intl xsl zip pdo pdo_mysql mbstring mysqli

# Habilitar o módulo rewrite do Apache
RUN a2enmod rewrite

# Criar diretório writable (CodeIgniter)
RUN mkdir -p writable && chown -R www-data:www-data writable

# Definir diretório de trabalho
WORKDIR /var/www/html

# Copiar arquivos do projeto para dentro do container
COPY . /var/www/html

# Configurar o Apache para apontar para o diretório `public`
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Expor porta do Apache
EXPOSE 80

# Iniciar Apache no container
CMD ["apache2-foreground"]
