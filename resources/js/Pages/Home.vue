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
  
  <div class="container my-5">
    <h1 class="text-center mb-4 fs-1">
      Lista de Tarefas
    </h1>

    <div class="table-responsive">
      <table class="table table-bordered table-hover text-center align-middle">
        <thead class="table-light">
          <tr>
            <th v-if="authUser && authUser.tipo_user_id === 2" scope="col">ID</th>
            <th scope="col">Tarefa</th>
            <th scope="col">Status</th>
            <th scope="col">Prazo</th>
            <th v-if="authUser && authUser.tipo_user_id === 2">Dono</th>
            <th scope="col">Opções</th>
          </tr>
        </thead>
        
        <tbody>
          <tr v-for="tarefa in tarefas.data" :key="tarefa.id">
            <td v-if="authUser && authUser.tipo_user_id === 2" >{{ tarefa.id }}</td>
            <td>{{ tarefa.titulo }}</td>
            
              <!-- Ver -->
            <td>
              <span
                @click="toggleStatus(tarefa.id)"
                style="cursor: pointer;"
              >
                <i
                  :class="{
                    'bi': true,
                    'bi-check-circle-fill text-success': tarefa.status?.nome === 'feito',
                    'bi-x-circle-fill text-secondary': tarefa.status?.nome !== 'feito'
                  }"
                  style="font-size: 1.2rem;"
                ></i>
              </span>
              {{ tarefa.status?.nome }}
            </td>

            <td>{{ formatarData(tarefa.data_tarefa) }}</td>
            <td v-if="authUser && authUser.tipo_user_id === 2">{{ tarefa.user?.name }}</td>

            <td>
              <div class="d-flex justify-content-center align-items-center gap-3">
                <button class="btn btn-link p-0 text-primary fs-5" 
                 @click="editar(tarefa.id)"
                 v-if="authUser && authUser.tipo_user_id === 2"
                >
                  <i class="bi bi-pencil-square"></i>
                </button>
                <button class="btn btn-link p-0 text-danger fs-5" 
                 @click="deletar(tarefa.id)"
                >
                  <i class="bi bi-trash"></i>
                </button>
              </div>
            </td>
          </tr>

          <tr v-if="tarefas.data.length === 0">
            <td colspan="3" class="text-center text-muted">
              Nenhuma tarefa encontrada.
            </td>
          </tr>
        </tbody>
      </table>

      <div class="d-flex justify-content-evenly mx-auto mt-4" style="width: 250px;">
        <button class="px-3 py-1 border rounded" 
          @click="mudarPagina(tarefas.prev_page_url)"
          :disabled="!tarefas.prev_page_url"
        >
          Anterior
        </button>

        <button class="px-3 py-1 border rounded"
          @click="mudarPagina(tarefas.next_page_url)"
          :disabled="!tarefas.next_page_url"
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

const props = defineProps({
  tarefas: Array,
  busca: String,
  authUser: Object,
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

function toggleStatus(tarefaId) {
  router.put(`/tarefa/${tarefaId}/toggle-status`)
}

const formatarData = (dataISO) => {
  if (!dataISO) return '';
  const [ano, mes, dia] = dataISO.split('-');
  return `${dia}/${mes}/${ano}`;
}

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

  input[type="text"] {
    border: none;
    height: 25px;
    width: 88%;
  }
</style>