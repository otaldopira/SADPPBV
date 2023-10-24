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
      name: "menu",
      component: () => import("../views/Menu.vue"),
      children: [
        {
          path: "cadastrar-usuario",
          component: () => import("../views/cadastro/CadastroUsuario.vue"),
        },
      ],
    },
  ],
});

export default router;
