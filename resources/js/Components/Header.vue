<template>
  <header class="header">
    <div class="container">
      <h1 class="logo">to-do list</h1>
      <nav class="nav">
        <a href="/tarefa">Home</a>
        <a href="/tarefa/create">Criar tarefa</a>
        <a href="/logout">Sair</a>
      </nav>
    </div>
  </header>
</template>

<script setup>
</script>

<style scoped>
.header {
  background-color: #4f46e5; 
  color: white;
  padding: .8rem;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.container {
  max-width: 1200px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.logo {
  font-size: 1.25rem;
  font-weight: bold;
}

.nav a {
  margin-left: 1rem;
  text-decoration: none;
  color: white;
  transition: text-decoration 0.2s;
}

.nav a:hover {
  text-decoration: underline;
}
</style>