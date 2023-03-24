@extends(getTemplate() . '.panel.layouts.panel_layout')


@section('content')

    <section>
        @if ($invoices->count() > 0)
            <h2 class="section-title">Meus Boletos</h2>

            <div class="panel-section-card py-20 px-25 mt-20">
                <div class="row">
                    <div class="col-12 ">
                        <div class="table-responsive">
                            <table class="table text-center custom-table">
                                <thead>
                                    <tr>
                                        <th>Descrição</th>
                                        <th>Data vencimento</th>
                                        <th>Valor</th>
                                        <th>Status</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $invoice)
                                        <tr>
                                            <td class="text-left">
                                                <div class="d-flex flex-column">
                                                    <span class="font-12 font-weight-500">
                                                        {{ $invoice->description }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-left">
                                                <div class="d-flex flex-column">
                                                    <span class="font-12 font-weight-500">
                                                        {{ $invoice->date_end->format('j/m/Y') }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-left">
                                                <div class="d-flex flex-column">
                                                    <span class="font-12 font-weight-500">
                                                        R$ {{ handlePriceFormat($invoice->value) }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-left">
                                                <div class="d-flex flex-column">
                                                    @include(getTemplate() . '.includes.status-invoice', [
                                                        'status' => $invoice->status,
                                                    ])

                                                </div>
                                            </td>
                                            <td class="text-left d-none">
                                                <div class="d-flex flex-column">
                                                    <span id="code-bar" class="font-12 font-weight-500">
                                                        {{  $invoice->code_bar }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-left">
                                                <div class="d-flex flex-column">
                                                    <span class="font-12 d-flex font-weight-500">
                                                            <ion-icon onclick="copyText()" name="copy-outline" data-toggle="tooltip" data-placement="top" title="Copiar código de barras"></ion-icon>
                                                        <a target="_blank" href="{{ $invoice->bank_slip_url }}">
                                                            <ion-icon name="document-text-outline" data-toggle="tooltip" data-placement="top" title="Imprimir boleto"></ion-icon>
                                                        </a>
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>


                            </table>

                        </div>
                    </div>
                </div>
            </div>
        @else
            @include(getTemplate() . '.includes.no-result', [
                'file_name' => 'financial.png',
                'title' => 'Nenhum boleto foi encontrado',
                'hint' => nl2br(trans('financial.financial_summary_no_result_hint')),
            ])
        @endif
    </section>

    <div class="my-30">
        {{ $invoices->appends(request()->input())->links('vendor.pagination.panel') }}
    </div>

@endsection
