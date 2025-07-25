<template>
    <Header />

    <div>
        <h1 class="text-center mb-4 fs-1" style="margin: 2.3rem 0 0 0;">
           {{ props.tarefa?.id ? 'Edição de Tarefa' : 'Criação de Tarefa' }}
        </h1>

         <div class="container_livro">

          <form @submit.prevent="submit">
            <div class="box">
                <label for="titulo">Título</label>
                <input v-model="form.titulo" type="text"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.titulo }"
                />
                <div class="invalid-feedback" v-if="form.errors.titulo">
                    {{ form.errors.titulo ?? 'sem erro'}}
                </div>
            </div>

            <div class="box">
                <label for="descricao">Descrição</label>
                <input v-model="form.descricao" type="text" id="descricao" 
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.descricao }"
                />

                <div class="invalid-feedback" v-if="form.errors.descricao">
                    {{ form.errors.descricao }}
                </div>
            </div>

            <div class="box">
              <label for="data_tarefa">Data para fazer</label>
              <input v-model="form.data_tarefa" type="date"
                class="form-control"
                :class="{ 'is-invalid': form.errors.data_tarefa }"
              />
              <div class="invalid-feedback" v-if="form.errors.data_tarefa">
                {{ form.errors.data_tarefa }}
              </div>
            </div>

            <div class="box status" v-if="props.tarefa?.id">
              <label for="status">Status</label>
              <select v-model="form.status_id"
                class="form-control"
                :class="{ 'is-invalid': form.errors.status_id }"
              >
                <option disabled value="">Selecione um status</option>
                <option
                  v-for="option in status"
                  :key="option.id"
                  :value="option.id"
                >
                  {{ option.nome }}
                </option>
              </select>
              <div class="invalid-feedback" v-if="props.tarefa?.id && form.errors.status_id">
                {{ form.errors.status_id }}
              </div>
            </div>

            <div class="mb-3" v-if="authUser.tipo_user_id === 2">
              <label for="user_id" class="form-label">Atribuir a</label>
              <select v-model="form.user_id" class="form-control">
                <option disabled value="">
                  Selecione um usuário
                </option>
                <option v-for="user in users" :key="user.id"
                 :value="user.id"
                 >
                  {{ user.name }}
                </option>
                
              </select>
              <div class="invalid-feedback" v-if="form.errors.user_id">
                {{ form.errors.user_id }}
              </div>
            </div>

            <div style="margin: 2rem auto 0 auto;">
              <button type="submit" class="btn btn-primary" :disabled="form.processing">
                {{ props.tarefa?.id ? 'Atualizar Tarefa' : 'Salvar Tarefa' }}
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
  status: {
    type: Array,
    default: () => []
  },
  users: {  
    type: Array,
    default: () => []
  },
  authUser: {
    type: Object,
    default: () => ({}),
  }
});


const form = useForm({
  titulo: props.tarefa?.titulo || '',
  descricao: props.tarefa?.descricao || '',
  status_id: props.tarefa?.status_id || 1,
  data_tarefa: props.tarefa?.data_tarefa || '',
  user_id: props.tarefa?.user_id || '',
})

const submit = () => {
  if (props.tarefa?.id) {
    form.put(`/tarefa/${props.tarefa.id}`) 
  } else {
    form.post('/tarefa') 
  }
}

</script>

<style scoped>

  .container_livro {
    width: 405px;
    margin: 2rem auto 2rem auto;
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
  input[type="text"], input[type="date"], select {
    border: none;
    border-bottom: 1px solid #a19d9d79 ;
    border-radius: 0;
    margin-left: 10px;
  }
  input[type="text"]:focus, input[type="date"]:focus select:focus {
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