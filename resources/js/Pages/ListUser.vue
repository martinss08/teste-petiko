<template>
    <Header />
    <h1 style="text-align: center; margin: 3rem auto 0 auto; font-size: 2.7rem;">
        Lista de usuário
    </h1>
    <div style="width: 90%; margin: 3rem auto 0 auto;">
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users.data" :key="user.id">
                    <td>{{ user.id }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.tipo_user_id?.nome }}</td>
                    <td>
                        <div class="d-flex justify-content-center align-items-center gap-3">
                            <button class="btn btn-link p-0 text-primary fs-5" 
                            @click="editar(user.id)"
                            >
                            <i class="bi bi-pencil-square"></i>
                            </button>

                            <button class="btn btn-link p-0 text-danger fs-5" @click="deletar(user.id)">
                            <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                    </tr>
                        <tr v-if="users.data.length === 0">
                        <td colspan="3">Nenhum usuário encontrado.</td>
                    </tr>
                </tbody>
            </table>

            <div class="d-flex justify-content-evenly mx-auto mt-4" style="width: 250px;">
                <button class="px-3 py-1 border rounded"
                 @click="mudarPagina(users.prev_page_url)"
                 :disabled="!users.prev_page_url"
                >
                    Anterior
                </button>

                <button class="px-3 py-1 border rounded"
                 @click="mudarPagina(users.next_page_url)"
                 :disabled="!users.next_page_url"
                >
                    Próximo
                </button>
            </div> 
        </div>
    </div>
</template>


<script setup>
import Header from '@/Components/Header.vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  users: Object
})

function mudarPagina(url) {
  if (url) {
    router.visit(url)
  }
}
function editar(id) {
  router.get(`/user/${id}/edit`)
}

function deletar(id) {
    if (confirm('Tem certeza que deseja excluir este usuário?')) {
        router.delete(`/user/${id}`)
    }
}
</script>
