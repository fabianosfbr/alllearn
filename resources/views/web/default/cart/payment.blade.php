@extends(getTemplate().'.layouts.app')

@push('styles_top')

@endpush

@section('content')
    <section class="cart-banner position-relative text-center">
        <h1 class="font-30 text-white font-weight-bold">{{ trans('cart.checkout') }}</h1>
        <span class="payment-hint font-20 text-white d-block">{{$currency . $total . ' ' .  trans('cart.for_items',['count' => $count]) }}</span>
    </section>

    <section class="container mt-45">
        <h2 class="section-title">{{ trans('financial.select_a_payment_gateway') }}</h2>

        <form action="/payments/payment-request" method="post" class=" mt-25">
            {{ csrf_field() }}
            <input type="hidden" name="order_id" value="{{ $order->id }}">

            <div class="row">
                 {{-- Botão para pagar com boleto, pix ou cartão --}}
                <div class="col-6 col-lg-4 mb-40 charge-account-radio">
                    <input type="radio" name="gateway" id="gateway" value="credit">
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
                    <input type="radio" name="alllearn" id="alllearn" value="credit">
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

            {{-- Mostrar formulário somente se o usuario escolhar a opção de pagamento boleto, pix ou cartão de crédito --}}
            <div class="col-12 d-none" id="personalInfo">
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-4">
                            <label class="input-label">Nome</label>
                            <input onchange="toggleButton()" id="first_name" type="text" name="first_name" class="form-control @error('first_name')  is-invalid @enderror" placeholder=""/>
                            @error('first_name')
                            <div class="invalid-feedback d-flex">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-lg-4">
                            <label class="input-label">Sobrenome</label>
                            <input onchange="toggleButton()" id="last_name" type="text" name="last_name" class="form-control @error('last_name')  is-invalid @enderror" placeholder=""/>
                            @error('last_name')
                            <div class="invalid-feedback d-flex">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-1">
                            <label class="input-label">DDD</label>
                            <input onchange="toggleButton()" id="ddd" class="form-control" type="text" name="code_zone">   
                        </div>
                        <div class="col-lg-3">
                            <label class="input-label">Celular</label>
                            <input onchange="toggleButton()" id="phone" type="tel" name="phone_number" class="form-control @error('phone_number')  is-invalid @enderror" placeholder=""/>
                            @error('phone_number')
                                <div class="invalid-feedback d-flex">
                                    {{ $message }}   
                                </div>
                                @enderror  
                        </div>
                        <div class="col-lg-4">
                            <label class="input-label">CPF/CNPJ</label>
                            <input onchange="toggleButton()" id="cpf_cnpj" type="text" name="cpf_cnpj" class="form-control @error('cpf_cnpj')  is-invalid @enderror" placeholder=""/>
                            @error('cpf')
                            <div class="invalid-feedback d-flex">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>    
                <br>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-2">
                            <label class="input-label">CEP</label>
                            <input onchange="toggleButton()" id="cep" type="text" name="cep" class="form-control @error('cep')  is-invalid @enderror" placeholder=""/>
                            @error('cpf')
                            <div class="invalid-feedback d-flex">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-lg-4">
                            <label class="input-label">Nome da rua</label>
                            <input onchange="toggleButton()" id="street" type="text" name="street" class="form-control @error('street')  is-invalid @enderror" placeholder=""/>
                            @error('cpf')
                            <div class="invalid-feedback d-flex">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-lg-2">
                            <label class="input-label">Número</label>
                            <input onchange="toggleButton()" id="numStreet" type="text" name="street_number" class="form-control @error('street_number')  is-invalid @enderror" placeholder=""/>
                            @error('cpf')
                            <div class="invalid-feedback d-flex">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="input-label">Bairro</label>
                            <input onchange="toggleButton()" id="district" type="text" name="district" class="form-control @error('district')  is-invalid @enderror" placeholder=""/>
                            @error('cpf')
                            <div class="invalid-feedback d-flex">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-lg-2">
                            <label class="input-label">Cidade</label>
                            <input onchange="toggleButton()" id="city" type="text" name="city" class="form-control @error('city')  is-invalid @enderror" placeholder=""/>
                            @error('cpf')
                            <div class="invalid-feedback d-flex">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-lg-3">
                            <label class="input-label">Estado</label>
                            <select onchange="toggleButton()" class="form-control" id="state" name="estado">
                                <option value="">Selecione</option>
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
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 d-none" id="paymentOptions">
                <p class="section-title">Opções de pagamento</p>
                <div class="row">
                    <div class="col-lg-2 mt-25">
                        <div class="d-flex align-items-center js-ajax-accessibility">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" name="boleto" id="choseBoleto">
                                <label class="custom-control-label font-14 cursor-pointer" for="choseBoleto">Boleto</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 mt-25">
                        <div class="d-flex align-items-center js-ajax-accessibility">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" name="pix" id="chosePix">
                                <label class="custom-control-label font-14 cursor-pointer" for="chosePix">Pix</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 mt-25">
                        <div class="d-flex align-items-center js-ajax-accessibility">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" name="credCard" id="choseCredCard">
                                <label class="custom-control-label font-14 cursor-pointer" for="choseCredCard">Cartão de Crédito</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="display: none" class="forn-group mt-25" id="infoCredCard">
                <div class="row">
                    <div class="col-lg-3">
                        <label class="input-label">Nome do cartão de crédito</label>
                        <input id="nameCartao" type="text" name="nameCartao" class="form-control @error('nameCartao')  is-invalid @enderror" placeholder=""/>
                        @error('cpf')
                        <div class="invalid-feedback d-flex">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-lg-3">
                        <label class="input-label">Número do cartão</label>
                        <input id="numCredCard" type="text" name="numCredCard" class="form-control @error('numCredCard')  is-invalid @enderror" placeholder=""/>
                        @error('cpf')
                        <div class="invalid-feedback d-flex">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group mt-15">
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="input-label">Data de vencimento</label>
                            <input id="nameCartao" type="text" name="nameCartao" class="form-control @error('nameCartao')  is-invalid @enderror" placeholder=""/>
                            @error('cpf')
                            <div class="invalid-feedback d-flex">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-lg-1">
                            <label class="input-label">CVV</label>
                            <input id="numCredCard" type="text" name="numCredCard" class="form-control @error('numCredCard')  is-invalid @enderror" placeholder=""/>
                            @error('cpf')
                            <div class="invalid-feedback d-flex">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>



            <div class="d-flex align-items-center justify-content-between mt-45">
                <span class="font-16 font-weight-500 text-gray">{{ trans('financial.total_amount') }} {{ addCurrencyToPrice($total) }}</span>
                <button type="button" id="paymentSubmit" class="btn btn-sm btn-primary" disabled>Finalizar pagamento</button>
            </div>
        </form>

    </section>

@endsection

@push('scripts_bottom')
    <script src="/assets/default/js/payment.js"></script>
    <script src="/assets/default/js/parts/payment.min.js"></script>
@endpush
