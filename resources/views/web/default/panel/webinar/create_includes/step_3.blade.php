@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
    <link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>
@endpush

<div class="row">
    <div class="col-12 col-md-6">



        <div class="form-group mt-15">
            <label class="input-label">{{ trans('update.access_days') }} ({{ trans('public.optional') }})</label>
            <input type="number" name="access_days" value="{{ !empty($webinar) ? $webinar->access_days : old('access_days') }}" class="form-control @error('access_days')  is-invalid @enderror"/>
            @error('access_days')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
            <p class="font-12 text-gray mt-10">- Quantidade de dias disponível para o usuário consumir o curso. <span style="font-weight: bold">Para acesso vitalício deixe em branco.</span></p>
            <p class="font-12 text-gray mt-10">- {{ trans('update.access_days_input_hint') }}</p>
        </div>

        <div class="form-group mt-15">
            <label class="input-label">{{ trans('public.price') }}</label>
            <input type="number" name="price" value="{{ !empty($webinar) ? $webinar->price : old('price') }}" class="form-control @error('price')  is-invalid @enderror" placeholder="{{ trans('public.0_for_free') }}"/>
            @error('price')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
            <p class="font-12 text-gray mt-10">- Defina o preço do seu curso.</p>
        </div>

        @if($authUser->isOrganization() and $authUser->id == $webinar->creator_id)
            <div class="form-group mt-15">
                <label class="input-label">{{ trans('update.organization_price') }}</label>
                <input type="number" name="organization_price" value="{{ !empty($webinar) ? $webinar->organization_price : old('organization_price') }}" class="form-control @error('organization_price')  is-invalid @enderror" placeholder=""/>
                @error('organization_price')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                <p class="font-12 text-gray mt-5">- {{ trans('update.organization_price_hint') }}</p>
            </div>
        @endif
    </div>
</div>

<section class="mt-30">
    <div class="">
        <h2 class="section-title after-line">Campanhas promocionais (opcional)</h2>


        <div class="mt-15">
            <p class="font-12 text-gray">- Você pode criar campanhas promocionais por tempo limitado ou um número limitado de compradores com desconto.</p>
            <p class="font-12 text-gray">- Se você não criar campanha, será considerado o valor definido no campo Preço.</p>
        </div>
    </div>

    <button id="webinarAddTicket" data-webinar-id="{{ $webinar->id }}" type="button" class="btn btn-primary btn-sm mt-15">{{ trans('public.add_plan') }}</button>

    <div class="row mt-10">
        <div class="col-12">

            <div class="accordion-content-wrapper mt-15" id="ticketsAccordion" role="tablist" aria-multiselectable="true">
                @if(!empty($webinar->tickets) and count($webinar->tickets))
                    <ul class="draggable-lists" data-order-table="tickets">
                        @foreach($webinar->tickets as $ticketInfo)
                            @include('web.default.panel.webinar.create_includes.accordions.ticket',['webinar' => $webinar,'ticket' => $ticketInfo])
                        @endforeach
                    </ul>
                @else
                    @include(getTemplate() . '.includes.no-result',[
                        'file_name' => 'ticket.png',
                        'title' => trans('public.ticket_no_result'),
                        'hint' => trans('public.ticket_no_result_hint'),
                    ])
                @endif
            </div>
        </div>
    </div>
</section>

<div id="newTicketForm" class="d-none">
    @include('web.default.panel.webinar.create_includes.accordions.ticket',['webinar' => $webinar])
</div>

@push('scripts_bottom')
    <script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>
    <script src="/assets/default/vendors/sortable/jquery-ui.min.js"></script>
@endpush
