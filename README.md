# 🚀 EstacionaBoa - CodeIgniter 4 com Docker no WSL2

Este projeto configura um ambiente de desenvolvimento **CodeIgniter 4** usando **Docker** e **Docker Compose**, facilitando a configuração e o gerenciamento de dependências no **WSL2**.

---

## 📌 Pré-requisitos

- Docker e Docker Compose instalados em seu sistema.
- WSL2 configurado corretamente.

---

## 📂 Estrutura do Projeto

```
estacionaboa-codeigniter/
├── www/                  # Arquivos do CodeIgniter
├── docker-compose.yml    # Configuração do Docker Compose
└── Dockerfile            # Configuração do ambiente PHP e Apache
```

---

## ⚙️ Configuração do Docker

### 📄 Arquivo `docker-compose.yml`

```yaml
version: "3.8"

services:
  web:
    build:
      context: .
      dockerfile: Dockerfile
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
    command: ['--default-authentication-plugin=mysql_native_password', '--character-set-server=utf8mb4', '--collation-server=utf8mb4_general_ci']
    restart: always
    environment:
      MYSQL_DATABASE: estacionaboa
      MYSQL_ROOT_PASSWORD: jotahdev
    volumes:
      - codeigniter_mysql_data:/var/lib/mysql
    networks:
      - codeigniter
    ports:
      - "3306:3306"

  phpmyadmin:
    image: phpmyadmin/phpmyadmin
    environment:
      PMA_HOST: db
      PMA_PORT: 3306
      MYSQL_ROOT_PASSWORD: sextafeira
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

---

### 📄 Arquivo `Dockerfile`

```dockerfile
FROM php:8.1-apache

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
    && docker-php-ext-install gd intl xsl zip pdo pdo_mysql mbstring

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar Apache
RUN a2enmod rewrite

# Criar diretório writable e configurar permissões
RUN mkdir -p /var/www/html/writable && chown -R www-data:www-data /var/www/html/writable

# Definir diretório de trabalho
WORKDIR /var/www/html

# Copiar arquivos da aplicação (CodeIgniter)
COPY . /var/www/html

# Configurar Apache para apontar para o diretório public
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Expor a porta 80
EXPOSE 80

# Comando para iniciar o Apache
CMD ["apache2-foreground"]
```

---

## 🚀 Instalação e Execução

1. **Clone este repositório**:
   ```sh
   git clone https://github.com/seuusuario/estacionaboa-codeigniter.git
   ```
2. **Navegue até o diretório do projeto**:
   ```sh
   cd estacionaboa-codeigniter
   ```
3. **Inicie os contêineres**:
   ```sh
   docker-compose up --build -d
   ```
4. **Acesse o shell do contêiner web**:
   ```sh
   docker exec -it nome-do-container-web bash
   ```
5. **Instale o CodeIgniter 4**:
   ```sh
   cd /var/www/html && composer create-project codeigniter4/appstarter .
   ```
6. **Acesse a aplicação**:
   - Aplicação CodeIgniter: [http://localhost:4500](http://localhost:4500)
   - PHPMyAdmin: [http://localhost:8080](http://localhost:8080)

---

## 🔧 Configurações Adicionais

- **Banco de Dados**: Edite `app/Config/Database.php` com as credenciais do MySQL.
- **Arquivo `.env`**: Copie `.env.example` para `.env` e ajuste as variáveis.

---

## 🛠 Solução de Problemas

### ❌ "Whoops! We seem to have hit a snag..."

1. Verifique permissões do diretório writable:
   ```sh
   docker exec -it nome-do-container-web chmod -R 777 /var/www/html/writable
   ```
2. Verifique as configurações do banco de dados.
3. Verifique logs em `writable/logs`.
4. Verifique se as extensões PHP necessárias estão instaladas.
5. Verifique o arquivo `.env`.

### 🚫 "Forbidden"

1. Verifique permissões de arquivos e diretórios.
2. Verifique configuração do Apache e `.htaccess`.
3. Certifique-se de acessar o diretório `public`.

---

## 🤝 Contribuição

Contribuições são bem-vindas! Sinta-se à vontade para abrir **issues** ou **pull requests**. 

💙 Obrigado por usar o **EstacionaBoa**! 🚗💨

