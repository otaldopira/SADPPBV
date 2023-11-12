import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', redirect: '/entrar' },
    {
      path: "/entrar",
      name: "entrar",
      component: () => import("../views/Entrar.vue"),
    },
    {
      path: "/menu",
      component: () => import("../views/Menu.vue"),
      children: [
        {
          path: "",
          name: "menu",
          props: true,
          component: () => import("../views/menu/OpcoesMenu.vue"),
        },
        {
          path: "cadastrar-usuario",
          name: "cadastrar-usuario",
          component: () => import("../views/cadastro/CadastroUsuario.vue"),
        },
        {
          path: "edicao-usuario/:id",
          name: "editar-usuario",
          component: () => import("../views/edicao/EdicaoUsuario.vue"),
        },
        {
          path: "listar-usuarios",
          name: "listar-usuarios",
          component: () => import("../views/listagem/ListagemUsuario.vue"),
        },
        {
          path: "minha-conta",
          name: "minha-conta",
          component: () => import("../views/MinhaConta.vue"),
        },
      ],
    },
  ],
});

export default router;
