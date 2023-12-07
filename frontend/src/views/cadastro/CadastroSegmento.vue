<template>
  <div class="flex justify-center pt-5">
    <div class="bg-white p-8 rounded-lg shadow-lg w-2/5 flex flex-col gap-3">
      <h2 class="text-2xl mb-4 text-center font-bold">Cadastro de Segmento</h2>
      <!-- Formulário de cadastro -->
      <!-- <input-universal
        v-model:valor="ponto_inicial"
        tipo="text"
        placeholder="Início"
      ></input-universal> -->
      <!-- <input-universal
        v-model:valor="ponto_final"
        tipo="text"
        placeholder="Fim"
      ></input-universal> -->
      <select
        :class="{ 'text-gray-500': status != 0 && status != 1 }"
        v-model="ponto_inicial"
        class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white"
      >
        <option selected disabled value="null">Selecione Ponto Inicial</option>
        <option
          v-for="(ponto, index) in pontos"
          :key="index"
          :value="ponto.ponto_id"
        >
          {{ ponto.nome }}
        </option>
      </select>
      <select
        :class="{ 'text-gray-500': status != 0 && status != 1 }"
        v-model="ponto_final"
        class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white"
      >
        <option selected disabled value="null">Selecione Ponto Final</option>
        <option
          v-for="(ponto, index) in pontos"
          :key="index"
          :value="ponto.ponto_id"
        >
          {{ ponto.nome }}
        </option>
      </select>

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
      pontos: [],
      ponto_inicial: null,
      ponto_final: null,
      distancia: null,
      direcao: null,
      status: 2,
    };
  },
  watch: {
    ponto_inicial(ponto_inicial) {
      console.log(ponto_inicial);
    },
  },
  components: {
    "input-universal": InputUniversal,
  },
  created() {
    this.buscarPontos();
  },
  methods: {
    async buscarPontos() {
      this.$global.loading();
      var webApiUrl = "/pontos";
      try {
        const response = await axios.get(webApiUrl);

        console.log("Recebido:");
        console.log(response);

        if (response.data.success == true) {
          this.success = true;
          this.pontos = response.data.pontos.sort((a, b) => {
            var x = a.nome.toLowerCase();
            var y = b.nome.toLowerCase();
            return x < y ? -1 : x > y ? 1 : 0;
          });
          this.$nextTick(() => {
            $("#dataTable").DataTable(this.opcoes);
          });
        }
      } catch (error) {
        console.log("Recebido:");
        console.log(error);

        return toastr.error(
          error.response
            ? error.response.data.message
            : "Não foi possível complementar a operação..."
        );
      } finally {
        setTimeout(() => {
          Swal.close();
        }, 1000);
      }
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
        const response = await axios.post("/segmentos", data);

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
      } finally {
        setTimeout(() => {
          Swal.close();
        }, 1000);
      }
    },
  },
};
</script>
