<template>
  <div class="flex justify-center pt-5">
    <div class="bg-white p-8 rounded-lg shadow-lg w-2/5 flex flex-col gap-3">
      <h2 class="text-2xl mb-4 text-center font-bold">Cadastro de Usuário</h2>
      <!-- Formulário de cadastro -->
      <input-universal
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
      <select
        :class="{ 'text-gray-500': tipo_usuario != 0 && tipo_usuario !== 1 }"
        v-model="tipo_usuario"
        class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white"
      >
        <option selected disabled value="3">Selecione o tipo de usuário</option>
        <option value="0">Comum</option>
        <option value="1">Administrador</option>
      </select>
      <div class="text-center">
        <button
          @click="cadastroUsuario"
          class="mt-5 tracking-wide font-semibold bg-teal-500 text-gray-100 w-full py-4 rounded-lg enabled:hover:bg-teal-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none"
        >
          Cadastrar
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import InputUniversal from "../../../src/components/Input.vue";
import { loading, modalAlert } from "../../assets/js/global";
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
  watch: {
    registro(registro) {
      console.log(registro);
    },
  },
  methods: {
    async cadastroUsuario() {
      loading();

      try {
        const response = await axios.post(
          "/usuarios",
          {
            registro: this.registro,
            nome: this.nome,
            email: this.email,
            senha: this.senha,
            tipo_usuario: this.tipo_usuario,
          },
          {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token"),
            },
          }
        );
        Swal.close();
        console.log(response);
        if (response.data.success == false) {
          return modalAlert("error", response.data.message);
        }
        return modalAlert("success", response.data.message);
      } catch (error) {
        modalAlert("error", "Não foi possível complementar a operação...");
      }
    },
  },
};
</script>
