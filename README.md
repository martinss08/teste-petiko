# 📝 Projeto Laravel + Vue.js – Gerenciador de Tarefas

Este projeto é uma aplicação de gerenciamento de tarefas desenvolvida com Laravel (backend) e Vue.js (frontend via Inertia.js), com ambiente configurado via Docker.

---

## 🚀 Como rodar o projeto localmente

### 1. Clone o repositório

```bash
git clone https://github.com/seu-usuario/seu-repositorio.git
cd seu-repositorio
```

### 2. Suba os containers com Docker Compose

```bash
docker compose up -d
```

> Isso irá subir os serviços: PHP, MySQL, Nginx e phpMyAdmin (caso esteja configurado).

---

### 3. Instale as dependências do Laravel

```bash
docker compose exec app composer install
```

### 4. Instale as dependências do front-end (Vue.js + Bootstrap)

```bash
docker compose exec app npm install
```

### 5. Gere a key da aplicação e rode as migrations + seeders

```bash
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
```

---

## 👤 Usuário padrão (seeded)

Após rodar os seeders, você poderá acessar com:

- **Email:** `admin@example.com`  
- **Senha:** `123456`

---

## 🐞 Comandos úteis

| Ação                          | Comando                                                 |
|------------------------------|----------------------------------------------------------|
| Subir containers             | `docker compose up -d`                                   |
| Parar containers             | `docker compose down`                                    |
| Compilar assets frontend     | `npm run dev`                                            |
| Rodar os testes                                                                         | 
|    `docker compose exec app php artisan test --filter=UserControllerTest`             |
|    `docker compose exec app php artisan test --filter=TarefaControllerTest`             |


---

## 💡 Estrutura

- `app/` – Lógica de negócio (Laravel)
- `resources/js/` – Componentes Vue + Bootstrap
- `routes/` – Arquivos de rotas (web.php, console.php, etc.)
- `docker/` – Arquivos de configuração dos containers (caso existam)

---

## 📦 Tecnologias

- Laravel 10+
- Vue 3 (Inertia.js)
- Bootstrap 5
- Docker / Docker Compose
- MySQL / phpMyAdmin

---