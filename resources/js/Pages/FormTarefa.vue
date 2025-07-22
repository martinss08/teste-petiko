<template>
    <Header />

    <div>
        <h2>Criação tarefa</h2>

         <div class="container_livro">

          <form @submit.prevent="submit">
            <div class="box">
                <label for="titulo">Título</label>
                <input v-model="form.titulo" type="text" id="titulo"
                class="form-control"
                :class="{ 'is-invalid': form.errors.titulo }"
                />
            </div>
            <div class="invalid-feedback" v-if="form.errors.titulo">
                {{ form.errors.titulo ?? 'sem erro'}}
            </div>

            <div class="box">
                <label for="descricao">Descrição</label>
                <input v-model="form.descricao" type="text" id="descricao" 
                class="form-control"
                :class="{ 'is-invalid': form.errors.descricao }"
                />

            </div>
            <div class="invalid-feedback" v-if="form.errors.descricao">
                {{ form.errors.descricao }}
            </div>

            <div class="box">
              <label for="data_tarefa">Data para fazer</label>
              <input
                v-model="form.data_tarefa"
                type="date"
                class="form-control"
                :class="{ 'is-invalid': form.errors.data_tarefa }"
              />
            </div>
            <div class="invalid-feedback" v-if="form.errors.data_tarefa">
              {{ form.errors.data_tarefa }}
            </div>

            <!-- <pre>{{ statusOptions }}</pre> -->
            <div class="box status" v-if="props.tarefa?.id">
              <label for="status">Status</label>
              <select
                v-model="form.status_id"
                id="status"
                class="form-control"
                :class="{ 'is-invalid': form.errors.status_id }"
              >
                <option disabled value="">Selecione um status</option>
                <option
                  v-for="option in statusOptions"
                  :key="option.id"
                  :value="option.id"
                >
                  {{ option.nome }}
                </option>
              </select>
            </div>
            <div class="invalid-feedback" v-if="props.tarefa?.id && form.errors.status_id">
              {{ form.errors.status_id }}
            </div>
            
            <div style="margin: 2rem auto 0 auto;">
              <button type="submit" class="btn btn-primary" :disabled="form.processing">
                Salvar Tarefa
              </button>
            </div>
          </form>
            
        </div>
    </div>
</template>

<script setup>
import Header from '@/Components/Header.vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  tarefa: {
    type: Object,
    default: () => ({})
  },
  statusOptions: {
    type: Array,
    default: () => []
  }
});


const form = useForm({
  titulo: props.tarefa?.titulo || '',
  descricao: props.tarefa?.descricao || '',
   status_id: props.tarefa?.status?.id || 1,
  data_tarefa: props.tarefa?.data_tarefa || '',
})

const submit = () => {
  if (props.tarefa?.id) {
    form.put(`/tarefa/${props.tarefa.id}`) // editar
  } else {
    form.post('/tarefa') // criar
  }
}

</script>

<style scoped>

  .container_livro {
    width: 405px;
    margin: 3rem auto 2rem auto;
    padding: 2rem 1rem;
    border: 1px solid #a19d9d79;
    border-radius: 0.7rem;
    box-shadow: 0px 0px 5px #00000056;
  }

  form {
    width: 80%;
    margin:auto
  }

  .box {
    padding: 10px;
  }
  input[type="text"], select {
    border: none;
    border-bottom: 1px solid #a19d9d79 ;
    border-radius: 0;
    margin-left: 10px;
  }
  input[type="text"]:focus, select:focus {
    outline: none;
    box-shadow: none;
    border-bottom: 1px solid black ;
  }

  input.is-invalid {
    border-bottom: 1px solid #dc3545 !important;
  }
  .invalid-feedback {
    text-align: center;
    display: block !important;
    font-family: Arial, Helvetica, sans-serif;
    color: #dc3545;
    font-size: .6rem;
  }

  .box.status select{
    width: 180px;
  }
</style>