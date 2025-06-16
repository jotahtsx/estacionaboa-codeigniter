# 🚀 EstacionaBoa - CodeIgniter 4 com Docker no WSL2

> Setup rápido, portátil e sem dor de cabeça para desenvolvimento local com CodeIgniter 4 + Docker.

---

## 📌 Pré-requisitos

- Docker e Docker Compose instalados
- WSL2 configurado corretamente
- Permissões adequadas no seu sistema de arquivos (especialmente no WSL2)

---

## 🧪 Primeiros passos: clonando o projeto

```bash
git clone https://github.com/jotahtsx/estacionaboa-codeigniter.git
cd estacionaboa-codeigniter
```

---

## 📂 Estrutura do Projeto

| Caminho                         | Descrição                              |
|----------------------------------|------------------------------------------|
| `estacionaboa-codeigniter/`     | Pasta raiz do projeto                    |
| ├── `www/`                       | Código da aplicação CodeIgniter         |
| ├── `docker-compose.yml`        | Orquestra os serviços (web, db, etc.)   |
| ├── `Dockerfile`                | Configuração do container Apache + PHP  |
| └── `Dockerfile.phpmyadmin`     | Configuração do container do phpMyAdmin |

---

## ⚙️ Configuração do Docker

### 📄 docker-compose.yml

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

---

### 📄 Dockerfile (Apache + PHP + Composer)

```Dockerfile
FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    zip unzip libzip-dev libpng-dev libjpeg-dev \
    libfreetype6-dev libxml2-dev libcurl4-openssl-dev \
    libicu-dev libxslt-dev libonig-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd intl xsl zip pdo pdo_mysql mbstring

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN a2enmod rewrite

RUN mkdir -p writable && chown -R www-data:www-data writable

WORKDIR /var/www/html
COPY . /var/www/html

RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

EXPOSE 80

CMD ["apache2-foreground"]
```

---

### 📄 Dockerfile.phpmyadmin

```Dockerfile
FROM phpmyadmin/phpmyadmin
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
```

---

## 🚀 Instalação e Execução

1. **Suba os containers:**
   ```bash
   docker-compose up --build -d
   ```

2. **Acesse o container da aplicação:**
   ```bash
   docker exec -it estacionaboa-web bash
   ```

3. **Instale as dependências:**
   ```bash
   composer install
   ```

4. **Crie o arquivo `.env` e configure o ambiente:**
   ```bash
   cp .env.example .env
   ```

4. **Configure o ambiente:**
   ```bash
   sed -i 's/^#\?\s*CI_ENVIRONMENT\s*=.*/CI_ENVIRONMENT = development/' .env
   ```

5. **Saia do container:**
   ```bash
   exit
   ```

6. **Ajuste as permissões do diretório `writable`:**
   ```bash
   docker exec -it estacionaboa-web chmod -R 777 /var/www/html/writable
   ```

---

## ✅ Pós-instalação

### Permissões do projeto

Caso tenha erro ao editar arquivos no VS Code ou outro editor, ajuste permissões no host:

```bash
sudo chown -R $USER:$USER www
```

---

## 🔧 Configuração do ambiente e cache

Verifique se o ambiente está correto:

```bash
docker exec -it estacionaboa-web bash
php spark env
```

Se necessário, limpe o cache:

```bash
php spark cache:clear
```

---

## 🗂 Rodando Migrations e Seeders

### 📥 Rodar todas as migrations (inclusive dos pacotes)

```bash
php spark migrate --all
```

### 📊 Verificar status das migrations

```bash
php spark migrate:status
```

### 🌱 Rodar seeder

```bash
php spark db:seed UserSeeder
```

---

## 📌 Atenção com migrations duplicadas

Evite conflitos com migrations dos pacotes `codeigniter4/settings` e `codeigniter4/shield`.

- Eles já criam tabelas como `settings`, `auth_*`, etc.
- Não crie migrations próprias para essas tabelas.

### 💣 Se deu ruim: "Table already exists"

1. Apague a migration duplicada.
2. Rode com fé:
   ```bash
   php spark migrate --all
   ```

---

## 🧼 Resetando tudo

Se o banco virou zona:

```bash
php spark migrate:refresh
php spark migrate --all
```

---

## 🖥️ Acessando a aplicação

- **Aplicação**: [http://localhost:4500](http://localhost:4500)
- **phpMyAdmin**: [http://localhost:8080](http://localhost:8080)

---

## 🧰 Solução de Problemas

### ❌ "Whoops! We seem to have hit a snag..."

1. Verifique permissões do `writable`:
   ```bash
   docker exec -it estacionaboa-web chmod -R 777 /var/www/html/writable
   ```
2. Verifique credenciais e conexão do banco.
3. Veja os logs em `writable/logs`.
4. Confira se extensões PHP foram instaladas corretamente.
5. Verifique o arquivo `.env`.

### ❌ "Forbidden" 

#### Caso ocorra algum problema no envio de imagens, tente essa solução abaixo:

- Verifique permissões de arquivos/pastas.
- Na pasta do projeto, digite: `docker exec -it estacionaboa-web bash`
- Então digite: `chown -R www-data:www-data public/uploads`
- E também: `chmod -R 0755 public/uploads`

---

## ⚠️ Dica final

> **"Antes de rodar migrations na doida, dá uma olhada se você não tá chamando duas mães pra mesma tabela."** – Dev experiente

---

Feito com ❤️ por [jotahtsx](https://github.com/jotahtsx)