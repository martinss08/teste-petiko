<template>
    <Header />
    <div class="d-flex justify-content-end mt-2">
        <div class="d-flex me-2" >
            <form @submit.prevent="buscar" 
            class="d-flex p-1 border rounded-pill" style="border-color: #a19d9d79;">
                <input class="form-control border-0 shadow-none" type="text" 
                v-model="busca" 
                placeholder="Buscar Tarefa"
                >
                <button class="border-0 bg-transparent" type="submit" >
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
    </div>

    <h1 class="text-center mt-5 mx-auto" style="font-size: 2.7rem;">
        Lista de usuário
    </h1>
    <div class="w-100 mt-5 mx-auto" style="max-width: 90%;">
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
                    <td>{{ user.tipo_usuario?.nome }}</td>
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
import { ref, watch } from 'vue'
import Swal from 'sweetalert2'


const props = defineProps({
  busca: String,
  users: Object
})
const busca = ref(props.busca || '')

function buscar() {
  router.get('/user', { busca: busca.value }, {
    preserveState: true,
    preserveScroll: true,
  })
}

watch(busca, (valor) => {
  if (valor === '') {
    router.get('/user', {}, {
      preserveState: true,
      preserveScroll: true,
    })
  }
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
  Swal.fire({
    title: 'Tem certeza?',
    text: 'Esta ação não poderá ser desfeita!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sim, deletar!',
    cancelButtonText: 'Cancelar',
  }).then((result) => {
    if (result.isConfirmed) {
      router.delete(`/user/${id}`, {
        onSuccess: () => {
          Swal.fire('Deletado!', 'O usuario foi deletado com sucesso.', 'success')
        },
      })
    }
  })
}
</script>

<style>
    input[type="text"] {
        border: none;
        height: 25px;
        width: 88%;
    }
</style>
