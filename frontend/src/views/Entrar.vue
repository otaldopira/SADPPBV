<script>
import { MD5 } from "crypto-js";

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
      });
    },
    async tentativaLogin() {
      try {
        this.$global.loading();

        const data = {
          registro: this.form.registro,
          senha: MD5(this.form.senha).toString(),
        };

        console.log("Enviado:(Login)");
        console.log(data);

        const response = await axios({
          method: "post",
          url: "/login",
          data: data,
        });

        console.log("Recebido:(Login)");
        console.log(response);

        if (response.data.success == false) {
          toastr.error(
            response.data.message ?? "Não foi possível efetuar o login."
          );
        }

        localStorage.setItem("token", response.data.token);
        localStorage.setItem("registro", response.data.registro);
        if (response.data.registro) {
          this.buscarUsuario(response.data.registro);
        }
      } catch (error) {
        setTimeout(() => {
          Swal.close();
        }, 1000);
        toastr.error(
          error.response.data.message ??
            "Não foi possível complementar a operação..."
        );
      }
    },
    async buscarUsuario(registro) {
      const reg = registro;
      var webApiUrl = `/usuarios/` + reg;

      try {
        const response = await axios.get(webApiUrl);

        if (response.data.success == true) {
          localStorage.setItem(
            "usuario",
            JSON.stringify(response.data.usuario)
          );
        }
        this.$router.push({ name: "menu" });
      } catch (error) {
       
      } finally {
        setTimeout(() => {
          Swal.close();
        }, 1000);
      }
    },
  },
};
</script>
<template>
  <div class="m-auto h-screen flex justify-center items-center">
    <div
      class="overflow-y-hidden w-2/5 h-4/5 p-6 flex flex-col gap-3 bg-white justify-center items-center rounded-md shadow-md"
    >
      <div class="mb-8">
        <img
          src="src\assets\imagens\logo-utf-mais-prod.svg"
          width="250"
          alt="logo UTFPR"
        />
      </div>
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
        class="disabled:cursor-not-allowed disabled:opacity-50 mt-5 tracking-wide font-semibold bg-yellow-400 text-gray-100 w-full py-4 rounded-lg enabled:hover:bg-yellow-500 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none"
      >
        <span>Entrar</span>
      </button>
      <button
        @click="abrirModal"
        class="mt-5 tracking-wide font-semibold bg-yellow-400 text-gray-100 w-full py-4 rounded-lg enabled:hover:bg-yellow-500 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none"
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
