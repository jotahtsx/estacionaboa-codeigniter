# 🚗 EstacionaBoa - CodeIgniter 4 + Docker + WSL2

Este projeto utiliza CodeIgniter 4, Docker e WSL2 para criar um ambiente de desenvolvimento moderno e eficiente.

## 🏗️ Instalação

### 1️⃣ Clonar o repositório
```sh
git clone https://github.com/seu-usuario/estacionaboa-codeigniter.git
cd estacionaboa-codeigniter
```

### 2️⃣ Construir e iniciar os contêineres
```sh
docker-compose up -d --build
```

### 3️⃣ Instalar as dependências do CodeIgniter
```sh
docker exec -it estacionaboa-codeigniter-web-1 bash -c "cd /var/www/html && composer create-project codeigniter4/appstarter ."
```

### 4️⃣ Ajustar permissões
```sh
docker exec -it estacionaboa-codeigniter-web-1 chmod -R 777 /var/www/html/writable
```

## 🐳 Comandos Docker úteis

### Acessar o terminal do contêiner web
```sh
docker exec -it estacionaboa-codeigniter-web-1 bash
```

### Acessar o terminal do banco de dados
```sh
docker exec -it estacionaboa-codeigniter-db-1 mysql -u root -p
```

### Listar os contêineres ativos
```sh
docker ps
```

### Parar os contêineres
```sh
docker-compose down
```

## 🌐 Acessos

- Aplicação: [http://localhost:4500](http://localhost:4500)
- phpMyAdmin: [http://localhost:8080](http://localhost:8080)

🚀 Agora o projeto está pronto para uso!

