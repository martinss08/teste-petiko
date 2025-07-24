<template>
  <header class="header">
    <div class="container d-flex justify-content-between align-items-center" 
    style="width: 100%;">
      <h1 class="logo m-0">to-do list</h1>

      <div class="dropdown">
        <button class="btn text-white fs-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-list"></i>
        </button>

        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="/tarefa">Home</a></li>
          <li>
            <a class="dropdown-item" v-if="isAdmin" href="/tarefa/create">
              Criar tarefa
            </a>
          </li>
          <li>
            <a class="dropdown-item" v-if="isAdmin" href="/user">
              Lista de Usuário
            </a>
          </li>
          <li><a class="dropdown-item" href="#">Perfil</a></li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <button class="dropdown-item text-danger" type="submit"
              @click="logout"
            >
              Sair
            </button>
          </li>
        </ul>
      </div>
    </div>
  </header>
</template>

<script setup>
import { usePage, router } from '@inertiajs/vue3'

const page = usePage()
const isAdmin = page.props.auth.isAdmin

function logout() {
  router.post('/logout')
}
</script>

<style scoped>
.header {
  background-color: #4f46e5;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.logo {
  font-size: 1.25rem;
  font-weight: bold;
  color: white;
}

.dropdown .btn {
  background: transparent;
  border: none;
  margin-right:-20px;
}

.dropdown .btn:hover {
  background: rgba(255, 255, 255, 0.1);
}
</style>
