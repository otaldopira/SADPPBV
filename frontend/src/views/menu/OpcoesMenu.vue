<template>
  <div
    class="w-4/5 mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 p-4"
  >
    <Card
      icon="team"
      title="Cadastro de Usuários"
      route="menu/cadastrar-usuario"
    ></Card>
    <Card
      icon="list-user"
      title="Listagem de Usuários"
      route="menu/listar-usuarios"
    ></Card>
  </div>
</template>
<script>
import Card from "/src/components/Card.vue";
export default {
  components: {
    Card,
  },
};
</script>
