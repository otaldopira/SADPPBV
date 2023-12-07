<script>
import AppBar from "/src/components/AppBar.vue";
export default {
  data() {
    return {};
  },
  methods: {
    voltar() {
      window.history.back();
    },
  },
  components: {
    "app-bar": AppBar,
  },
};
</script>
<template>
  <div class="scroll-smooth h-[90vh]">
    <app-bar></app-bar>

    <div class="ml-14">
      <transition mode="out-in" name="slide-fade">
        <button
          v-if="this.$route.name != 'menu'"
          @click="voltar"
          class="shadow-md inline-flex items-center px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-white text-sm font-medium rounded-md"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5 mr-2"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"
            />
          </svg>

          Voltar
        </button>
      </transition>
    </div>
    <router-view v-slot="{ Component }">
      <transition mode="out-in" name="slide-fade">
        <component :is="Component" />
      </transition>
    </router-view>
  </div>
</template>
