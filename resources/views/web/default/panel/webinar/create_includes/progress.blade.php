@php
    $progressSteps = [
        1 => [
            'name' => 'Informações básicas',
            'icon' => 'paper'
        ],

        2 => [
            'name' => 'Informações adicionais',
            'icon' => 'paper_plus'
        ],

        3 => [
            'name' => 'Preços, formas de pagamento e promoções',
            'icon' => 'wallet'
        ],

        4 => [
            'name' => 'Conteúdos (principalmente, mas não só para cursos livres)',
            'icon' => 'folder'
        ],

        5 => [
            'name' => 'FAQ',
            'icon' => 'tick_square'
        ],

        6 => [
            'name' => 'Mensagem ao revisor',
            'icon' => 'shield_done'
        ],
    ];

    $currentStep = empty($currentStep) ? 1 : $currentStep;
@endphp


<div class="webinar-progress d-block d-lg-flex align-items-center p-15 panel-shadow bg-white rounded-sm">

    @foreach($progressSteps as $key => $step)
        <div class="progress-item d-flex align-items-center">
            <button type="button" data-step="{{ $key }}" class="js-get-next-step p-0 border-0 progress-icon p-10 d-flex align-items-center justify-content-center rounded-circle {{ $key == $currentStep ? 'active' : '' }}" data-toggle="tooltip" data-placement="top" title="{{ trans($step['name']) }}">
                <img src="/assets/default/img/icons/{{ $step['icon'] }}.svg" class="img-cover" alt="">
            </button>

            <div class="ml-10 {{ $key == $currentStep ? '' : 'd-lg-none' }}">
                <span class="font-14 text-gray">{{ trans('webinars.progress_step', ['step' => $key,'count' => 6]) }}</span>
                <h4 class="font-16 text-secondary font-weight-bold">{{ trans($step['name']) }}</h4>
            </div>
        </div>
    @endforeach
</div>
