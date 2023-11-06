export function loading() {
  Swal.fire({
    title: "Verificando",
    imageUrl: '/public/wait-route.gif',
    imageHeight: 250,
    background: "#FFFFFF",
    showConfirmButton: false,
    allowOutsideClick: false,
  });
}

export function modalAlert(icon, message) {
  Swal.mixin({
    toast: true,
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
  }).fire({
    icon: icon,
    title: message,
  });
}
