const checkBoleto = document.getElementById('doBoleto')
const numParcelaBoleto = document.getElementById('parcelasBoleto')

const checkCredCard = document.getElementById('doCredCard')
const numParcelaCredCard = document.getElementById('parcelasCredCard')

  checkCredCard.addEventListener('click', () => {
    checkCredCard.checked === true ? numParcelaCredCard.classList.add('d-flex') : numParcelaCredCard.classList.remove('d-flex')
    checkCredCard.checked === false ? numParcelaCredCard.classList.remove('d-flex') : numParcelaCredCard.classList.add('d-none')
  });
  
  checkBoleto.addEventListener('click', () => {
    checkBoleto.checked === true ? numParcelaBoleto.classList.add('d-flex') : numParcelaBoleto.classList.remove('d-flex')
    checkBoleto.checked === false ? numParcelaBoleto.classList.remove('d-flex') : numParcelaBoleto.classList.add('d-none')
  });


