<template>
    <div class="mx-auto my-5 p-3 rounded" 
    style="max-width: 370px; border: 1px solid #a19d9d79; box-shadow: 0 0 5px #00000056;"
    >
        <h1 class="text-center mb-4 fs-1">
            Login
        </h1>
        <form class="d-flex flex-column mt-5 w-100" @submit.prevent="login">

            <div class="d-flex flex-column mx-auto w-75 p-2 gap-2">
                <label for="email" class="fw-semibold">Email</label>
                <input type="text" name="email" v-model="form.email"
                class="form-control "
                :class="{ 'is-invalid': form.errors.password }">
            </div>
            <div class="d-flex flex-column mx-auto w-75 p-2 gap-2">
                <label for="password" class="fw-semibold">Password</label>
                <input type="password" name="password" v-model="form.password"
                class="form-control "
                :class="{ 'is-invalid': form.errors.password }">
            </div>

            <div class="mx-auto my-2 py-2 px-3 w-75">
                <button type="submit" class="btn btn-primary" style="margin-top: 2rem;
                width: 100%;">
                    Login
                </button>
            </div>
        </form>

        <div style="margin:1rem 0; text-align: center;">
            <button type="button" class="logs" @click="irParaCadastro">
            Fazer Cadastro
            </button>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'

const form = useForm({
  email: '',
  password: '',
})

function login() {
  form.post('/login')
}

function irParaCadastro() {
  router.get('/register')
}
</script>

<style scoped>

    /* .box {
        width: 370px;
        border: 1px solid #a19d9d79;
        border-radius: 1rem;
        box-shadow: 0px 0px 5px  #00000056;
        padding: 10px;
        margin: 3rem auto;
    } */
 
    input {
        outline: none;
        box-shadow: none;
        height: 28px;
        padding-left: 10px;
        border: none;
        border-bottom: 1px solid #a19d9d79 ;
    }
    input[type="text"]:focus, input[type="password"]:focus{
        outline: none;
        box-shadow: none;
        padding-left: 10px;
        border: none;
        border-bottom: 1px solid black ;
    }
</style>
