<template>
    <Header v-if="authUser" />
    <div class="caixa">
        <h1 style="font-size: 2rem; text-align: center;padding: 10px; margin: 1rem auto;">
            {{ props.user ? 'Editar Usuário' : 'Cadastrar Usuário' }}
        </h1>

        <form @submit.prevent="submit" style="padding:10px ;">
            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input v-model="form.name"type="text"
                class="form-control"
                :class="{ 'is-invalid': form.errors.name }"
                />
                <div class="invalid-feedback" v-if="form.errors.name">
                    {{ form.errors.name }}
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input v-model="form.email" type="email"
                class="form-control"
                :class="{ 'is-invalid': form.errors.email }"
                />
                <div class="invalid-feedback" v-if="form.errors.email">
                    {{ form.errors.email }}
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input 
                type="password"
                v-model="form.password"
                class="form-control"
                :class="{ 'is-invalid': form.errors.password }"
                />
                <div class="invalid-feedback" v-if="form.errors.password">
                    {{ form.errors.password }}
                </div>
            </div>

            <div v-if="props.authUser?.tipo_user_id === 2" class="mb-3">
                <label for="tipo_user_id" class="form-label">Tipo de Usuário</label>
                <select v-model="form.tipo_user_id" class="form-control"
                        :class="{ 'is-invalid': form.errors.tipo_user_id }">
                    <option value="1">Usuário Comum</option>
                    <option value="2">Administrador</option>
                </select>
                <div class="invalid-feedback" v-if="form.errors.tipo_user_id">
                    {{ form.errors.tipo_user_id }}
                </div>
            </div >

            <div class="d-grid" style="margin: auto;padding: 7px;">
                <button type="submit" class="btn btn-primary" style="margin-top: 2rem;">
                    {{ props.user ? 'Atualizar' : 'Cadastrar' }}
                </button>
            </div>
        </form>
        <div style="margin:1rem 0; text-align: center;">
            <button class="logs" @click="$inertia.visit('/login')">
                Fazer login
            </button>
        </div>

        
    </div>
</template>

<script setup>
import Header from '@/Components/Header.vue'
import { router, useForm } from '@inertiajs/vue3'

const props = defineProps({
  user: Object,       // recebe o usuário (para edição)
  authUser: Object
})

const form = useForm({
  name: props.user?.name || '',
  email: props.user?.email || '',
  password: '',
  tipo_user_id: props.user?.tipo_user_id || 1
})


function submit() {
  if (props.user) {
    form.put(`/user/${props.user.id}`)
  } else {
    form.post(route('register'))
  }
}
</script>

<style>
    .caixa {
        width: 460px;
        margin: 3rem auto;
        border: 1px solid #a19d9d79;
        border-radius: 1rem;
        box-shadow: 0px 0px 5px  #00000056;
        padding: 10px;
    }

    form {
        width: 80%;
        margin: auto;
    }

    input[type="text"], input[type="email"], input[type="password"] {
        outline: none;
        box-shadow: none;
        padding-left: 10px;
        height: 30px;

        border: none;
        border-bottom: 1px solid #a19d9d79 ;
    }
    input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus {
        outline: none;
        box-shadow: none;
        padding-left: 10px;
        border: none;
        border-bottom: 1px solid black ;
    }
</style>