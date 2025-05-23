# 🚀 EstacionaBoa - CodeIgniter 4 com Docker no WSL2

> Setup rápido, portátil e sem dor de cabeça para desenvolvimento local.

---

## 📌 Pré-requisitos

- Docker e Docker Compose instalados em seu sistema.
- WSL2 configurado corretamente.

---

## 📂 Estrutura do Projeto

| Diretório/Arquivo           | Descrição                             |
| --------------------------- | ------------------------------------- |
| `estacionaboa-codeigniter/` | Pasta principal do projeto            |
| `├── www/`                  | Arquivos do CodeIgniter               |
| `├── docker-compose.yml`    | Configuração do Docker Compose        |
| `├── Dockerfile`            | Configuração do ambiente PHP e Apache |
| `└── Dockerfile.phpmyadmin` | Configuração do phpMyAdmin            |

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

3. **Inicie os containers**:
   ```sh
   docker-compose up --build -d
   ```

4. **Acesse o shell do container web**:
   ```sh
   docker exec -it estacionaboa-web bash
   ```

5. **Rode o composer para instalar as dependências**:
   ```sh
   composer install
   ```
6. **Saia do container**:
   ```sh
   exit
   ```

7. **Ajuste as permissões do diretório writable**:
   ```sh
   docker exec -it estacionaboa-web chmod -R 777 /var/www/html/writable
   ``` 

---

## ✅ Pós-instalação (configuração do ambiente)

1. **Dar permissão de escrita no projeto (evita erros com `.env`)**  
   
   Antes de qualquer coisa, certifique-se de ter permissões:

   ```bash
   sudo chown -R $USER:$USER www
   ```

**Copiar o arquivo de ambiente**  
   Novamente entre no container para criar uma cópia base do `.env` a partir do exemplo:

  Entrar no container(caso tenha esquecido... isso é preocupante se esqueceu)

   ```sh
  docker exec -it estacionaboa-web bash 
  ```

  e depois...

   ```bash
   cp .env.example .env
   ```

**Definir o ambiente como `development`**  
   Remove o comentário e define o valor:
   ```bash
   sed -i 's/^#\?\s*CI_ENVIRONMENT\s*=.*/CI_ENVIRONMENT = development/' .env
  ```

**Limpe o cache (caso necessário)**:
   ```sh
  php spark cache:clear
   ```

**Verifique o ambiente atual**  
Confirme se o ambiente está definido corretamente como `development`:  
```bash
php spark env
```

---

## 🗓 Rodando as migrações

#### ✅ Para rodar todas as migrations (inclusive dos pacotes):
```bash
php spark migrate --all
```

#### 🔍 Verificando o status das migrations:
```bash
php spark migrate:status
```

### 🗂️ Tabelas migradas

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

## 2️⃣ Rodando o seeder

Após executar as migrações, você pode popular o banco com dados iniciais utilizando o seeder:

```bash
php spark db:seed UserSeeder
```

---

Este projeto utiliza pacotes como `codeigniter4/settings` e `codeigniter4/shield`, que **já fornecem migrations próprias**.

### 👉 O que você precisa saber:
- **Não crie migrations duplicadas** com nomes de tabelas que já são criadas pelos pacotes (como `settings`, `auth_*`, etc.).
- Já existe uma migration em `vendor/codeigniter4/settings` que cria a tabela `settings`. **Não crie outra no seu app.**
- Rodar `php spark migrate --all` é obrigatório para aplicar também as migrations desses pacotes.

---

**Acesse a aplicação**:
- **Aplicação CodeIgniter**: [http://localhost:4500](http://localhost:4500)
- **PHPMyAdmin**: [http://localhost:8080](http://localhost:8080)  

---

### ✅ Dica do Tio Jão

Se você já bagunçou todas as migrations e o banco tá parecendo um campo de batalha, segue o combo da faxina:

```bash
php spark migrate:refresh
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
---

## ☠️ A DICA ASSOMBRADA DO DEV MALDITO™  

> **Você achou que tinha apagado tudo... mas ela voltou.**  
> A maldição da tabela `settings` ainda vive! 😱

---

### 👁️‍🗨️ O SINAL DO ERRO  
Se ao rodar o ritual:
```bash
php spark migrate --all
```
Table 'settings' already exists

⚰️ É tarde demais. Você despertou a duplicação proibida. Volte 2 out 3 passos.

---

## 🔧 Configurações Adicionais

- **Banco de Dados**: Edite app/Config/Database.php com as credenciais do MySQL.
- **Arquivo .env**: Copie .env.example para .env e ajuste as variáveis.

---

## 🛠 Solução de Problemas

### ❌ "Whoops! We seem to have hit a snag..."

1. Verifique permissões do diretório writable:
   
<pre> ```bash docker exec -it estacionaboa-web chmod -R 777 /var/www/html/writable ``` </pre>

2. Verifique as configurações do banco de dados.
3. Verifique logs em writable/logs.
4. Verifique se as extensões PHP necessárias estão instaladas.
5. Verifique o arquivo .env.

### ❌ "Forbidden"

1. Verifique permissões de arquivos e diretórios.
2. Verifique configuração do Apache e .htaccess.
3. Certifique-se de acessar o diretório public.

---

### ⚠️ Notas Importantes

#### 🛠 Permissão da pasta www

Caso você não consiga editar os arquivos da pasta www/ no seu host (por exemplo, erros de permissão ao tentar salvar arquivos), isso pode estar relacionado ao fato de o container Docker ter criado os arquivos com outro usuário.

Para resolver, execute o comando abaixo no terminal, primeiro saia do container com o comando exit

```bash
exit
```
E depois:

```bash
sudo chown -R $USER:$USER www
```
---

### 🤝 Contribuição

Contribuições são bem-vindas! Sinta-se à vontade para abrir **issues** ou **pull requests**. 
