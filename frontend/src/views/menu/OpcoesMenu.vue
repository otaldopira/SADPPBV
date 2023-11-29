<template>
  <div
    class="w-4/5 mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 p-4"
  >
    <!-- Cadastro User -->
    <Card
      v-show="tipo_usuario == 1"
      icon="team"
      title="Cadastro de Usuários"
      route="cadastrar-usuario"
    ></Card>
    <!-- Listagem Users -->
    <Card
      v-show="tipo_usuario == 1"
      icon="list-user"
      title="Listagem de Usuários"
      route="listar-usuarios"
    ></Card>
    <!-- Meu Perfil -->
    <Card icon="identifier" title="Minha Conta" route="minha-conta"></Card>
    <Card
      v-show="tipo_usuario == 1"
      icon="marker"
      title="Cadastro de Ponto"
      route="cadastrar-ponto"
    ></Card>
    <Card
      v-show="tipo_usuario == 1"
      icon="list-point"
      title="Listagem de Pontos"
      route="listar-pontos"
    ></Card>
    <Card
      v-show="tipo_usuario == 1"
      icon="segment"
      title="Cadastro de Segmento"
      route="cadastrar-segmento"
    ></Card>
    <Card
      v-show="tipo_usuario == 1"
      icon="list-segment"
      title="Listagem de Segmentos"
      route="listar-segmentos"
    ></Card>
  </div>
</template>
<script>
import Card from "/src/components/Card.vue";
export default {
  components: {
    Card,
  },
  data() {
    return {
      tipo_usuario: null,
    };
  },
  created() {
    const user = JSON.parse(localStorage.getItem("usuario"));
    this.tipo_usuario = user.tipo_usuario;
  },
};
</script>
