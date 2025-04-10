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
---

## 🚀 Instalação e Execução
1. **Clone este repositório**:
   ```sh
   git clone git@github.com:jotahtsx/estacionaboa-codeigniter.git
   ```
   Ou, se quiser usar o HTTPS:

   ```sh
   git clone https://github.com/jotahtsx/estacionaboa-codeigniter.git
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

## ✅ Pós-instalação (configuração do ambiente)
Dentro do contêiner estacionaboa-web:

1. **Copie o arquivo .env**:
Utilizando o comando:
sh
   cp .env.example .env

2. **Defina o ambiente como development**:
sh
   sed -i 's/^CI_ENVIRONMENT = .*/CI_ENVIRONMENT = development/' .env 

3. **Limpe o cache (caso necessário)**:
sh
   php spark cache:clear    

4. **Verifique o ambiente atual**:
sh
   php spark env    

---

## 🗓 Rodando as migrações

Ainda no contêiner:

```bash
php spark migrate
```

Você verá algo como:

Running all new migrations...
Done migrations.

### 📦 Migrations de Pacotes Externos (como Settings)

Alguns pacotes do CodeIgniter 4, como codeigniter4/settings ou codeigniter4/shield, possuem suas próprias migrations que **não são executadas automaticamente** com php spark migrate.

#### ✅ Para rodar todas as migrations (inclusive dos pacotes):
bash
php spark migrate --all

#### ✅ Ou para um pacote específico (ex: Settings):
bash
php spark migrate --namespace CodeIgniter\\Settings

> ⚠️ Lembre-se das duas barras \\ no terminal para escapar corretamente o namespace.

#### 🔍 Verificando o status das migrations:
bash
php spark migrate:status

### 🗂️ Tabelas migradas

Você vai se deparar com as seguintes tabelas que foram criadas no banco de dados após as migrações:

| Namespace            | Versão            | Nome do Arquivo     | Grupo   | Migrado em          | Lote |
|----------------------|-------------------|---------------------|---------|----------------------|------|
| App                  | 2025-04-08-194938 | CreateSettingsTable | default | 2025-04-08 19:50:40  | 1    |
| CodeIgniter\Shield   | 2020-12-28-223112 | create_auth_tables  | default | 2025-04-08 19:55:01  | 2    |
| CodeIgniter\Settings | 2021-07-04-041948 | CreateSettingsTable | default | 2025-04-08 19:55:01  | 2    |
| CodeIgniter\Settings | 2021-11-14-143905 | AddContextColumn    | default | 2025-04-08 19:55:01  | 2    |

Para confirmar, essas são as seguintes tabelas que foram criadas no seu banco de dados:

- auth_groups_users
- auth_identities
- auth_logins
- auth_permissions_users
- auth_remember_tokens
- auth_token_logins
- migrations
- settings
- users

---

Este projeto utiliza pacotes como `codeigniter4/settings` e `codeigniter4/shield`, que **já fornecem migrations próprias**.

### 👉 O que você precisa saber:
- **Não crie migrations duplicadas** com nomes de tabelas que já são criadas pelos pacotes (como `settings`, `auth_*`, etc.).
- Já existe uma migration em `vendor/codeigniter4/settings` que cria a tabela `settings`. **Não crie outra no seu app.**
- Rodar `php spark migrate --all` é obrigatório para aplicar também as migrations desses pacotes.

### 💥 Para rodar as migrations corretamente:
## Este comando DELETA todas as tabelas do banco. Use com cuidado!
```bash
php spark migrate:reset
```

# Após resetar, rode todas as migrations novamente
```bash
php spark migrate --all
```

---

### ✅ Dica do Tio Jão

Se você já bagunçou todas as migrations e o banco tá parecendo um campo de batalha, segue o combo da faxina:

```bash
php spark migrate:reset
```
```bash
php spark migrate --all
```

## 🕵️ Onde tá o vacilo?

Dá uma olhada em:

## 🛠️ Solução para o erro "Table already exists"

Se tiver algo com nome tipo `CreateSettingsTable.php`, e você já usa o pacote que também cria essa tabela, então temos **duas migrations querendo ser mãe da mesma tabela**.  
Aí o MySQL pira com razão.

---

### 🛠️ Solução para não bater o carro

- Apaga ou renomeia a migration duplicada.
- **Respira.**

---

- Roda com orgulho:

```bash
php spark migrate --all
```
