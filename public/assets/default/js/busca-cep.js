document.addEventListener('DOMContentLoaded', function () {

    if (document.getElementById('zip_code')) {
        document.getElementById('zip_code').addEventListener('blur', buscaCep);
    }

    function buscaCep(event) {
        let value = document.getElementById("zip_code").value.replace(/[^0-9]+/, '');
        const url = `https://viacep.com.br/ws/${value}/json/`;


        fetch(url).then(response => {
            return response.json();
        })
            .then(data => {
                if (data.erro) {
                    getError();

                    document.getElementById("zip_code").focus();
                    return;
                }
                atribuirCampos(data);
                document.getElementById("street_number").focus();
            }).catch(function () {
                getError();
            })


    }

    function atribuirCampos(data) {
        document.getElementById('street_name').value = data.logradouro
        document.getElementById('neigborhood').value = data.bairro
        document.getElementById('city').value = data.localidade
        document.getElementById('federal_unit').value = data.uf

    }

    function getError() {
        $.toast({
            heading: 'Ops, tivemos um problema',
            text: 'O CEP digitado é inválido',
            position: 'top-right',
            icon: 'error'
        })
    }



}, false);

