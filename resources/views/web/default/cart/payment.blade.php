@extends(getTemplate().'.layouts.app')


@section('content')
<section class="cart-banner position-relative text-center">
    <h1 class="font-30 text-white font-weight-bold">{{ trans('cart.checkout') }}</h1>
    <span class="payment-hint font-20 text-white d-block">{{$currency . $total . ' ' .  trans('cart.for_items',['count' => $count]) }}</span>
</section>

<section x-data="payment()" class="container mt-45" x-init="mpOptions">
    <h2 class="section-title">{{ trans('financial.select_a_payment_gateway') }}</h2>

    <form action="/payments/payment-request" method="post" id="form-checkout" class=" mt-25">
        {{ csrf_field() }}
        <input type="hidden" name="order_id" value="{{ $order->id }}">


        <div class="row">
            {{-- Botão para pagar com boleto, pix ou cartão --}}
            <div class="col-6 col-lg-4 mb-40 charge-account-radio">
                <input type="radio" name="payment_option" id="gateway" value="gateway" @click="showForm=true, showPaymentMethod=true">
                <label for="gateway" class="rounded-sm p-20 p-lg-45 d-flex flex-column align-items-center justify-content-center">
                    <img src="/assets/default/img/activity/pay.svg" width="120" height="60" alt="">

                    <p class="mt-30 mt-lg-50 font-weight-500 text-dark-blue">
                    <div class="text-center">Pagar com</div>
                    <span class="font-weight-bold">Boleto, Pix ou Cartão</span>
                    </p>
                </label>
            </div>

            {{-- Botão para pagar com saldo All Learn --}}
            <div class="col-6 col-lg-4 mb-40 charge-account-radio">
                <input type="radio" name="payment_option" id="alllearn" value="credit" @click="showForm=true, showPaymentMethod=false, creditCardForm=false, invoiceForm=false">
                <label for="alllearn" class="rounded-sm p-20 p-lg-45 d-flex flex-column align-items-center justify-content-center">
                    <img src="/assets/default/img/activity/pay.svg" width="120" height="60" alt="">

                    <p class="mt-30 mt-lg-50 font-weight-500 text-dark-blue">
                        Pagar com
                        <span class="font-weight-bold">Saldo All Learn</span>
                    </p>

                    <span class="mt-5">{{ addCurrencyToPrice($userCharge) }}</span>
                </label>
            </div>
        </div>


        @if ($errors->any())
            <div class="errorMessage mb-2">
                @foreach ($errors->all() as $error)
                <ul>
                    <li class="divErrorMessage m-1 col-4" style="font-size: 14px">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif



        <div class="col-12" x-show="showForm">
            {{-- Dados do comprador --}}
            <h3>Dados do comprador</h3>
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-8">
                        <label class="input-label">Nome</label>
                        <input  id="full_name" type="text" name="full_name" class="form-control @error('full_name')  is-invalid @enderror" placeholder="" value="{{ (!empty($user)) ? $user->full_name : old('full_name') }}"  />
                        @error('full_name')
                        <div class="invalid-feedback d-flex">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-4">
                        <label class="input-label" for="form-checkout__identificationType">Tipo de documento</label>

                        <select name="identificationType" id="form-checkout__identificationType" class="form-control"></select>

                        @error('identificationType')
                        <div class="invalid-feedback d-flex">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-lg-4">
                        <label class="input-label" for="form-checkout__identificationNumber">Número do documento</label>
                        <input type="text" name="identificationNumber" id="form-checkout__identificationNumber" class="form-control"/>
                        @error('identificationNumber')
                        <div class="invalid-feedback d-flex">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>


            <div class="form-group">
                <div class="row">
                    <div class="col-lg-8">
                        <label class="input-label" for="email">E-mail</label>
                        <input type="email" class="form-control @error('cardholderEmail') value="{{ (!empty($user)) ? $user->email : old('cardholderEmail') }}"  is-invalid @enderror" name="cardholderEmail" id="form-checkout__cardholderEmail"/>
                        @error('cardholderEmail')
                        <div class="invalid-feedback d-flex">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-2">
                        <label class="input-label">DDD</label>
                        <input  id="ddd" class="form-control @error('code_zone')  is-invalid @enderror"" type="text" name="code_zone" value="{{ (!empty($user)) ? $user->code_zone : old('code_zone') }}">
                        @error('code_zone')
                        <div class="invalid-feedback d-flex">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <label class="input-label">Celular</label>
                        <input  id="phone" type="tel" name="phone_number" class="form-control @error('phone_number')  is-invalid @enderror" value="{{ (!empty($user)) ? $user->mobile : old('mobile') }}"  />
                        @error('phone_number')
                        <div class="invalid-feedback d-flex">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-2">
                        <label class="input-label">CEP</label>
                        <input  id="zip_code" type="text" name="zip_code" class="form-control @error('zip_code')  is-invalid @enderror" value="{{ (!empty($user)) ? $user->zip_code : old('zip_code') }}" />
                        @error('zip_code')
                        <div class="invalid-feedback d-flex">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-lg-4">
                        <label class="input-label">Nome da rua</label>
                        <input  id="street_name" type="text" name="street_name" class="form-control @error('street_name')  is-invalid @enderror" value="{{ (!empty($user)) ? $user->street_name : old('street_name') }}" />
                        @error('street_name')
                        <div class="invalid-feedback d-flex">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-lg-2">
                        <label class="input-label">Número</label>
                        <input  id="street_number" type="text" name="street_number" class="form-control @error('street_number')  is-invalid @enderror" value="{{ (!empty($user)) ? $user->street_number : old('street_number') }}" />
                        @error('street_number')
                        <div class="invalid-feedback d-flex">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-2">
                        <label class="input-label">Complemento</label>
                        <input  id="complement" type="text" name="complement" class="form-control @error('neigborhood')  is-invalid @enderror" value="{{ (!empty($user)) ? $user->complement : old('complement') }}" />
                        @error('complement')
                        <div class="invalid-feedback d-flex">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-lg-2">
                        <label class="input-label">Bairro</label>
                        <input  id="neigborhood" type="text" name="neigborhood" class="form-control @error('neigborhood')  is-invalid @enderror" value="{{ (!empty($user)) ? $user->neigborhood : old('neigborhood') }}" />
                        @error('neigborhood')
                        <div class="invalid-feedback d-flex">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-lg-2">
                        <label class="input-label">Cidade</label>
                        <input  id="city" type="text" name="city" class="form-control @error('city')  is-invalid @enderror" value="{{ (!empty($user)) ? $user->city : old('city') }}" />
                        @error('city')
                        <div class="invalid-feedback d-flex">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-lg-2">
                        <label class="input-label">Estado</label>
                        <select  class="form-control @error('federal_unit')  is-invalid @enderror"" id="federal_unit" name="federal_unit"  >
                            <option value="" selected disabled hidden>Selecione</option>
                            <option value="AC">Acre</option>
                            <option value="AL">Alagoas</option>
                            <option value="AP">Amapá</option>
                            <option value="AM">Amazonas</option>
                            <option value="BA">Bahia</option>
                            <option value="CE">Ceará</option>
                            <option value="DF">Distrito Federal</option>
                            <option value="ES">Espírito Santo</option>
                            <option value="GO">Goiás</option>
                            <option value="MA">Maranhão</option>
                            <option value="MT">Mato Grosso</option>
                            <option value="MS">Mato Grosso do Sul</option>
                            <option value="MG">Minas Gerais</option>
                            <option value="PA">Pará</option>
                            <option value="PB">Paraíba</option>
                            <option value="PR">Paraná</option>
                            <option value="PE">Pernambuco</option>
                            <option value="PI">Piauí</option>
                            <option value="RJ">Rio de Janeiro</option>
                            <option value="RN">Rio Grande do Norte</option>
                            <option value="RS">Rio Grande do Sul</option>
                            <option value="RO">Rondônia</option>
                            <option value="RR">Roraima</option>
                            <option value="SC">Santa Catarina</option>
                            <option value="SP">São Paulo</option>
                            <option value="SE">Sergipe</option>
                            <option value="TO">Tocantins</option>
                            <option value="EX">Estrangeiro</option>
                        </select>
                        @error('federal_unit')
                        <div class="invalid-feedback d-flex">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Dados do pagamento --}}
            <div class="form-group pt-3" x-show="showPaymentMethod">
                <div class="mt-2 d-flex">
                    <div class="custom-control custom-radio col-lg-3">
                        <input id="boleto" class="custom-control-input" type="radio" name="payment_type" value="boleto" @click="creditCardForm = false, invoiceForm=true">
                        <label for="boleto" class="custom-control-label">Boleto</label>
                    </div>
                    <div class="custom-control custom-radio col-lg-3">
                        <input id="pix" class="custom-control-input" type="radio" name="payment_type" value="pix" @click="creditCardForm = false, invoiceForm=false">
                        <label for="pix" class="custom-control-label">Pix</label>
                    </div>
                    <div class="custom-control custom-radio col-lg-3">
                        <input id="crédito" class="custom-control-input" type="radio" name="payment_type" value="cartao" @click="creditCardForm = true, invoiceForm=false">
                        <label for="crédito" class="custom-control-label">Cartão de Crédito</label>
                    </div>
                </div>
            </div>
            {{-- Pagamento com cartão de crédito --}}
            <div class="pt-3" x-show="creditCardForm">
                <h3 class="mb-2 mt-3">Detalhes do pagamento</h3>
                <div class="form-group pt-3">
                    <div class="row mb-2">
                        <div class="col-lg-3">
                            <label class="input-label" for="cardholderName">Titular do cartão</label>
                            <input class="form-control" type="text" name="cardholderName" id="form-checkout__cardholderName"/>
                        </div>
                        <div class="col-lg-3">
                            <label class="input-label" class="input-label" for="cardNumber">Número do cartão</label>
                            <div class="d-flex align-items-center">
                                <input class="form-control" type="text" name="cardNumber" id="form-checkout__cardNumber" />
                                <div class="brand mx-1"></div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <label class="input-label" for="securityCode">Data de vencimento</label>
                            <input class="form-control" type="text" name="expirationDate" id="form-checkout__expirationDate" />
                        </div>
                    </div>
                    <div class="row">
                        <div id="issuerInput" class="col-lg-2">
                            <label class="input-label" for="issuer">Código de segurança</label>
                            <input class="form-control" type="text" name="securityCode" id="form-checkout__securityCode" />
                        </div>

                    </div>

                    <select id="form-checkout__installments" name="installments" x-show='showInstallments'></select>


                    <select name="issuer" id="form-checkout__issuer" x-show='false'></select>




                </div>
            </div>

            {{-- Pagamento com boleto --}}
            <div class="pt-3" x-show="invoiceForm">
                <h3 class="mb-2 mt-3">Quantidade de parcelas</h3>
                <div>
                    <div class="row mb-2">

                        <div class="col-lg-3">
                            @php

                            @endphp
                            <select name="invoiceParcelNumber" class="form-control">
                                <option disabled selected>Selecione ...</option>
                                @foreach ($invoiceInstallment as $k=> $parcel )
                                <option value="{{$parcel}}">{{$parcel}} {{$parcel > 1 ? 'parcelas' : 'parcela'}} de  R$ {{handlePriceFormat(($total/$parcel), 2, ',', '.')}} - (R$ {{ handlePriceFormat($total, 2, ',', '.') }})</option>
                                @endforeach


                            </select>

                            <input type="hidden" name="total" value="{{$total}}" />
                        </div>

                    </div>



                </div>
            </div>
        </div>
        <div class=" d-flex align-items-center justify-content-between mt-45">
            <span class="font-16 font-weight-500 text-gray">{{ trans('financial.total_amount') }} {{ addCurrencyToPrice($total) }}</span>
            <button type="submit" id="paymentSubmit" class="btn btn-sm btn-primary">Finalizar pagamento</button>
        </div>

    </form>

