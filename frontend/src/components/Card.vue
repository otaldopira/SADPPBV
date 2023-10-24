<template>
  <router-link :to="route">
    <div
      class="mx-auto max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow cursor-pointer flex flex-col items-center"
    >
      <img width="100" :src="'src/assets/imagens/icons/' + icon + '.png'" />
      <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900">
        {{ title }}
      </h5>
      <p class="mb-3 font-normal text-gray-500"></p>
    </div>
  </router-link>
</template>

<script>
export default {
  props: ["icon", "route", "title"],
  methods: {
    created() {
      console.log(icon);
    },
  },
};
</script>
