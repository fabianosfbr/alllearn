document.addEventListener('DOMContentLoaded', function () {
    window.Mercadopago.setPublishableKey("TEST-f3432cbf-2bab-4769-ad27-9659221ea4f5");
    window.Mercadopago.getIdentificationTypes();

    if (document.getElementById('cardNumber')) {
        document.getElementById('cardNumber').addEventListener('keyup', guessPaymentMethod);
    }

    function guessPaymentMethod(event) {

        let cardnumber = document.getElementById("cardNumber").value;
        if (cardnumber.length >= 6) {
            let bin = cardnumber.substring(0, 6);

            window.Mercadopago.getPaymentMethod({
                "bin": bin
            }, setPaymentMethod);
        }
    };

    function setPaymentMethod(status, response) {
        if (status == 200) {
            let paymentMethod = response[0];
            document.getElementById('paymentMethodId').value = paymentMethod.id;
            document.querySelector('.brand').innerHTML = "<img src='" + response[0].thumbnail + "' alt='bandeira do cartão'>";
            getIssuers(paymentMethod.id);
        } else {
            $.toast({
                heading: 'Ops, tivemos um problema',
                text: 'Cartão de crédito é inválido',
                position: 'top-right',
                icon: 'error'
            })
        }
    }

    function getIssuers(paymentMethodId) {
        window.Mercadopago.getIssuers(
            paymentMethodId,
            setIssuers
        );
    }

    function setIssuers(status, response) {
        if (status == 200) {
            let issuerSelect = document.getElementById('issuer');
            response.forEach(issuer => {
                let opt = document.createElement('option');
                opt.text = issuer.name;
                opt.value = issuer.id;
                issuerSelect.appendChild(opt);
            });

            getInstallments(
                document.getElementById('paymentMethodId').value,
                document.getElementById('transactionAmount').value,
                issuerSelect.value
            );
        } else {
            $.toast({
                heading: 'Ops, tivemos um problema',
                text: 'Verifique os dados do cartão',
                position: 'top-right',
                icon: 'error'
            })
        }
    }

    function getInstallments(paymentMethodId, transactionAmount, issuerId) {
        window.Mercadopago.getInstallments({
            "payment_method_id": paymentMethodId,
            "amount": parseFloat(transactionAmount),
            "issuer_id": parseInt(issuerId)
        }, setInstallments);
    }

    function setInstallments(status, response) {
        if (status == 200) {
            document.getElementById('installments_number').classList.remove("d-none");
            document.getElementById('installments').options.length = 0;
            let maxInstallments = document.getElementById('creditCardInstallment').value;
            for (let i = 0; i < maxInstallments; i++) {
                let opt = document.createElement('option');
                opt.text = response[0].payer_costs[i].recommended_message;
                opt.value = response[0].payer_costs[i].installments;
                document.getElementById('installments').appendChild(opt);
            }


        } else {
            $.toast({
                heading: 'Ops, tivemos um problema',
                text: 'Verifique os dados do cartão',
                position: 'top-right',
                icon: 'error'
            })
        }
    }

    if (document.getElementById('paymentForm')) {
        doSubmit = false;
        document.getElementById('paymentForm').addEventListener('submit', getCardToken);
        function getCardToken(event) {

            let $ccf = document.getElementById('creditCardForm');
            event.preventDefault();
            if (!doSubmit) {
                if($ccf.value === 'true'){
                    let $form = document.getElementById('paymentForm');
                    window.Mercadopago.createToken($form, setCardTokenAndPay);
                    return false;

                    return false;
                }else{
                   submitionWithoutCreditCardRules();
                    return false;
                }

            }
        };
    }

    function submitionWithoutCreditCardRules(){
        let form = document.getElementById('paymentForm');
        doSubmit = true;
        form.submit();
    }

    function setCardTokenAndPay(status, response) {
        if (status == 200 || status == 201) {
            let form = document.getElementById('paymentForm');
            let card = document.createElement('input');
            card.setAttribute('name', 'token');
            card.setAttribute('type', 'hidden');
            card.setAttribute('value', response.id);
            form.appendChild(card);
            doSubmit = true;
            form.submit();
        } else {
            $.toast({
                heading: 'Ops, tivemos um problema',
                text: 'Verifique os dados do cartão',
                position: 'top-right',
                icon: 'error'
            })

        }
    };

}, false);

