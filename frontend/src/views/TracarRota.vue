<!-- RotaComponent.vue -->

<template>
  <div class="w-3/5 m-auto">
    <h2 class="font-bold text-3xl my-5">Trace sua Rota</h2>
    <div class="flex flex-row gap-3 items-center">
      <!-- <input-universal
        v-model:valor="origem"
        tipo="text"
        placeholder="Origem"
      ></input-universal>
      <input-universal
        v-model:valor="destino"
        tipo="text"
        placeholder="Destino"
      ></input-universal> -->
      <select
        v-model="origem"
        class="shadow-md w-full px-8 py-4 rounded-lg font-medium bg-white border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white"
      >
        <option selected disabled value="null">Selecione Origem</option>
        <option
          v-for="(ponto, index) in pontos"
          :key="index"
          :value="ponto.nome"
        >
          {{ ponto.nome }}
        </option>
      </select>
      <select
        v-model="destino"
        class="shadow-md w-full px-8 py-4 rounded-lg font-medium bg-white border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white"
      >
        <option selected disabled value="null">Selecione Destino</option>
        <option
          v-for="(ponto, index) in pontos"
          :key="index"
          :value="ponto.nome"
        >
          {{ ponto.nome }}
        </option>
      </select>
      <button
        @click="consultarRotas"
        class="shadow-md text-white w-full py-4 rounded-lg bg-yellow-400 hover:bg-yellow-500 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none"
      >
        Buscar
      </button>
    </div>

    <div v-if="rotas.length > 0" class="mt-5 pb-32">
      <h3 class="font-bold text-2xl my-3">Resultado:</h3>
      <table class="w-full min-w-max table-auto text-left shadow-md">
        <thead>
          <tr>
            <th class="border-y border-blue-gray-100 bg-gray-200 p-5">ID</th>
            <th class="border-y border-blue-gray-100 bg-gray-200 p-5">
              Ponto Inicial
            </th>
            <th class="border-y border-blue-gray-100 bg-gray-200 p-5">
              Ponto Final
            </th>
            <th class="border-y border-blue-gray-100 bg-gray-200 p-5">
              Distância (m)
            </th>
            <th class="border-y border-blue-gray-100 bg-gray-200 p-5">
              Direção
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="rota, index in rotas" :key="rota.id" >
            <td class="p-4 border-b border-gray-50 bg-white">{{ rota.segmento_id }}</td>
            <td class="p-4 border-b border-gray-50 bg-white">
              {{ rota.ponto_inicial }}
            </td>
            <td class="p-4 border-b border-gray-50 bg-white">{{ rota.ponto_final }}</td>
            <td class="p-4 border-b border-gray-50 bg-white">{{ rota.distancia }}</td>
            <td class="p-4 border-b border-gray-50 bg-white">
              {{
                index === rotas.length - 1
                  ? rota.direcao + " -> Chegada"
                  : rota.direcao
              }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import InputUniversal from "/src/components/Input.vue";
export default {
  data() {
    return {
      origem: "",
      destino: "",
      pontos: [],
      rotas: [],
    };
  },
  created() {
    this.buscarPontos();
  },
  components: {
    InputUniversal,
  },
  methods: {
    findById(segmento_id) {
      for (var ponto of this.pontos) {
        if (ponto.ponto_id == segmento_id) {
          return ponto.nome;
        }
      }
    },
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
    async consultarRotas() {
      try {
        this.$global.loading();
        const webApiUrl = "/rotas";
        const data = {
          origem: this.origem,
          destino: this.destino,
        };
        const response = await axios.post(webApiUrl, data);
        console.log("Recebido:");
        console.log(response);

        if (response.data.success == true) {
          this.chegada =
            response.data.rota[response.data.rota.length - 1].ponto_final;
          this.rotas = response.data.rota;
          return toastr.success(response.data.message);
        }

        return toastr.error(response.data.message);
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
