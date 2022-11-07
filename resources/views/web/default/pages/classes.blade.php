@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
<link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
<link rel="stylesheet" href="/assets/default/css/custom.css">
@endpush



@section('content')
<section class="site-top-banner search-top-banner opacity-04 position-relative">
    <img src="{{ getPageBackgroundSettings('categories') }}" class="img-cover" alt="" />

    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-12 col-md-9 col-lg-7">
                <div class="top-search-categories-form">
                    <h1 class="text-white font-30 mb-15">{{ $pageTitle }}</h1>
                    <span class="course-count-badge py-5 px-10 text-white rounded">{{ $coursesCount }} {{ trans('product.courses') }}</span>

                    <div class="search-input bg-white p-10 flex-grow-1">
                        <form action="/search" method="get">
                            <div class="form-group d-flex align-items-center m-0">
                                <input type="text" name="search" class="form-control border-0" placeholder="{{ trans('home.slider_search_placeholder') }}" />
                                <button type="submit" class="btn btn-primary rounded-pill">{{ trans('home.find') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container mt-30">

    <section class="mt-lg-50 pt-lg-20 mt-md-40 pt-md-40">
        <form action="/classes" method="get" id="filtersForm">

            @include('web.default.pages.includes.top_filters')

            <div class="row mt-20">
                <div class="col-12 col-lg-8">

                    @if(empty(request()->get('card')) or request()->get('card') == 'grid')
                    <div class="row">
                        @foreach($webinars as $webinar)
                        <div class="col-12 col-lg-6 mt-20">
                            @include('web.default.includes.webinar.grid-card',['webinar' => $webinar])
                        </div>
                        @endforeach
                    </div>

                    @elseif(!empty(request()->get('card')) and request()->get('card') == 'list')

                    @foreach($webinars as $webinar)
                    @include('web.default.includes.webinar.list-card',['webinar' => $webinar])
                    @endforeach
                    @endif

                </div>


                <div class="col-12 col-lg-4">
                    <div class="mt-20 p-20 rounded-sm shadow-lg border border-gray300 filters-container">
                        <div class="mt-10 pt-10 d-flex justify-content-between">
                            <h3 class=" font-20 font-weight-bold text-dark-blue" aria-expanded="false" aria-controls="collapseFilters">
                                Expandir Filtros
                            </h3>
                            <i class="openDrop"><ion-icon name="chevron-down-outline" data-toggle="collapse" href="#collapseFilters"></ion-icon></i>
                        </div>
                        <!--Dropdown Nível, Formato, tipo, forma de entrega e idioma -->
                        @if(!empty($category) and !empty($category->filters))
                        @foreach($category->filters as $filter)
                        <div class="mt-25 pt-25 border-top border-gray300 d-flex justify-content-between">
                            <h3 class="category-filter-title font-20 font-weight-bold text-dark-blue" aria-expanded="false" aria-controls="collapseFilters">
                                {{ $filter->title }}
                            </h3>
                        </div>
                        <div class="collapse" id="collapseFilters">
                            @if(!empty($filter->options))
                            <div class="pt-10">
                                @foreach($filter->options as $option)
                                <div class="d-flex align-items-center justify-content-between mt-20">
                                    <label class="cursor-pointer" for="filterLanguage{{ $option->id }}">{{ $option->title }}</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="filter_option[]" id="filterLanguage{{ $option->id }}" value="{{ $option->id }}" @if(in_array($option->id, request()->get('filter_option', []))) checked="checked" @endif class="custom-control-input">
                                        <label class="custom-control-label" for="filterLanguage{{ $option->id }}"></label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        @endforeach
                        @endif


                        <!--Drop down filtro Preço-->
                            <div class="mt-25 pt-25 border-top border-gray300 d-flex justify-content-between">
                                <h3 class="category-filter-title font-20 font-weight-bold text-dark-blue" aria-expanded="false" aria-controls="collapseFilters">
                                    Preço
                                </h3>
                            </div>

                            <div class="collapse" id="collapseFilters">
                                    <div class="pt-10">
                                        <div class="d-flex align-items-center justify-content-between mt-20">
                                            <label class="cursor-pointer" for="zero_OneHundred">
                                                De R$ 0,01 a R$ 100,00
                                            </label>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="zero_OneHundred" id="zero_OneHundred" value="" class="custom-control-input">
                                                <label class="custom-control-label" for="zero_OneHundred"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pt-10">
                                        <div class="d-flex align-items-center justify-content-between mt-20">
                                            <label class="cursor-pointer" for="oneHundred_TwoHundred">
                                                De R$ 100,01 a R$ 200,00
                                            </label>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="oneHundred_TwoHundred" id="oneHundred_TwoHundred" value="" class="custom-control-input">
                                                <label class="custom-control-label" for="oneHundred_TwoHundred"></label>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="pt-10">
                                        <div class="d-flex align-items-center justify-content-between mt-20">
                                            <label class="cursor-pointer" for="twoHundred_fiveHundred">
                                                De R$ 200,01 a R$ 500,00
                                            </label>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="twoHundred_fiveHundred" id="twoHundred_fiveHundred" value="" class="custom-control-input">
                                                <label class="custom-control-label" for="twoHundred_fiveHundred"></label>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="pt-10">
                                        <div class="d-flex align-items-center justify-content-between mt-20">
                                            <label class="cursor-pointer" for="fiveHundred_oneThousand">
                                                De R$ 500,00 a R$ 1.000,00
                                            </label>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="fiveHundred_oneThousand" id="fiveHundred_oneThousand" value="" class="custom-control-input">
                                                <label class="custom-control-label" for="fiveHundred_oneThousand"></label>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="pt-10">
                                        <div class="d-flex align-items-center justify-content-between mt-20">
                                            <label class="cursor-pointer" for="oneThousand">
                                                Acima de R$ 1.000,00
                                            </label>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="oneThousand" id="oneThousand" value="" class="custom-control-input">
                                                <label class="custom-control-label" for="oneThousand"></label>
                                            </div>
                                        </div>
                                    </div>           
                            </div>

                            <!--Drop down filtro Classificações-->
                            <div class="mt-25 pt-25 border-top border-gray300 d-flex justify-content-between">
                                <h3 class="category-filter-title font-20 font-weight-bold text-dark-blue" aria-expanded="false" aria-controls="collapseFilters">
                                    Classificações
                                </h3>
                            </div>

                                <div class="collapse" id="collapseFilters">
                                    <div class="pt-10">
                                        <div class="pt-10">
                                            <div class="d-flex align-items-center justify-content-between mt-20">
                                                <label class="cursor-pointer" for="fourStars">
                                                    <ion-icon name="star"></ion-icon>
                                                    <ion-icon name="star"></ion-icon>
                                                    <ion-icon name="star"></ion-icon>
                                                    <ion-icon name="star"></ion-icon>
                                                    <ion-icon name="star-outline"></ion-icon>
                                                    <span>4.0 e acima</span> 
                                                </label>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="fourStars" id="fourStars" value="" class="custom-control-input">
                                                    <label class="custom-control-label" for="fourStars"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pt-10">
                                            <div class="d-flex align-items-center justify-content-between mt-20">
                                                <label class="cursor-pointer" for="threeStars">
                                                    <ion-icon name="star"></ion-icon>
                                                    <ion-icon name="star"></ion-icon>
                                                    <ion-icon name="star"></ion-icon>
                                                    <ion-icon name="star-outline"></ion-icon>
                                                    <ion-icon name="star-outline"></ion-icon>
                                                    <span>3.0 e acima</span>
                                                </label>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="threeStars" id="threeStars" value="" class="custom-control-input">
                                                    <label class="custom-control-label" for="threeStars"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pt-10">
                                            <div class="d-flex align-items-center justify-content-between mt-20">
                                                <label class="cursor-pointer" for="twoStars">
                                                    <ion-icon name="star"></ion-icon>
                                                    <ion-icon name="star"></ion-icon>
                                                    <ion-icon name="star-outline"></ion-icon>
                                                    <ion-icon name="star-outline"></ion-icon>
                                                    <ion-icon name="star-outline"></ion-icon>
                                                    <span>2.0 e acima</span>
                                                </label>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="twoStars" id="twoStars" value="" class="custom-control-input">
                                                    <label class="custom-control-label" for="twoStars"></label>
                                                </div>
                                            </div>
                                        </div>  
                                    </div>           
                                </div>

                                <!--Drop down filtro Outras opções-->
                            <div class="mt-25 pt-25 border-top border-gray300 d-flex justify-content-between">
                                <h3 class="category-filter-title font-20 font-weight-bold text-dark-blue" aria-expanded="false" aria-controls="collapseFilters">
                                    Outras opções
                                </h3>
                            </div>
                            <div class="collapse" id="collapseFilters">
                                <div class="pt-10">
                                    <div class="pt-10">
                                        @foreach(['bundle'] as $typeOption)
                                        <div class="d-flex align-items-center justify-content-between mt-20">
                                            <label class="cursor-pointer" for="filterLanguage{{ $typeOption }}">
                                                @if($typeOption == 'bundle')
                                                {{ trans('update.bundle') }}
                                                @else
                                                {{ trans('webinars.'.$typeOption) }}
                                                @endif
                                            </label>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="type[]" id="filterLanguage{{ $typeOption }}" value="{{ $typeOption }}" @if(in_array($typeOption, request()->get('type', []))) checked="checked" @endif class="custom-control-input">
                                                <label class="custom-control-label" for="filterLanguage{{ $typeOption }}"></label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
    
                                    @foreach(['subscribe','certificate_included','with_quiz','featured'] as $moreOption)
                                    <div class="d-flex align-items-center justify-content-between mt-20">
                                        <label class="cursor-pointer" for="filterLanguage{{ $moreOption }}">{{ trans('webinars.show_only_'.$moreOption) }}</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="moreOptions[]" id="filterLanguage{{ $moreOption }}" value="{{ $moreOption }}" @if(in_array($moreOption, request()->get('moreOptions', []))) checked="checked" @endif class="custom-control-input">
                                            <label class="custom-control-label" for="filterLanguage{{ $moreOption }}"></label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary btn-block mt-30">{{ trans('site.filter_items') }}</button>
                            </div>    
                    </div>
                </div>
            </div>

        </form>
        <div class="mt-50 pt-30">
            {{ $webinars->appends(request()->input())->links('vendor.pagination.panel') }}
        </div>
    </section>
</div>

@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/select2/select2.min.js"></script>
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>

<script src="/assets/default/js/parts/categories.min.js"></script>
@endpush