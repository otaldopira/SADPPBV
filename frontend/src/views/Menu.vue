<script>
import AppBar from "/src/components/AppBar.vue";
import { loading, modalAlert } from "../assets/js/global";
export default {
  data() {
    return {};
  },
  mounted() {
    console.log(this.$router.params);
  },
  components:{
    "app-bar": AppBar
  }
};
</script>
<template>
  <div class="scroll-smooth h-[90vh]">
    <app-bar></app-bar>
    <router-view v-slot="{ Component }">
      <transition mode="out-in" name="slide-fade">
        <component :is="Component" />
      </transition>
    </router-view>
  </div>
</template>
