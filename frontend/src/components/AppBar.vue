<template>
  <nav
    class="relative flex flex-wrap items-center justify-between px-2 py-3 bg-teal-500 mb-3"
  >
    <div
      class="container px-4 mx-auto flex flex-wrap items-center justify-between"
    >
      <div
        class="w-full relative flex justify-between lg:w-auto px-4 lg:static lg:block lg:justify-start"
      >
        <router-link
          class="text-sm font-bold leading-relaxed inline-block mr-4 py-2 whitespace-nowrap uppercase text-white"
          to="/menu"
        >
          SADPPBV
        </router-link>
      </div>
      <div
        v-bind:class="{ hidden: !showMenu, flex: showMenu }"
        class="lg:flex lg:flex-grow items-center"
      >
        <ul class="flex flex-col lg:flex-row list-none ml-auto cursor-pointer">
          <!-- <li class="nav-item">
            <a
              class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug text-white hover:opacity-75"
              href="#pablo"
            >
              <i
                class="fab fa-facebook-square text-lg leading-lg text-white opacity-75"
              /><span class="ml-2">Share</span>
            </a>
          </li>
          <li class="nav-item">
            <a
              class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug text-white hover:opacity-75"
              href="#pablo"
            >
              <i
                class="fab fa-twitter text-lg leading-lg text-white opacity-75"
              /><span class="ml-2">Tweet</span>
            </a>
          </li> -->
          <li class="nav-item" @click="logout">
            <span class="material-symbols-rounded text-white"> logout </span>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import { loading, modalAlert } from "../assets/js/global";
export default {
  name: "teal-navbar",
  data() {
    return {
      showMenu: false,
    };
  },
  methods: {
    toggleNavbar: function () {
      this.showMenu = !this.showMenu;
    },
    async logout() {
      console.log(localStorage.getItem("token"));
      try {
        const response = await axios.post(
          "/logout",
          {},
          {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token"),
            },
          }
        );
        console.log(response);
        if (response.data.success == false) {
          return modalAlert("error", response.data.message);
        }
        localStorage.removeItem("token");
        this.$router.push("/entrar");
      } catch (error) {
        console.log(error);
        modalAlert("error", "Não foi possível completar a operação...");
      }
    },
  },
};
</script>
