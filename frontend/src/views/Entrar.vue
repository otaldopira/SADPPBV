<script>
import { loading, modalAlert } from "../assets/js/global";
export default {
  data() {
    return {
      form: {
        registro: "",
        senha: "",
      },
    };
  },
  methods: {
    abrirModal() {
      Swal.fire({
        title: "Informe o ip e a porta:",
        input: "text",
        inputAttributes: {
          autocapitalize: "off",
        },
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        cancelButtonColor: "#FF5733",
        confirmButtonColor: "#50C878",
        confirmButtonText: "Salvar",
        showLoaderOnConfirm: true,
        inputValue: localStorage.getItem("url")
          ? localStorage.getItem("url")
          : "127.0.0.1:8000",
        preConfirm: (login) => {
          localStorage.setItem("url", login);
          axios.defaults.baseURL = `http://${login}`;
        },
        allowOutsideClick: () => !Swal.isLoading(),
      }).then((result) => {
        if (result.isConfirmed) {
          modalAlert("success", "URL setada com sucesso.");
        }
      });
    },
    async tentativaLogin() {
      loading();
      try {
        const response = await axios({
          method: "post",
          url: "/login",
          data: {
            registro: this.form.registro,
            senha: this.form.senha,
          },
        });
        Swal.close();
        console.log(response);
        if (response.data.success == false) {
          return modalAlert("error", response.data.message);
        }

        localStorage.setItem("token", response.data.token);
        this.$router.push("/menu");
      } catch (error) {
        console.log(error);
        modalAlert("error", "Não foi possível complementar a operação...");
      }
    },
  },
};
</script>
<template>
  <div class="m-auto h-full flex justify-center items-center mt-auto">
    <div
      class="w-2/5 h-3/5 p-6 flex flex-col gap-3 bg-white justify-center items-center rounded-md shadow-md"
    >
      <input
        v-model="form.registro"
        class="input-container"
        type="text"
        placeholder="Registro"
      />
      <input
        v-model="form.senha"
        class="input-container"
        type="password"
        placeholder="Senha"
      />

      <button
        @click="tentativaLogin"
        :disabled="form.registro == '' || form.senha == ''"
        class="disabled:cursor-not-allowed disabled:opacity-50 mt-5 tracking-wide font-semibold bg-teal-500 text-gray-100 w-full py-4 rounded-lg enabled:hover:bg-teal-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none"
      >
        <span>Entrar</span>
      </button>
      <button
        @click="abrirModal"
        class="mt-5 tracking-wide font-semibold bg-teal-500 text-gray-100 w-full py-4 rounded-lg enabled:hover:bg-teal-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none"
      >
        <div class="inline-flex gap-2">
          <span class="material-symbols-rounded"> smb_share </span>
          <span> Mudar Servidor</span>
        </div>
      </button>
    </div>
  </div>
</template>
<style>
.input-container {
  @apply w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white;
}
</style>
