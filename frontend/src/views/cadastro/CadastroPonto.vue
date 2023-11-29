<template>
  <div class="flex justify-center pt-5">
    <div class="bg-white p-8 rounded-lg shadow-lg w-2/5 flex flex-col gap-3">
      <h2 class="text-2xl mb-4 text-center font-bold">Cadastro de Ponto</h2>
      <!-- Formulário de cadastro -->
      <input-universal
        v-model:valor="nome"
        tipo="text"
        placeholder="nome"
      ></input-universal>
      <div class="text-center">
        <button
          @click="cadastroPonto"
          class="mt-5 tracking-wide text-white w-full py-4 rounded-lg bg-yellow-400 hover:bg-yellow-500 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none"
        >
          Cadastrar
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import InputUniversal from "/src/components/Input.vue";

export default {
  data() {
    return {
      nome: "",
    };
  },
  components: {
    "input-universal": InputUniversal,
  },
  methods: {
    async cadastroPonto() {
      try {
        this.$global.loading();
        const data = {
          nome: this.nome,
        };

        console.log("Enviado:");
        console.log(data);

        const response = await axios.post("/pontos", data);

        setTimeout(() => {
          Swal.close();
        }, 1000);

        console.log("Recebido:");
        console.log(response);

        if (response.data.success == false) {
          return toastr.error(
            response.data.message ?? "Não foi possível efetuar o cadastro."
          );
        }
        return toastr.success(
          response.data.message ?? "Ponto cadastrado com sucesso."
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