</section>

<script>
    function payment() {
        return {
            showForm: false,
            creditCardForm: false,
            invoiceForm: false,
            showPaymentMethod: true,
            showInstallments: false,
            mpOptions() {
                const mp = new MercadoPago('{{ env('MERCADO_PAGO_PUBLIC_KEY') }}', {
                    locale: 'pt-BR'
                });

                const cardForm = mp.cardForm({
                    amount: '{{$total}}',
                    autoMount: true,
                    processingMode: 'aggregator',
                    form: {
                        id: 'form-checkout',
                        cardholderName: {
                            id: 'form-checkout__cardholderName',
                            placeholder: 'Nome do titular como está no cartão',
                        },
                        cardholderEmail: {
                            id: 'form-checkout__cardholderEmail',
                            placeholder: 'E-mail',
                        },
                        cardNumber: {
                            id: 'form-checkout__cardNumber',
                            placeholder: 'Número do cartão',
                        },
                        expirationDate: {
                            id: 'form-checkout__expirationDate',
                            placeholder: 'MM/YY'
                        },
                        securityCode: {
                            id: 'form-checkout__securityCode',
                            placeholder: 'CVV',
                        },
                        installments: {
                            id: 'form-checkout__installments',
                            placeholder: 'Parcelas'
                        },
                        identificationType: {
                            id: 'form-checkout__identificationType',
                            placeholder: 'Tipo de documento'
                        },
                        identificationNumber: {
                            id: 'form-checkout__identificationNumber',
                            placeholder: 'Número do documento'
                        },
                        issuer: {
                            id: 'form-checkout__issuer',
                            placeholder: 'Banco'
                        }
                    },
                    callbacks: {
                        onFormMounted: error => {
                            if (error) return console.warn('Form Mounted handling error: ', error)
                           // console.log('Form mounted')
                        },
                        onFormUnmounted: error => {
                            if (error) return console.warn('Form Unmounted handling error: ', error)
                          //  console.log('Form unmounted')
                        },
                        onIdentificationTypesReceived: (error, identificationTypes) => {
                            if (error) return console.warn('identificationTypes handling error: ', error)
                          //  console.log('Identification types available: ', identificationTypes)
                        },
                        onPaymentMethodsReceived: (error, paymentMethods) => {
                            if (error) return console.warn('paymentMethods handling error: ', error)
                           console.log('Payment Methods available: ', paymentMethods)
                           document.querySelector('.brand').innerHTML = "<img src='" + paymentMethods[0].thumbnail + "' alt='bandeira do cartão'>";
                        },
                        onIssuersReceived: (error, issuers) => {
                            if (error) return console.warn('issuers handling error: ', error)
                           // console.log('Issuers available: ', issuers)
                        },
                        onInstallmentsReceived: (error, installments) => {
                            if (error) return console.warn('installments handling error: ', error)

                            const installmentOptions = installments.payer_costs;
                            document.getElementById('form-checkout__installments').options.length = 0;

                            let maxInstallments = {{$creditCardInstallment}};
                            for (let i = 0; i < maxInstallments; i++) {
                                let opt = document.createElement('option');
                                opt.text = installmentOptions[i].recommended_message;
                                opt.value = installmentOptions[i].installments;
                                document.getElementById('form-checkout__installments').appendChild(opt);
                            }

                            this.showInstallments = true;


                            //console.log('Installments available: ', installments.payer_costs)
                        },
                        onCardTokenReceived: (error, token) => {
                            if (error) {
                                $.toast({
                                        heading: 'Ops, tivemos um problema',
                                        text: 'Verifique os dados do cartão',
                                        position: 'top-right',
                                        icon: 'error'
                                    });
                                //console.log('Token available: ', token)
                                return ;
                            }

                        },
                        onSubmit: (event) => {
                           event.preventDefault();
                            const cardData = cardForm.getCardFormData();


                           //console.log('CardForm data available: ', cardData)
                            this.submitionCreditCardForm();
                        },
                        onFetching:(resource) => {
                            /* console.log('Fetching resource: ', resource)

                            // Animate progress bar
                            const progressBar = document.querySelector('.progress-bar')
                            progressBar.removeAttribute('value')

                            return () => {
                                progressBar.setAttribute('value', '0')
                            }
                            */
                        },
                        onError: (error, event) => {
                            console.log(event, error);
                        },
                        onValidityChange: (error, field) => {
                            if(error){
                                if(field == 'cardholderName'){
                                    $.toast({
                                        heading: 'Ops, tivemos um problema',
                                        text: 'Verifique o nome do titular do cartão',
                                        position: 'top-right',
                                        icon: 'error'
                                    });
                                }

                                if(field == 'cardNumber'){
                                    $.toast({
                                        heading: 'Ops, tivemos um problema',
                                        text: 'Verifique o número do cartão',
                                        position: 'top-right',
                                        icon: 'error'
                                    });
                                }


                            }

                            if (error) return error.forEach(
                                e => console.log(`${field}: ${e.message}`)
                                );
                            console.log(`${field} is valid`);
                        },
                        onReady: () => {
                          //  console.log("CardForm ready");
                        }
                    }
                })

            },

            submitionCreditCardForm(){
                let form = document.getElementById('form-checkout');
                doSubmit = true;
                form.submit();
            },

        };

    }
</script>

@endsection

@push('scripts_bottom')

<script src="/assets/default/js/busca-cep.js"></script>
<script src="https://sdk.mercadopago.com/js/v2"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<!-- <script src="/assets/default/js/parts/payment.min.js"></script> -->
@endpush
