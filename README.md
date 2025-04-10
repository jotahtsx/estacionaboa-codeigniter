# 🚀 EstacionaBoa - CodeIgniter 4 com Docker no WSL2

> Setup rápido, portátil e sem dor de cabeça para desenvolvimento local.

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