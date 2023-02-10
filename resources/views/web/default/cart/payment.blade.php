@extends(getTemplate().'.layouts.app')


@section('content')
<section class="cart-banner position-relative text-center">
    <h1 class="font-30 text-white font-weight-bold">{{ trans('cart.checkout') }}</h1>
    <span class="payment-hint font-20 text-white d-block">{{$currency . $total . ' ' .  trans('cart.for_items',['count' => $count]) }}</span>
</section>

<section x-data="init()" class="container mt-45">
    <h2 class="section-title">{{ trans('financial.select_a_payment_gateway') }}</h2>

    <form action="/payments/payment-request" method="post" id="paymentForm" class=" mt-25">
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
                        <label class="input-label" for="docType">Tipo de documento</label>
                        <select class="form-control" id="docType" name="docType" data-checkout="docType" type="text" value="{{ (!empty($user)) ? $user->docType : old('docType') }}"></select>
                        @error('docType')
                        <div class="invalid-feedback d-flex">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-lg-4">
                        <label class="input-label" for="docNumber">Número do documento</label>
                        <input class="form-control @error('docNumber')  is-invalid @enderror"" id="docNumber" name="docNumber" data-checkout="docNumber" type="text" value="{{ (!empty($user)) ? $user->docNumber : old('docNumber') }}" />
                        @error('docNumber')
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
                        <input class="form-control @error('email')  is-invalid @enderror" id="email" name="email" type="text" value="{{ (!empty($user)) ? $user->email : old('email') }}"  />
                        @error('email')
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
                <div>
                    <div class="row mb-2">
                        <div class="col-lg-3">
                            <label class="input-label" for="cardholderName">Titular do cartão</label>
                            <input class="form-control" id="cardholderName" data-checkout="cardholderName" type="text">
                        </div>
                        <div class="col-lg-3">
                            <label class="input-label" class="input-label" for="cardNumber">Número do cartão</label>
                            <div class="d-flex align-items-center">
                                <input class="form-control" type="text" id="cardNumber" data-checkout="cardNumber" onselectstart="return false" onpaste="return false" oncopy="return false" oncut="return false" ondrag="return false" ondrop="return false" autocomplete=off>
                                <div class="brand mx-1"></div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <label class="input-label" for="">Data de vencimento</label>
                            <div class="d-flex align-items-center">
                                <input class="form-control" type="text" placeholder="MM" id="cardExpirationMonth" data-checkout="cardExpirationMonth" onselectstart="return false" onpaste="return false" oncopy="return false" oncut="return false" ondrag="return false" ondrop="return false" autocomplete=off>
                                <span class="date-separator p-1">/</span>
                                <input class="form-control" type="text" placeholder="YY" id="cardExpirationYear" data-checkout="cardExpirationYear" onselectstart="return false" onpaste="return false" oncopy="return false" oncut="return false" ondrag="return false" ondrop="return false" autocomplete=off>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2">
                            <label class="input-label" for="securityCode">Código de segurança</label>
                            <input class="form-control" id="securityCode" data-checkout="securityCode" type="text" onselectstart="return false" onpaste="return false" oncopy="return false" oncut="return false" ondrag="return false" ondrop="return false" autocomplete=off>
                        </div>
                        <div id="issuerInput" class="col-lg-2">
                            <label class="input-label" for="issuer">Banco emissor</label>
                            <select class="form-control" id="issuer" name="issuer" data-checkout="issuer"></select>
                        </div>
                        <div id="installments_number" class="col-lg-4 d-none">
                            <label class="input-label" for="installments">Parcelas</label>
                            <select class="form-control" type="text" id="installments" name="installments"></select>
                        </div>
                    </div>
                    <div>
                        <input type="hidden" name="creditCardForm" id="creditCardForm" x-model="creditCardForm" />
                        <input type="hidden" name="transactionAmount" id="transactionAmount" value="{{$total}}" />
                        <input type="hidden" name="paymentMethodId" id="paymentMethodId" />
                        <input type="hidden" name="description" id="description" />
                        <input type="hidden" name="creditCardInstallment" id="creditCardInstallment" value="{{$creditCardInstallment}}" />
                        <br>
                    </div>
                </div>
            </div>

            {{-- Pagamento com boleto --}}
            <div class="pt-3" x-show="invoiceForm">
                <h3 class="mb-2 mt-3">Quantidade de parcelas</h3>
                <div>
                    <div class="row mb-2">

                        <div class="col-lg-3">

                            <select name="invoiceParcelNumber" class="form-control">
                                <option disabled selected>Selecione ...</option>
                                @foreach ($invoiceInstallment as $parcel )
                                <option value="{{$parcel}}">{{$parcel}} parcelas</option>
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
    function init() {
        return {
            showForm: false,
            creditCardForm: false,
            invoiceForm: false,
            showPaymentMethod: true,
        };

    }
</script>

@endsection

@push('scripts_bottom')
<script src="/assets/default/js/payment.js"></script>
<script src="/assets/default/js/mercado-pago.js"></script>
<script src="/assets/default/js/busca-cep.js"></script>
<script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<!-- <script src="/assets/default/js/parts/payment.min.js"></script> -->
@endpush
