const alllearnPayment = document.getElementById('alllearnPay');
const gatewayPayment = document.getElementById('gatewayPay');
const choseCredCard = document.getElementById('choseCredCard');

$('input[type=radio]').on('click', function() {
    $('input[name="boleto"]:checked').not(this).prop('checked', false)
    $('input[name="pix"]:checked').not(this).prop('checked', false)
    $('input[name="credCard"]:checked').not(this).prop('checked', false)
});

$('body').on('click','input[name="gateway"]',() => {
  $('input[name="gateway"]:checked').not(this).prop('checked', true)
  $('input[name="alllearn"]:checked').not(this).prop('checked', false)
  $("#personalInfo").addClass("d-block")
  $("#paymentOptions").addClass("d-block")
  $('#paymentSubmit').prop('disabled', true)
});

$('body').on("click",'input[name="alllearn"]',() => {
  $('input[name="gateway"]:checked').not(this).prop('checked', false)
  $('input[name="alllearn"]:checked').not(this).prop('checked', true)
  $("#personalInfo").removeClass("d-block")
  $('#paymentSubmit').prop('disabled', false)
});

$('body').on("click",'input[name="credCard"]',() => {
  $("#infoCredCard").addClass("d-block")
  $("#infoInvoice").removeClass("d-block")
});

$('body').on("click",'input[name="boleto"]', () => {
  $("#infoInvoice").addClass("d-block")
  $("#infoCredCard").removeClass("d-block")
});

$('body').on("click",'input[name="pix"]',() => {
  $("#infoCredCard").removeClass("d-block")
  $("#infoInvoice").removeClass("d-block")
});

function toggleButton() {
  const nome = document.querySelector('#first_name').value
  const segundoNome = document.querySelector('#last_name').value
  const telefone = document.querySelector('#phone').value
  const cpfOrCnpj = document.querySelector('#docNumber').value
  const cep = document.querySelector('#cep').value
  const street = document.querySelector('#street').value
  const numStreet = document.querySelector('#numStreet').value
  const city = document.querySelector('#city').value
  const state = document.querySelector('#state').value
  const district = document.querySelector('#district').value

  if (nome && segundoNome && telefone && cpfOrCnpj && cep && street && numStreet && city && state && district) {
      document.querySelector('#paymentSubmit').disabled = false
      return
  }   document.querySelector('#paymentSubmit').disabled = true
};
