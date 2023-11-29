import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', redirect: {name: "entrar"} },
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
          path: "cadastrar-ponto",
          name: "cadastrar-ponto",
          component: () => import("../views/cadastro/CadastroPonto.vue"),
        },
        {
          path: "cadastrar-segmento",
          name: "cadastrar-segmento",
          component: () => import("../views/cadastro/CadastroSegmento.vue"),
        },
        {
          path: "edicao-usuario/:id",
          name: "editar-usuario",
          component: () => import("../views/edicao/EdicaoUsuario.vue"),
        },
        {
          path: "edicao-ponto/:id",
          name: "editar-ponto",
          component: () => import("../views/edicao/EdicaoPonto.vue"),
        },
        {
          path: "edicao-segmento/:id",
          name: "editar-segmento",
          component: () => import("../views/edicao/EdicaoSegmento.vue"),
        },
        {
          path: "listar-usuarios",
          name: "listar-usuarios",
          component: () => import("../views/listagem/ListagemUsuario.vue"),
        },
        {
          path: "listar-pontos",
          name: "listar-pontos",
          component: () => import("../views/listagem/ListagemPontos.vue"),
        },
        {
          path: "listar-segmentos",
          name: "listar-segmentos",
          component: () => import("../views/listagem/ListagemSegmentos.vue"),
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
