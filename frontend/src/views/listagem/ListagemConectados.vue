<template>
  <div class="w-full max-w-screen-xl mx-auto px-6">
    <div class="flex justify-center p-4 px-3 py-10">
      <div class="w-full max-w-md">
        <div class="bg-white shadow-md rounded-lg px-3 py-2 mb-4">
          <div class="block text-gray-700 text-lg font-semibold py-2 px-2">
            Usuários conectados
          </div>
          <div v-for="usuario in usuarios" :key="usuario.registro" class="text-sm">
           
            <div
              class="flex justify-start cursor-pointer text-gray-700 hover:text-blue-400 hover:bg-blue-100 rounded-md px-2 py-2 my-2"
            >
              <span class="bg-green-400 h-2 w-2 m-2 rounded-full"></span>
              <div class="flex-grow font-medium px-2">{{usuario.registro + ' - ' + usuario.nome}}</div>
              <div class="text-sm font-normal text-gray-500 tracking-wide">
                {{usuario.created_at}}
              </div>
            </div>
           
          </div>
          <div
            class="block bg-gray-200 text-sm text-right py-2 px-3 -mx-3 -mb-2 rounded-b-lg"
          >
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      usuarios: [],
    };
  },
  mounted() {
    this.obterUsuariosConectados();
  },
  methods: {
    async obterUsuariosConectados() {
      try {
        const response = await axios.get("/usuarios-conectados");
        console.log(response);
        this.usuarios = response.data;
      } catch (error) {
        console.error("Erro ao obter usuários conectados", error);
      }
    },
  },
};
</script>
