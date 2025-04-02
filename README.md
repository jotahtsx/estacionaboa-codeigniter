# 🚗 EstacionaBoa - Ambiente CodeIgniter 4 com Docker no WSL2

Este projeto configura um ambiente de desenvolvimento **CodeIgniter 4** utilizando **Docker** e **Docker Compose**, facilitando a configuração e o gerenciamento de dependências dentro do **WSL2 (Windows Subsystem for Linux 2)**.

## 🛠️ Pré-requisitos

Antes de iniciar, certifique-se de ter instalado:

- **WSL2** habilitado no Windows ([Guia Oficial](https://learn.microsoft.com/pt-br/windows/wsl/install))
- **Docker Desktop** configurado para usar WSL2
- **Docker Compose** instalado

## 📂 Estrutura do Projeto

```
estacionaboa/
├── www/                # Arquivos do CodeIgniter 4
├── docker-compose.yml  # Configuração dos containers
└── Dockerfile          # Configuração do ambiente PHP/Apache
```

## ⚙️ Configuração do Docker

### `docker-compose.yml`

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
      - estacionaboa

  db:
    image: mysql:8.0
    command: ['--default-authentication-plugin=mysql_native_password', '--character-set-server=utf8mb4', '--collation-server=utf8mb4_general_ci']
    restart: always
    environment:
      MYSQL_DATABASE: estacionaboa
      MYSQL_ROOT_PASSWORD: senha123
    volumes:
      - estacionaboa_mysql_data:/var/lib/mysql
    networks:
      - estacionaboa

  phpmyadmin:
    image: phpmyadmin/phpmyadmin
    environment:
      PMA_HOST: db
      PMA_PORT: 3306
      MYSQL_ROOT_PASSWORD: senha123
    ports:
      - "8080:80"
    networks:
      - estacionaboa

volumes:
  estacionaboa_mysql_data:

networks:
  estacionaboa:
    driver: bridge
```

## 📜 `Dockerfile`

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

# Criar diretório writable e definir permissões
RUN mkdir -p writable && chown -R www-data:www-data writable

# Definir diretório de trabalho
WORKDIR /var/www/html

# Copiar arquivos da aplicação (CodeIgniter)
COPY . /var/www/html

# Configurar Apache para apontar para o diretório public
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Expor porta 80
EXPOSE 80

# Comando para iniciar o Apache
CMD ["apache2-foreground"]
```

## 🚀 Instalação e Execução

1. **Clone este repositório:**
   ```sh
   git clone https://github.com/seu-usuario/estacionaboa.git
   cd estacionaboa
   ```
2. **Inicie os contêineres:**
   ```sh
   docker-compose up --build -d
   ```
3. **Acesse o shell do contêiner web:**
   ```sh
   docker exec -it estacionaboa-web-1 bash
   ```
4. **Instale o CodeIgniter 4 dentro do contêiner:**
   ```sh
   cd /var/www/html && composer create-project codeigniter4/appstarter ..
   ```
5. **Acesse a aplicação:**
   - CodeIgniter: [http://localhost:4500](http://localhost:4500)
   - PHPMyAdmin: [http://localhost:8080](http://localhost:8080)

## ⚡ Configurações Adicionais

🔹 **Banco de Dados:** Edite `app/Config/Database.php` e configure as credenciais do MySQL.  
🔹 **Arquivo `.env`**: Copie `.env.example` para `.env` e ajuste as configurações conforme necessário.

## 🛠️ Solução de Problemas

### ❌ "Whoops! We seem to have hit a snag..."
✅ Verifique permissões do diretório `writable`.
✅ Confirme as credenciais do banco de dados em `app/Config/Database.php`.
✅ Consulte logs em `writable/logs/`.
✅ Certifique-se de que todas as extensões PHP estão instaladas.
✅ Verifique se o arquivo `.env` está configurado corretamente.

### ❌ "Forbidden"
✅ Verifique permissões dos arquivos e diretórios.
✅ Confirme a configuração do Apache e do `.htaccess`.
✅ Verifique se as rotas do CodeIgniter estão configuradas corretamente.
✅ Certifique-se de acessar o diretório `public`.

## 💡 Sobre o WSL2 e Docker

O **WSL2 (Windows Subsystem for Linux 2)** permite rodar um ambiente Linux dentro do Windows, utilizando um **kernel Linux real** otimizado para melhor desempenho. Com o WSL2, podemos:

✅ Executar o **Docker nativamente**, sem necessidade de uma máquina virtual separada.
✅ Acessar arquivos e pastas do Windows diretamente no Linux e vice-versa.
✅ Ter melhor desempenho ao rodar aplicações que dependem de **I/O intensivo**, como bancos de dados e servidores web.

No **EstacionaBoa**, rodamos os contêineres do **Docker** no WSL2, garantindo uma execução otimizada do CodeIgniter 4 com Apache, MySQL e PHPMyAdmin.

## 🤝 Contribuição

Contribuições são bem-vindas! Sinta-se à vontade para abrir **issues** ou **pull requests**.

---

**Autor:** João Manoel 
**Licença:** MIT

