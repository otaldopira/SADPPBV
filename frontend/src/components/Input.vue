<template>
  <input
    :value="valor"
    @keyup="$emit('update:valor', $event.target.value)"
    :type="tipo"
    :placeholder="placeholder"
    class="input-container"
  />
</template>

<script>
export default {
  props: ["tipo", "placeholder", "valor"]
};
</script>
<style>
.input-container {
  @apply w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white;
}
</style>
