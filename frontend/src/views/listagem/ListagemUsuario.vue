<template>
  <div v-show="success" class="flex justify-center items-center p-5">
    <table class="display py-8" id="dataTable">
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
                ><span
                  @click="modalConfirm(usuario.registro, index)"
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
    editarUsuario(registro) {
      this.$router.push({
        name: "editar-usuario",
        params: { id: registro },
      });
    },
    async buscarUsuarios() {
      this.$global.loading();
      var webApiUrl = "/usuarios";

      try {
        const response = await axios.get(webApiUrl).then(
          setTimeout(() => {
            Swal.close();
          }, 1000)
        );

        console.log("Recebido:");
        console.log(response);

        if (response.data.success == true) {
          this.success = true
          this.usuarios = response.data.usuarios;
          this.$nextTick(() => {
            $("#dataTable").DataTable(this.opcoes);
          });
        } else {
          return toastr.error(
            response.data.message ?? "Não foi possível recuperar os usuários."
          );
        }
      } catch (error) {
        console.log("Recebido:");
        console.log(error);

        return toastr.error(
          error.response.data.message ??
            "Não foi possível complementar a operação..."
        );
      }
    },
    modalConfirm(registro, index) {
      Swal.fire({
        title: "Você realmente deseja remover este usuário ?",
        icon: "warning",
        showCancelButton: true,
        focusCancel: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim",
        cancelButtonText: "Não",
      }).then((result) => {
        if (result.isConfirmed) {
          this.removerConta(registro, index);
        }
      });
    },
    async removerConta(registro, index) {
      this.$global.loading();
      try {
        const response = await axios.delete(`/usuarios/${registro}`);
        await new Promise((resolve) => setTimeout(resolve, 2000));
        console.log("Recebido:");
        console.log(response);

        if (response.data.success == false) {
          return toastr.error(
            response.data.message ?? "Não foi possível remover sua conta."
          );
        }
        console.log("usuários");
        console.log(this.usuarios);

        console.log("index:" + index);
        this.usuarios.splice(index, 1);

        if (localStorage.getItem("registro") == registro) {
          localStorage.removeItem("registro");
          localStorage.removeItem("token");
          this.$router.push("/entrar");
          return this.modalSucesso("Conta removida", "Você será deslogado!");
        }
        return this.modalSucesso();
      } catch (error) {
        console.log("Recebido:");
        console.log(error);
        return toastr.error(
          error.response.data.message ??
            "Não foi possível complementar a operação..."
        );
      }
    },
    modalSucesso(title, subtitle) {
      Swal.fire({
        confirmButtonColor: "#3085d6",
        title: title ?? "Usuário removido",
        text: subtitle ?? " ",
        icon: "success",
      });
    },
  },
  created() {
    this.buscarUsuarios();
  },
  data() {
    return {
      usuarios: [],
      success: false,
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
