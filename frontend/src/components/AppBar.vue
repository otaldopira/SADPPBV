<template>
  <nav
    class="relative flex flex-wrap items-center justify-between px-2 py-3 bg-yellow-400 mb-3"
  >
    <div
      class="container px-4 mx-auto flex flex-wrap items-center justify-between"
    >
      <div
        class="w-full relative flex justify-between lg:w-auto px-4 lg:static lg:block lg:justify-start"
      >
        <div>
          <router-link
            class="text-md font-bold leading-relaxed inline-block mr-4 py-2 whitespace-nowrap uppercase text-gray-800"
            to="/menu"
          >
            SADPPBV
          </router-link>
        </div>
      </div>
      <div
        v-bind:class="{ hidden: !showMenu, flex: showMenu }"
        class="lg:flex lg:flex-grow items-center"
      >
        <ul class="flex flex-col lg:flex-row list-none ml-auto cursor-pointer">
          <li class="nav-item" @click="logout">
            <span class="material-symbols-rounded text-gray-800 font-bold"> logout </span>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
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
