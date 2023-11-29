<template>
  <div v-show="success" class="flex justify-center items-center p-5">
    <table class="display py-8" id="dataTable">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <template v-for="(ponto, index) in pontos">
          <tr>
            <td class="w-1/6">{{ ponto.ponto_id }}</td>
            <td>{{ ponto.nome }}</td>
            <td class="w-1/5">
              <div class="inline-flex gap-3 cursor-pointer">
                <span
                  class="material-symbols-rounded text-yellow-500"
                  @click="editarPonto(ponto.ponto_id)"
                >
                  edit </span
                ><span
                  @click="modalConfirm(ponto.ponto_id, index)"
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
        name: "editar-ponto",
        params: { id: id },
      });
    },
    async buscarPontos() {
      this.$global.loading();
      var webApiUrl = "/pontos";

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
          this.pontos = response.data.pontos;
          this.$nextTick(() => {
            $("#dataTable").DataTable(this.opcoes);
          });
          return toastr.success(
            response.data ? response.data.message : "Pontos recuperados."
          );
        } else {
          return toastr.error(
            response.data
              ? response.data.message
              : "Não foi possível recuperar os pontos."
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
        title: "Você realmente deseja remover este ponto ?",
        icon: "warning",
        showCancelButton: true,
        focusCancel: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim",
        cancelButtonText: "Não",
      }).then((result) => {
        if (result.isConfirmed) {
          this.removerPonto(id, index);
        }
      });
    },
    async removerPonto(id, index) {
      try {
        const response = await axios.delete(`/pontos/${id}`);
        console.log("Recebido:");
        console.log(response);

        if (response.data.success == false) {
          return toastr.error(response.data.message);
        }

        console.log(response);
        this.pontos.splice(index, 1);

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
        title: title ?? "Ponto removido",
        text: subtitle ?? " ",
        icon: "success",
      });
    },
  },
  created() {
    this.buscarPontos();
  },
  data() {
    return {
      pontos: [],
      success: false,
      opcoes: {
        language: {
          url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json",
        },
      },
    };
  },
};
</script>
