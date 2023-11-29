<template>
  <div class="flex justify-center pt-5">
    <div class="bg-white p-8 rounded-lg shadow-lg w-2/5 flex flex-col gap-3">
      <h2 class="text-2xl mb-4 text-center font-bold">Cadastro de Segmento</h2>
      <!-- Formulário de cadastro -->
      <input-universal
        v-model:valor="ponto_inicial"
        tipo="text"
        placeholder="Início"
      ></input-universal>
      <input-universal
        v-model:valor="ponto_final"
        tipo="text"
        placeholder="Fim"
      ></input-universal>
      <input-universal
        v-model:valor="distancia"
        tipo="number"
        placeholder="Distância"
      ></input-universal>
      <input-universal
        v-model:valor="direcao"
        tipo="text"
        placeholder="Direção"
      ></input-universal>
      <select
        :class="{ 'text-gray-500': status != 0 && status != 1 }"
        v-model="status"
        class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white"
      >
        <option selected disabled value="2">Selecione o status</option>
        <option value="1">Ativo</option>
        <option value="0">Inativo</option>
      </select>
      <div class="text-center">
        <button
          @click="cadastroSegmento"
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
      ponto_inicial: null,
      ponto_final: null,
      distancia: null,
      direcao: null,
      status: 2,
    };
  },

  components: {
    "input-universal": InputUniversal,
  },

  methods: {
    verPontos() {
      Swal.fire({
        title: "<i>Pontos</i>",
        html: ``,
        confirmButtonText: "Fechar",
      });
    },
    async cadastroSegmento() {
      try {
        this.$global.loading();
        const data = {
          ponto_inicial: this.ponto_inicial,
          ponto_final: this.ponto_final,
          distancia: this.distancia,
          status: this.status,
          direcao: this.direcao,
        };
        console.log("Enviado:");
        console.log(data);
        const response = await axios.post("/segmentos", data).then(
          setTimeout(() => {
            Swal.close();
          }, 1000)
        );

        console.log("Recebido:");
        console.log(response);

        if (response.data.success == false) {
          return toastr.error(response.data.message);
        }
        return toastr.success(response.data.message);
      } catch (error) {
        console.log("Recebido:");
        console.log(error);
        return toastr.error(
          error.response
            ? error.response.data.message
            : "Não foi possível complementar a operação..."
        );
      }
    },
  },
};
</script>
