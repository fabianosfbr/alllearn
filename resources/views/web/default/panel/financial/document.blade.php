@extends(getTemplate() .'.panel.layouts.panel_layout')



@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
@endpush

@section('content')

    <section>
        <h2 class="section-title">Transferir valores</h2>

        <div class="activities-container mt-25 p-20 p-lg-35">
            <form action="/admin/financial/documents/store" method="post">
                {{ csrf_field() }}


                <div class="form-group">
                    <label class="input-label d-block">{{ trans('admin/main.user') }}</label>
                    <select class="livesearch form-control" name="livesearch"></select>
                    </select>

                    @error('user_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="control-label">Valor (R$)</label>
                    <input type="text" name="amount" class="form-control @error('amount') is-invalid @enderror" >

                    @error('amount')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <input type="hidden" name="type" value="addiction" >



                <div class="form-group">
                    <label class="control-label">{{ trans('admin/main.description') }}</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="6"></textarea>
                    @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Enviar valor</button>
            </form>
        </div>
    </section>

    <section class="mt-35">

    </section>

    <section class="mt-35">
        <h2 class="section-title">Histórico de transferências</h2>


    </section>

{{--     <div class="my-30">
        {{ $users->appends(request()->input())->links('vendor.pagination.panel') }}
    </div> --}}
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/moment.min.js"></script>
    <script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script type="text/javascript">
        $('.livesearch').select2({
            placeholder: 'Selecione um colaborador',
            ajax: {
                url: '/panel/financial/document/search',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
    </script>
@endpush
