@extends(getTemplate().'.layouts.app')


@section('content')



@if(!empty($order) && $order->status === \App\Models\Order::$paid)
<div class="no-result default-no-result my-50 d-flex align-items-center justify-content-center flex-column">
    <div class="no-result-logo">
        <img src="/assets/default/img/no-results/search.png" alt="">
    </div>
    <div class="d-flex align-items-center flex-column mt-30 text-center">
        <h2>{{ trans('cart.success_pay_title') }}</h2>
        <p class="mt-5 text-center">{!! trans('cart.success_pay_msg') !!}</p>
        <a href="/panel" class="btn btn-sm btn-primary mt-20">{{ trans('public.my_panel') }}</a>
    </div>
</div>
@endif

<!-- Pendente boleto -->
@if(!empty($order) && $order->status === \App\Models\Order::$pending && $order->payment_method == 'invoice' )
<div class="no-result default-no-result my-50 d-flex align-items-center justify-content-center flex-column">
    <div>
        <img src="/assets/default/img/cart/boletoregistrado.png" width="250px" alt="">
    </div>
    @php
    $boleto = json_decode($invoice->code_bar);
    @endphp
    <div class="d-flex align-items-center flex-column mt-30 text-center">
        <h2>{{ trans('cart.success_pay_title') }}</h2>
        <p class="mt-5 text-center">Linha digitável do boleto</p>
        <p class="mt-5 text-center">{{$invoice->identificationField}}</p>
        <a href="{{$invoice->bank_slip_url}}" target="_blank" class="btn btn-sm btn-warning mt-20">Abrir o boleto</a>
        <a href="/panel" class="btn btn-sm btn-primary mt-20">{{ trans('public.my_panel') }}</a>
    </div>
</div>
@endif


<!-- Pendente PIX -->
@if(!empty($order) && $order->status === \App\Models\Order::$pending && $order->payment_method == 'pix' )
<div class="no-result default-no-result my-50 d-flex align-items-center justify-content-center flex-column">
    <div>
        <img src="/assets/default/img/cart/pix.png" width="250px" alt="">
    </div>
    @php
    $pix = json_decode($invoice->code_bar);
    $image = "data:image/png;base64,". $pix->encodedImage;
    @endphp
    <div class="d-flex align-items-center flex-column mt-30 text-center">
        <h2>{{ trans('cart.success_pay_title') }}</h2>


        <p class="mt-5 text-center">Pagar com pix</p>
        <p class="mt-5 text-center"></p>
        <img src="{{$image}}" style="width: 200px;" />
        <a href="{{$invoice->invoice_url}}" target="_blank" class="btn btn-sm btn-warning mt-20">Detalhes do documento</a>
        <a href="/panel" class="btn btn-sm btn-primary mt-20">{{ trans('public.my_panel') }}</a>
    </div>
</div>
@endif

@if(!empty($order) && $order->status === \App\Models\Order::$fail)
<div class="no-result status-failed my-50 d-flex align-items-center justify-content-center flex-column">
    <div class="no-result-logo">
        <img src="/assets/default/img/no-results/failed_pay.png" alt="">
    </div>
    <div class="d-flex align-items-center flex-column mt-30 text-center">
        <h2>{{ trans('cart.failed_pay_title') }}</h2>
        <p class="mt-5 text-center">{!! nl2br(trans('cart.failed_pay_msg')) !!}</p>
        <a href="/panel" class="btn btn-sm btn-primary mt-20">{{ trans('public.my_panel') }}</a>
    </div>
</div>
@endif


@endsection