<template>
  <router-view v-slot="{ Component }">
    <transition mode="out-in" name="slide-fade">
      <component :is="Component" />
    </transition>
  </router-view>
</template>
