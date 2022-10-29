const checkBoleto = document.getElementById('doBoleto')
const numParcelaBoleto = document.getElementById('parcelasBoleto')

const checkCredCard = document.getElementById('doCredCard')
const numParcelaCredCard = document.getElementById('parcelasCredCard')

checkBoleto.addEventListener('click', () => {
   checkBoleto.checked === true ? numParcelaBoleto.style.display = "flex" : numParcelaBoleto.style.display = "none"
});

checkCredCard.addEventListener('click', () => {
  checkCredCard.checked === true ? numParcelaCredCard.style.display = "flex" : numParcelaCredCard.style.display = "none"
});