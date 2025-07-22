<template>
  <Header />

  <section class="container my-5">
    <h2 class="text-center mb-4">Lista de Tarefas</h2>

    <div class="table-responsive">
      <table class="table table-bordered table-hover text-center align-middle">
        <thead class="table-light">
          <tr>
            <th scope="col">Tarefa</th>
            <th scope="col">Status</th>
            <th scope="col">Opções</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="tarefa in tarefas" :key="tarefa.id">
            <td>{{ tarefa.titulo }}</td>
            <td>{{ tarefa.status }}</td>
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

          <tr v-if="tarefas.length === 0">
            <td colspan="3" class="text-center text-muted">Nenhuma tarefa encontrada.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>
</template>

<script setup>
import Header from '@/Components/Header.vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  tarefas: Array
})

const editar = (id) => {
  router.get(`/tarefa/${id}/edit`)
}

function deletar(id) {
  if (confirm('Tem certeza que deseja deletar?')) {
    router.delete(`/tarefa/${id}`)
    }
}

</script>

<style scoped>
    .td {
        padding-left: 27px
    }
</style>