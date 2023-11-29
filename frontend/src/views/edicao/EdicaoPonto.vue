<template>
  <div class="flex justify-center pt-5">
    <div class="bg-white p-8 rounded-lg shadow-lg w-2/5 flex flex-col gap-3">
      <!-- Formulário de cadastro -->
      <input-universal
        v-model:valor="nome"
        tipo="text"
        placeholder="nome"
      ></input-universal>
      <div class="text-center">
        <button
          @click="atualizarPonto"
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

export default {
  data() {
    return {
      id: null,
      nome: "",
    };
  },
  components: {
    "input-universal": InputUniversal,
  },
  created() {
    console.log(this.$route);
    this.id = this.$route.params.id;
    this.buscarPonto();
  },
  methods: {
    async buscarPonto() {
      const webApiUrl = `/pontos/${this.id}`;

      try {
        this.$global.loading();
        const response = await axios.get(webApiUrl);

        console.log("Recebido:");
        console.log(response);

        setTimeout(() => {
          Swal.close();
        }, 1000);

        if (response.data.success == true) {
          const ponto = response.data.ponto;
          this.nome = ponto.nome;

          return toastr.success(
            response.data ? response.data.message : "Ponto atualizado."
          );
        } else {
          return toastr.error(
            response.data
              ? response.data.message
              : "Não foi possível recuperar o ponto."
          );
        }
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
    async atualizarPonto() {
      const load = this.$global.loading();

      try {
        const data = {
          nome: this.nome,
        };

        console.log("Enviado:");
        console.log(data);

        const response = await axios.put("/pontos/" + this.id, data).then(
          setTimeout(() => {
            Swal.close();
          }, 1000)
        );

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
