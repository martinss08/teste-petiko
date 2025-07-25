# 📝 To-do List Laravet + Vue.js

Este projeto é uma aplicação de gerenciamento de tarefas desenvolvida com Laravel (backend) e Vue.js (frontend via Inertia.js), com ambiente configurado via Docker.

---

## 🚀 Como rodar o projeto localmente

### 1. Clone o repositório

```bash
git clone https://github.com/martinss08/teste-petiko.git
cd teste-petiko
```

### 2. Instale as dependências do Laravel

```bash
make build 
```

## 👤 Usuário padrão (seeded)

Após rodar os seeders, você poderá acessar com:

- **Email:** `admin@admin.com`  
- **Senha:** `123456`

---

## 🐞 Comandos úteis

| Ação                          | Comando                                                  |
|-------------------------------|----------------------------------------------------------|
| Subir containers              | `make up`                                                |
| Parar containers              | `make down`                                              |
| Rodar os testes               | `make test`                                              | 

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