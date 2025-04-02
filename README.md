# 🚀 EstacionaBoa - CodeIgniter 4 + Docker

Este projeto utiliza **Docker** para rodar uma aplicação CodeIgniter 4, juntamente com um banco de dados MySQL e uma interface de gerenciamento com PHPMyAdmin.

## 📦 Containers Utilizados

O `docker-compose.yml` cria três containers principais:

1. **Servidor Web (Apache + PHP)**  
   📛 Nome: `estacionaboa-codeigniter-web-1`  
   📂 Pasta do projeto: `/var/www/html`  
   🌍 URL de acesso: [http://localhost:4500](http://localhost:4500)

2. **Banco de Dados (MySQL 8.0)**  
   📛 Nome: `estacionaboa-codeigniter-db-1`  
   📂 Dados persistentes: `/var/lib/mysql`  
   📌 Porta: `3306`

3. **Gerenciador de Banco (PHPMyAdmin)**  
   📛 Nome: `estacionaboa-codeigniter-phpmyadmin-1`  
   🌍 URL de acesso: [http://localhost:8080](http://localhost:8080)

## 🚀 Instalação e Execução

### 1️⃣ Clonar o Repositório
```sh
 git clone git@github.com:jotahtsx/estacionaboa-codeigniter.git
 cd estacionaboa-codeigniter
```

### 2️⃣ Construir e Subir os Containers
```sh
docker-compose up -d --build
```
🔍 Verifique os containers em execução:
```sh
docker ps
```

### 3️⃣ Instalar o CodeIgniter no Container Web
```sh
docker exec -it estacionaboa-codeigniter-web-1 bash
cd /var/www/html && composer create-project codeigniter4/appstarter .
exit
```

### 4️⃣ Configurar Permissões
```sh
docker exec -it estacionaboa-codeigniter-web-1 chmod -R 777 /var/www/html/writable
```

### 5️⃣ Reiniciar os Containers
```sh
docker-compose restart
```

## 🌍 Acessar a Aplicação
- **Aplicação**: [http://localhost:4500](http://localhost:4500)
- **PHPMyAdmin**: [http://localhost:8080](http://localhost:8080)
  - **Usuário**: root
  - **Senha**: jotahdev

## 🛠 Comandos Úteis

📂 **Acessar o Container Web**:
```sh
docker exec -it estacionaboa-codeigniter-web-1 bash
```
📂 **Acessar o Banco MySQL**:
```sh
docker exec -it estacionaboa-codeigniter-db-1 mysql -u root -p
```
📌 **Parar os Containers**:
```sh
docker-compose down
```
📌 **Remover Containers e Imagens**:
```sh
docker-compose down --rmi all
```

## 📜 Observações
- Certifique-se de que **Docker e Docker Compose** estão instalados corretamente.
- Se houver erro de permissão, tente rodar os comandos com `sudo`.
- Se necessário, edite o `.env` para configurar as credenciais do banco de dados.

---
✍️ **Feito por João Manoel** 🚀

