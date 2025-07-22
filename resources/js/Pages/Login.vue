<template>

    <div class="d-flex flex-column justify-content-center align-items-center position-relative my-5 mx-auto" style="margin-top: 3rem;">
        <div class="box" id="primeira" v-if="mostrarCadastro">
            <h1 class="text-center py-4">Cadastrar</h1>

            <form class="d-flex flex-column" id="form_primeira" @submit.prevent="submit">
                <div class="d-flex flex-column mx-auto w-75 p-2 gap-2">
                    <label for="name" class="fw-semibold">Name</label>
                    <input type="text" name="name" v-model="form.name"
                    class="form-control  border-0 border-bottom"
                    :class="{ 'is-invalid': form.errors.name }"
                    >
                </div>
                <div class="invalid-feedback" v-if="form.errors.name">
                    {{ form.errors.name }}
                </div>


                <div class="d-flex flex-column mx-auto w-75 p-2 gap-2">
                    <label for="email" class="fw-semibold">Email</label>
                    <input type="text" name="email" v-model="form.email"
                    class="form-control border-0 border-bottom"
                    :class="{ 'is-invalid': form.errors.email }"
                    >
                </div>
                <div class="invalid-feedback" v-if="form.errors.email">
                    {{ form.errors.email }}
                </div>

                <div class="d-flex flex-column mx-auto w-75 p-2 gap-2" >
                    <label for="password" class="fw-semibold">Password</label>
                    <input type="password" name="password" v-model="form.password"
                    class="form-control border-0 border-bottom"
                    :class="{ 'is-invalid': form.errors.password }"
                    >
                </div>
                <div class="invalid-feedback" v-if="form.errors.password">
                    {{ form.errors.password }}
                </div>

                <button class="btn btn-primary m-4">
                    Cadastrar
                </button>
            </form>
           
            <div>
                <button class="logs" @click="mostrarCadastro = false">
                    Fazer login
                </button>
            </div>
        </div>

        <div class="box" id="segunda" v-if="!mostrarCadastro">
            <h1 class="text-center py-4">Login</h1>

            <form class="d-flex flex-column" action="">
                <div class="d-flex flex-column mx-auto w-75 p-2 gap-2">
                    <label for="email" class="fw-semibold">Email</label>
                    <input type="text" name="email"
                    class="form-control border-0 border-bottom"
                    :class="{ 'is-invalid': form.errors.password }">
                </div>
                <div class="d-flex flex-column mx-auto w-75 p-2 gap-2">
                    <label for="password" class="fw-semibold">Password</label>
                    <input type="password" name="password"
                    class="form-control border-0 border-bottom"
                    :class="{ 'is-invalid': form.errors.password }">
                </div>

                <button class="btn btn-primary m-4">Entrar</button>
            </form>


            <div>
                <button class="logs" @click="mostrarCadastro = true">
                    Fazer Cadastro
                </button>
            </div>
        </div>
    </div>

</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const mostrarCadastro = ref(false)

const form = useForm({
  name: '',
  email: '',
  password: ''
})

const submit = () => {
  form.post('/user', {
    onSuccess: () => {
      form.reset()
      mostrarCadastro.value = false
    }
  })
}
</script>


<style scoped>

    .box {
        display: flex;
        flex-direction: column;
        /* min-height: 400px; */
        width: 340px;
        border: 1px solid #a19d9d79;
        border-radius: 1rem;
        box-shadow: 0px 0px 5px  #00000056;
        padding: 10px;
    }
    
    .form-control.border-bottom {
        border-color: #a19d9d79 !important;
        border-radius: 0;
        padding-left: 10px;
        height: 33px;
    }
    input:focus{
        outline: none;
        padding-left: 10px;
        border: none;
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


    .logs {
        border: none;
        margin: auto;
        display: flex;
        background:transparent;
        font-size: .9rem;
        color:#0000db
    }
    .logs:hover {
        cursor: pointer;
        text-decoration: underline;
    }
</style>