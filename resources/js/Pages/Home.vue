<template>
    <div>
        <h2>Home</h2>

        <div>
            <a href="/tarefa/create">Criar tarefa</a>
        </div>

        <div style=" width: 900px; border:1px solid; padding:10px; margin: 3rem auto ">
            <table class="table table-bordered" style=" width: 80%; margin: auto;">
            <thead style="text-align: center; width: 20%; ">
                <tr>
                    <th scope="col">Tarefa</th>
                    <th scope="col">Status</th>
                    <th scope="col">Opções</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="tarefa in props.tarefas" :key="tarefa.id">
                    <td class="td">{{ tarefa.titulo }}</td>
                    <td class="td">{{ tarefa.status }}</td>
                    <td class="td">
                        <button><i class="bi bi-pencil-square"></i></button>
                        <button @click="deletar(tarefa.id)">
                        <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                <tr v-if="props.tarefas.length === 0">
                    <td colspan="3" style="text-align: center;">Nenhuma tarefa encontrada.</td>
                </tr>
            </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'

const props = defineProps({
  tarefas: Array
})

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