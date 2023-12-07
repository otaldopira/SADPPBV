<template>
  <div v-show="success" class="flex justify-center items-center p-5">
    <table class="display py-8" id="dataTable">
      <thead>
        <tr>
          <th>Início</th>
          <th>Fim</th>
          <th>Distância</th>
          <th>Direção</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <template v-for="(segmento, index) in segmentos">
          <tr>
            <td>{{ segmento.ponto_inicial }}</td>
            <td>{{ segmento.ponto_final }}</td>
            <td>{{ segmento.distancia }}</td>
            <td>{{ segmento.direcao }}</td>
            <td>
              <div
                :class="{
                  ativo: segmento.status == 1,
                  inativo: segmento.status == 0,
                }"
              >
                {{ segmento.status == 1 ? "Ativo" : "Inativo" }}
              </div>
            </td>
            <td class="w-1/5">
              <div class="inline-flex gap-3 cursor-pointer">
                <span
                  class="material-symbols-rounded text-yellow-500"
                  @click="editarPonto(segmento.segmento_id)"
                >
                  edit </span
                ><span
                  @click="modalConfirm(segmento.segmento_id, index)"
                  class="material-symbols-rounded text-red-500"
                >
                  delete
                </span>
              </div>
            </td>
          </tr>
        </template>
      </tbody>
    </table>
  </div>
</template>
<script>
export default {
  methods: {
    editarPonto(id) {
      this.$router.push({
        name: "editar-segmento",
        params: { id: id },
      });
    },
    async buscarSegmentos() {
      this.$global.loading();
      var webApiUrl = "/segmentos";

      try {
        const response = await axios.get(webApiUrl).then(
          setTimeout(() => {
            Swal.close();
          }, 1000)
        );

        console.log("Recebido:");
        console.log(response);

        if (response.data.success == true) {
          this.success = true;
          this.segmentos = response.data.segmentos;
          this.$nextTick(() => {
            $("#dataTable").DataTable(this.opcoes);
          });
          return toastr.success(
            response.data ? response.data.message : "Segmentos recuperados."
          );
        } else {
          return toastr.error(
            response.data
              ? response.data.message
              : "Não foi possível recuperar os Segmentos."
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
    modalConfirm(id, index) {
      Swal.fire({
        title: "Você realmente deseja remover este Segmento ?",
        icon: "warning",
        showCancelButton: true,
        focusCancel: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim",
        cancelButtonText: "Não",
      }).then((result) => {
        if (result.isConfirmed) {
          this.removerSegmento(id, index);
        }
      });
    },
    async removerSegmento(id, index) {
      try {
        const response = await axios.delete(`/segmentos/${id}`);
        console.log("Recebido:");
        console.log(response);

        if (response.data.success == false) {
          return toastr.error(response.data.message);
        }

        console.log(response);
        this.segmentos.splice(index, 1);

        return this.modalSucesso();
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
    modalSucesso(title, subtitle) {
      Swal.fire({
        confirmButtonColor: "#3085d6",
        title: title ?? "Segmento removido",
        text: subtitle ?? " ",
        icon: "success",
      });
    },
  },
  created() {
    this.buscarSegmentos();
  },
  data() {
    return {
      segmentos: [],
      success: false,
      opcoes: {
        language: {
          url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json",
        },
        order: [],
      },
    };
  },
};
</script>
<style>
.ativo {
  @apply inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-teal-500 text-white;
}

.inativo {
  @apply inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-red-500 text-white;
}
</style>
