<template>
  <div class="flex justify-center pt-5">
    <div class="bg-white p-8 rounded-lg shadow-lg w-2/5 flex flex-col gap-3">
      <!-- Formulário de cadastro -->
      <input-universal
        class="cursor-not-allowed"
        disabled
        v-model:valor="registro"
        tipo="number"
        placeholder="Registro"
      ></input-universal>
      <input-universal
        v-model:valor="nome"
        tipo="text"
        placeholder="Nome"
      ></input-universal>
      <input-universal
        v-model:valor="email"
        tipo="email"
        placeholder="E-mail"
      ></input-universal>
      <input-universal
        v-model:valor="senha"
        tipo="password"
        placeholder="Senha"
      ></input-universal>
      <!-- <select
        :class="{ 'text-gray-500': tipo_usuario != 0 && tipo_usuario !== 1 }"
        v-model="tipo_usuario"
        class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white"
      >
        <option selected disabled value="3">Selecione o tipo de usuário</option>
        <option value="0">Comum</option>
        <option value="1">Administrador</option>
      </select> -->
      <div class="text-center">
        <button
          @click="atualizarUsuario"
          class="mt-5 tracking-wide text-white w-full py-4 rounded-lg bg-yellow-400 hover:bg-yellow-500 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none"
        >
          Atualizar
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import InputUniversal from "/src/components/Input.vue";
import { MD5 } from "crypto-js";

export default {
  data() {
    return {
      registro: "",
      nome: "",
      email: "",
      senha: "",
      tipo_usuario: 3,
    };
  },
  components: {
    "input-universal": InputUniversal,
  },
  created() {
    this.registro = this.$route.params.id;
    if (this.registro) {
      this.buscarUsuario();
    }
  },
  mounted() {},
  methods: {
    async buscarUsuario() {
      this.$global.loading();
      var webApiUrl = `/usuarios/${this.registro}`;

      try {
        const response = await axios.get(webApiUrl).then(
          setTimeout(() => {
            Swal.close();
          }, 1000)
        );
      
        if (response.data.success == true) {
          const user = response.data.usuario;
          this.nome = user.nome;
          this.email = user.email;
          this.tipo_usuario = user.tipo_usuario;
        } else {
          this.$global.modalAlert(
            "error",
            "Não foi possível recuperar os usuários."
          );
        }
      } catch (error) {
        this.$global.modalAlert(
          "error",
          "Ocorreu um erro ao buscar os usuários."
        );
      }
    },
    async atualizarUsuario() {
      this.$global.loading();
      const data = {
        nome: this.nome,
        email: this.email,
        senha: MD5(this.senha).toString(),
        tipo_usuario: this.tipo_usuario,
      };
      console.log("Enviado:");
      console.log(data);
      try {
        const response = await axios
          .put(`/usuarios/${this.$route.params.id}`, data)
          .then(
            setTimeout(() => {
              Swal.close();
            }, 1000)
          );

        console.log("Recebido:");
        console.log(response);

        if (response.data.success == false) {
          return toastr.error(
            response.data.message ?? "Não foi possível efetuar o login."
          );
        }

        return toastr.success(
          response.data.message ?? "Usuário editado com sucesso."
        );
      } catch (error) {
        console.log("Recebido:");
        console.log(error);
        return toastr.error(
          error.response.data.message ??
            "Não foi possível complementar a operação..."
        );
      }
    },
  },
};
</script>
