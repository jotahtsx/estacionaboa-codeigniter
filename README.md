# 🚀 EstacionaBoa - CodeIgniter 4 com Docker no WSL2

Este projeto configura um ambiente de desenvolvimento **CodeIgniter 4** usando **Docker** e **Docker Compose**, facilitando o setup e a gestão das dependências no **WSL2**.

---

## 📌 Pré-requisitos

- Docker e Docker Compose instalados em seu sistema.
- WSL2 configurado corretamente.

---

## 📂 Estrutura do Projeto

```bash
estacionaboa-codeigniter/
├── www/                    # Arquivos do CodeIgniter
├── docker-compose.yml      # Configuração do Docker Compose
├── Dockerfile              # Configuração do ambiente PHP e Apache
└── Dockerfile.phpmyadmin   # Configuração do phpMyAdmin
```

---

## ⚙️ Configuração do Docker

### 📄 Arquivo `docker-compose.yml`

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
      MYSQL_ROOT_PASSWORD: jotahdev
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

```Dockerfile
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

---

### 📄 Arquivo `Dockerfile.phpmyadmin`
```Dockerfile.phpmyadmin
FROM phpmyadmin/phpmyadmin

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
```

## 🚀 Instalação e Execução

1. **Clone este repositório**:
   ```sh
   git clone git clone git@github.com:jotahtsx/estacionaboa-codeigniter.git
   ```
   Ou, se quiser usar o HTTPS (menos indicado se você já configurou o .ssh), seria:

   ```sh
   git clone git clone git@github.com:jotahtsx/estacionaboa-codeigniter.git
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
   docker exec -it estacionaboa-web bash
   ```
5. **Rode o composer para instalar as dependências**:
   ```sh
   composer install
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
   docker exec -it estacionaboa-web chmod -R 777 /var/www/html/writable
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

### ⚠️ Notas Importantes

#### 🛠 Permissão da pasta `www`

Caso você não consiga editar os arquivos da pasta `www/` no seu host (por exemplo, erros de permissão ao tentar salvar arquivos), isso pode estar relacionado ao fato de o contêiner Docker ter criado os arquivos com outro usuário.

Para resolver, execute o comando abaixo no terminal:

```bash
sudo chown -R $USER:$USER www
```

---

### 🤝 Contribuição

Contribuições são bem-vindas! Sinta-se à vontade para abrir **issues** ou **pull requests**. 

💙 Obrigado por usar o **EstacionaBoa**! 🚗💨
