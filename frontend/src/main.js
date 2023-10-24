import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import "./assets/css/index.css";

createApp(App).use(router).mount("#app");

axios.defaults.baseURL = "http://" + localStorage.getItem("url");

// axios.interceptors.response.use(
//     (response) => response,
//     (error) => {
//         if (error.response.status === 401)
//             router.push('/entrar')
//         return Promise.reject(error)
//     }
// )

// axios.interceptors.request.use((config) => {
//     const token = getCookie('gtkn')
//     config.headers.Authorization = `Bearer ${token}`
//     return config
// })

// function getCookie(name) {
//     const value = `; ${document.cookie}`
//     const parts = value.split(`; ${name}=`)
//     if (parts.length === 2)
//         return parts.pop().split(';').shift()
// }
