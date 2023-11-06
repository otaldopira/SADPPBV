import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import "./assets/css/index.css";
import * as Global from "./assets/js/global.js";

const app = createApp(App);
app.use(router);
app.config.globalProperties.$global = Global;
app.mount("#app");

axios.defaults.baseURL = "http://" + localStorage.getItem("url");



axios.interceptors.request.use((config) => {
    const token = localStorage.getItem("token")
    config.headers.Authorization = `Bearer ${token}`
    return config
})

// axios.interceptors.response.use(
//     (response) => response,
//     (error) => {
//         if (error.response.status === 401)
//             router.push('/entrar')
//         return Promise.reject(error)
//     }
// )

// function getCookie(name) {
//     const value = `; ${document.cookie}`
//     const parts = value.split(`; ${name}=`)
//     if (parts.length === 2)
//         return parts.pop().split(';').shift()
// }
