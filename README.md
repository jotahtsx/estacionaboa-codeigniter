# 🚀 EstacionaBoa - CodeIgniter 4 com Docker no WSL2

> Setup rápido, portátil e sem dor de cabeça para desenvolvimento local.

---

## 📌 Pré-requisitos

- Docker e Docker Compose instalados em seu sistema.
- WSL2 configurado corretamente.

---

## 📂 Estrutura do Projeto

| Diretório/Arquivo            | Descrição                                |
|------------------------------|------------------------------------------|
| `estacionaboa-codeigniter/`   | Pasta principal do projeto              |
| `├── www/`                    | Arquivos do CodeIgniter                  |
| `├── docker-compose.yml`      | Configuração do Docker Compose           |
| `├── Dockerfile`              | Configuração do ambiente PHP e Apache   |
| `└── Dockerfile.phpmyadmin`   | Configuração do phpMyAdmin               |


---

## ⚙️ Configuração do Docker

### 📄 Arquivo docker-compose.yml

```yaml
services:
  web:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: estacionaboa-web
    ports:
      - "4500:80"
    volumes:
      - ./www:/var/www/html
    working_dir: /var/www/html
    depends_on:
      - db
    environment:
      TZ: America/Fortaleza
    networks:
      - codeigniter

  db:
    image: mysql:8.0
    container_name: estacionaboa-db
    command: [
      '--default-authentication-plugin=mysql_native_password',
      '--character-set-server=utf8mb4',
      '--collation-server=utf8mb4_general_ci'
    ]
    restart: always
    environment:
      MYSQL_DATABASE: estacionaboa
      MYSQL_ROOT_PASSWORD: sextafeira
    volumes:
      - codeigniter_mysql_data:/var/lib/mysql
    networks:
      - codeigniter
    ports:
      - "3306:3306"

  phpmyadmin:
    build:
      context: .
      dockerfile: Dockerfile.phpmyadmin
    container_name: estacionaboa-phpmyadmin
    environment:
      PMA_HOST: db
      PMA_PORT: 3306
      MYSQL_ROOT_PASSWORD: jotahdev
    ports:
      - "8080:80"
    networks:
      - codeigniter

volumes:
  codeigniter_mysql_data:

networks:
  codeigniter:
    driver: bridge
 ```

### 📄 Arquivo Docker
```Dockerfile
FROM php:8.1-apache

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y     zip     unzip     libzip-dev     libpng-dev     libjpeg-dev     libfreetype6-dev     libxml2-dev     libcurl4-openssl-dev     libicu-dev     libxslt-dev     libonig-dev

# Configurar e instalar extensões PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg     && docker-php-ext-install gd intl xsl zip pdo pdo_mysql mbstring

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar Apache
RUN a2enmod rewrite

# Criar o diretório writable
RUN mkdir -p writable

# Configurar permissões
RUN chown -R www-data:www-data writable

# Definir diretório de trabalho
WORKDIR /var/www/html

# Copiar arquivos da aplicação (CodeIgniter)
COPY . /var/www/html

# Configurar Apache para apontar para o diretório public
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Adicionar ServerName após configuração do Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Expor a porta 80
EXPOSE 80

# Comando para iniciar o Apache
CMD ["apache2-foreground"]
```

### 📄 Arquivo Docker phpmyadmin
```Dockerfile.phpmyadmin
  FROM phpmyadmin/phpmyadmin
  RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
```