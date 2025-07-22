<template>
    <div>
        <h2>Criação</h2>

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
<!-- <p style="background: yellow; color: red;" v-if="form.errors.titulo">
  {{ form.errors.titulo }}
</p> -->
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

            <div class="box status">
                <label for="status">Status</label>
                <input v-model="form.status" type="text"
                class="form-control"
                :class="{ 'is-invalid': form.errors.status }"
                />
                
            </div>
            <div class="invalid-feedback" v-if="form.errors.status">
                {{ form.errors.status }}
            </div>
            
            <div style="margin: 2rem auto 0 auto;">
              <button type="submit" class="btn btn-primary" :disabled="form.processing">
                Salvar Livro
              </button>
            </div>
            </form>
            
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  tarefa: {
    type: Object,
    default: () => ({})
  }
})

const form = useForm({
  titulo: props.tarefa?.titulo || '',
  descricao: props.tarefa?.descricao || '',
  status: props.tarefa?.status || '',
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
  input[type="text"] {
    border: none;
    border-bottom: 1px solid #a19d9d79 ;
    border-radius: 0;
    margin-left: 10px;
  }
  input[type="text"]:focus {
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

  .box.status input[type="text"]{
    width: 180px;
  }
</style>