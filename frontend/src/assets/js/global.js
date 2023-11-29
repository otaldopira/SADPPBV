export function loading() {
  const loadingSwal = Swal.fire({
    title: "Aguarde",
    imageUrl: "/public/wait-route.gif",
    imageHeight: 250,
    background: "#FFFFFF",
    showConfirmButton: false,
    allowOutsideClick: false,
  });

  return loadingSwal;
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
