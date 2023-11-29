<template>
  <div class="w-4/5 mx-auto grid grid-cols-1 md:grid-cols-2 gap-3 p-4">
    <router-link
      :to="{
        name: 'editar-usuario',
        params: { id: registro },
      }"
    >
      <div
        class="mx-auto max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow cursor-pointer flex flex-col items-center"
      >
        <img width="100" src="/src/assets/imagens/icons/update.png" />
        <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-800">
          Editar usuário
        </h5>
        <p class="mb-3 font-normal text-gray-500"></p>
      </div>
    </router-link>
    <div @click="modalConfirm">
      <div
        class="mx-auto max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow cursor-pointer flex flex-col items-center"
      >
        <img width="100" src="/src/assets/imagens/icons/delete.png" />
        <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-800">
          Deletar conta
        </h5>
        <p class="mb-3 font-normal text-gray-500"></p>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      registro: localStorage.getItem("registro"),
    };
  },
  methods: {
    modalConfirm() {
      Swal.fire({
        title: "Você realmente deseja remover a sua conta ?",
        icon: "warning",
        showCancelButton: true,
        focusCancel: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim",
        cancelButtonText: "Não",
      }).then((result) => {
        if (result.isConfirmed) {
          this.removerConta();
        }
      });
    },
    async removerConta() {
      this.$global.loading();
      try {
        const response = await axios.delete(`/usuarios/${this.registro}`).then(
          setTimeout(() => {
            Swal.close();
          }, 2000)
        );

        console.log("Recebido:");
        console.log(response);

        if (response.data.success == false) {
          return toastr.error(
            response.data.message ?? "Não foi possível remover sua conta."
          );
        }
        return this.modalSucesso();
      } catch (error) {
        console.log("Recebido:");
        console.log(error);
        return toastr.error(
          error.response.data.message ??
            "Não foi possível complementar a operação..."
        );
      }
    },
    modalSucesso() {
      Swal.fire({
        confirmButtonColor: "#3085d6",
        title: "Conta removida",
        text: "Você será deslogado!",
        icon: "success",
      }).then(() => {
        localStorage.removeItem("registro");
        localStorage.removeItem("token");
        this.$router.push({name: "entrar"});
      });
    },
  },
};
</script>
