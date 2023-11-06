<template>
  <div class="flex justify-center items-center p-5">
    <table class="display" id="dataTable">
      <thead>
        <tr>
          <th>Registro</th>
          <th>Nome</th>
          <th>E-mail</th>
          <th>Tipo Usuário</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <template v-for="(usuario, index) in usuarios">
          <tr>
            <td>{{ usuario.registro }}</td>
            <td>{{ usuario.nome }}</td>
            <td>{{ usuario.email }}</td>
            <td>{{ usuario.tipo_usuario == 1 ? "Administrador" : "Comum" }}</td>
            <td>
              <div class="inline-flex gap-3 cursor-pointer">
                <span
                  class="material-symbols-rounded text-yellow-500"
                  @click="editarUsuario(usuario.registro)"
                >
                  edit </span
                ><span class="material-symbols-rounded text-red-500">
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
    editarUsuario(registro) {
      this.$router.push({
        name: "editar-usuario",
        params: { id: registro },
      });
    },
    verDetalhes(id) {
      this.$router.push("colaborador/" + id);
    },
    async buscarUsuarios() {
      this.$global.loading();
      var webApiUrl = "/usuarios";
      try {
        const response = await axios.get(webApiUrl);
        console.log(response);
        Swal.close();
        if (response.data.success == true) {
          this.usuarios = response.data.usuarios;
          this.$nextTick(() => {
            $("#dataTable").DataTable(this.opcoes);
          });
        } else {
          return this.$global.modalAlert(
            "error",
            response.data.message ?? "Não foi possível recuperar os usuários."
          );
        }
      } catch (error) {
        this.$global.modalAlert(
          "error",
          error.response.data.message ??
            "Não foi possível complementar a operação..."
        );
      }
    },
  },
  created() {},
  mounted() {
    this.buscarUsuarios();
  },
  data() {
    return {
      usuarios: [],
      opcoes: {
        language: {
          url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json",
        },
      },
      breadcrumbs: [
        { text: "Painel", to: "/painel" },
        { text: "Colaboradores", to: "" },
      ],
    };
  },
};
</script>
