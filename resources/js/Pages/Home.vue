<template>
  <Header />

   <div class="d-flex justify-content-end mt-1">
      <div class="me-2 p-2 border rounded-pill">
          <form class="form" @submit.prevent="buscar">
              <input class="ps-3 border-0" type="text" placeholder="Buscar Tarefa" 
              v-model="busca">
              <button class="border-0 me-2 bg-transparent" type="submit" >
                  <i class="bi bi-search"></i>
              </button>
          </form>
      </div>
  </div>

  <section class="container my-5">
    <h2 class="text-center mb-4">Lista de Tarefas</h2>

    <div class="table-responsive">
      <table class="table table-bordered table-hover text-center align-middle">
        <thead class="table-light">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Tarefa</th>
            <th scope="col">Status</th>
            <th scope="col">Opções</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="tarefa in tarefas.data" :key="tarefa.id">
            <td>{{ tarefa.id }}</td>
            <td>{{ tarefa.titulo }}</td>
            <td>{{ tarefa.status?.nome }}</td>
            <td>
              <div class="d-flex justify-content-center align-items-center gap-3">
                <button class="btn btn-link p-0 text-primary fs-5" @click="editar(tarefa.id)">
                  <i class="bi bi-pencil-square"></i>
                </button>
                <button class="btn btn-link p-0 text-danger fs-5" @click="deletar(tarefa.id)">
                  <i class="bi bi-trash"></i>
                </button>
              </div>
            </td>
          </tr>

          <tr v-if="tarefas.data.length === 0">
            <td colspan="3" class="text-center text-muted">Nenhuma tarefa encontrada.</td>
          </tr>
        </tbody>
      </table>

      <div class="container_btn" style="display: flex; justify-content: center;">
        <button
          :disabled="!tarefas.prev_page_url"
          @click="mudarPagina(tarefas.prev_page_url)"
          class="px-3 py-1 border rounded"
        >
          Anterior
        </button>

        <button
          :disabled="!tarefas.next_page_url"
          @click="mudarPagina(tarefas.next_page_url)"
          class="px-3 py-1 border rounded"
        >
          Próximo
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
import Header from '@/Components/Header.vue'
import { router } from '@inertiajs/vue3'
import { ref, watch } from 'vue'


const props = defineProps({
  tarefas: Object,
  busca: String // nova prop para manter o valor digitado
})

const busca = ref(props.busca || '')

function buscar() {
  router.get('/tarefa', { busca: busca.value }, {
    preserveState: true,
    preserveScroll: true,
  })
}

watch(busca, (valor) => {
  if (valor === '') {
    router.get('/tarefa', {}, {
      preserveState: true,
      preserveScroll: true,
    })
  }
})

const editar = (id) => {
  router.get(`/tarefa/${id}/edit`)
}

function deletar(id) {
  if (confirm('Tem certeza que deseja deletar?')) {
    router.delete(`/tarefa/${id}`)
  }
}

function mudarPagina(url) {
  if (url) {
    router.get(url, { busca: busca.value }, {
      preserveState: true,
      preserveScroll: true,
    })
  }
}

</script>

<style scoped>
    .td {
        padding-left: 27px
    }
</style>