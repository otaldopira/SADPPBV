<template>
  <nav class="relative py-1 bg-yellow-400 mb-3 text-white rounded-b-xl shadow-md">
    <div class="w-full flex justify-between items-center px-8">
      <!-- LOGO -->
      <div>
        <router-link
          class="text-md font-bold leading-relaxed inline-block mr-4 py-2 whitespace-nowrap uppercase"
          to="/menu"
        >
          <img width="60" src="../assets/imagens/UTFPR.png" alt="UTFPR LOGO" />
        </router-link>
      </div>
      <!-- Logout -->
      <div>
        <ul class="cursor-pointer">
          <li class="nav-item" @click="logout">
            <span class="material-symbols-rounded font-semibold text-gray-800"> logout </span>
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
        this.$router.push({name: "entrar"});
      } catch (error) {
        console.log(error);
        toastr.error(
          error.response.data.message ??
            "Não foi possível complementar a operação..."
        );
      }
    },
  },
};
</script>
