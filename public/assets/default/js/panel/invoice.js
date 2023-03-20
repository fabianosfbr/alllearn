function copyText() {
  let codBar = document.getElementById("code-bar");
  navigator.clipboard.writeText(codBar.textContent);

  Toastify({
    text: "Código copiado",
    duration: 3000,
    close: true,
    gravity: "top",
    position: "right",
    style: {
      background: "#00A1F1"
    }
  }).showToast();
}