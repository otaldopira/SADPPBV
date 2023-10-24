<script>
import AppBar from "/src/components/AppBar.vue";
import Card from "/src/components/Card.vue";
import { loading, modalAlert } from "../assets/js/global";
export default {
  data() {
    return {};
  },
  components: {
    "app-bar": AppBar,
    Card,
  },
};
</script>
<template>
  <div class="scroll-smooth h-[90vh]">
    <app-bar></app-bar>
    <transition name="slide-fade">
      <div
        v-if="this.$route.path === '/menu'"
        class="w-4/5 mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 p-4"
      >
        <div>
          <Card
            icon="team"
            title="Cadastro de Usuários"
            route="menu/cadastrar-usuario"
          ></Card>
        </div>
        <div>
          <Card
            icon="team"
            title="Cadastro de Usuários"
            route="menu/cadastrar-usuario"
          ></Card>
        </div>
        <div>
          <Card
            icon="team"
            title="Cadastro de Usuários"
            route="menu/cadastrar-usuario"
          ></Card>
        </div>
        <div>
          <Card
            icon="team"
            title="Cadastro de Usuários"
            route="menu/cadastrar-usuario"
          ></Card>
        </div>
        <div>
          <Card
            icon="team"
            title="Cadastro de Usuários"
            route="menu/cadastrar-usuario"
          ></Card>
        </div>
        <div>
          <Card
            icon="team"
            title="Cadastro de Usuários"
            route="menu/cadastrar-usuario"
          ></Card>
        </div>
      </div>
    </transition>
    <router-view v-slot="{ Component }">
      <transition mode="out-in" name="slide-fade">
        <component :is="Component" />
      </transition>
    </router-view>
  </div>
</template>
