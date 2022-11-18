@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
<link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
<link rel="stylesheet" href="/assets/default/vendors/bootstrap-tagsinput/bootstrap-tagsinput.min.css">
@endpush


<div class="form-group mt-15 {{ (!empty($webinarCategoryFilters) and count($webinarCategoryFilters)) ? '' : 'd-none' }}" id="categoriesFiltersContainer">
    <span class="input-label d-block">{{ trans('public.category_filters') }}</span>
    <div>
        <br>
        <p class="font-12 text-gray">- Selecione os filtros de acordo com seu curso.</p><br>
    </div>
    <div id="categoriesFiltersCard" class="row mt-20">

        @if(!empty($webinarCategoryFilters) and count($webinarCategoryFilters))
        @foreach($webinarCategoryFilters as $filter)
        <div class="col-12 col-md-3">
            <div class="webinar-category-filters">
                <strong class="category-filter-title d-block">{{ $filter->title }}</strong>
                <div class="py-10"></div>

                @php
                $webinarFilterOptions = $webinar->filterOptions->pluck('filter_option_id')->toArray();

                if (!empty(old('filters'))) {
                $webinarFilterOptions = array_merge($webinarFilterOptions, old('filters'));
                }
                @endphp

                @foreach($filter->options as $option)
                <div class="form-group mt-10 d-flex align-items-center justify-content-between">
                    <label class="cursor-pointer font-14 text-gray" for="filterOptions{{ $option->id }}">{{ $option->title }}</label>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="filters[]" value="{{ $option->id }}" {{ ((!empty($webinarFilterOptions) && in_array($option->id, $webinarFilterOptions)) ? 'checked' : '') }} class="custom-control-input" id="filterOptions{{ $option->id }}">
                        <label class="custom-control-label" for="filterOptions{{ $option->id }}"></label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
        @endif

    </div>
</div>

<div class="row">
    <div class="col-12 col-md-6 mt-15">

        @if($webinar->isWebinar())
        <div class="form-group mt-15">
            <label class="input-label">
                Capacidade
            </label>
            <div>
                <p class="font-12 text-gray">- Quantidade máxima de alunos no curso.(Deixe 0 para ilimitado)</p><br>
            </div>
            <input type="number" name="capacity" value="{{ (!empty($webinar) and !empty($webinar->capacity)) ? $webinar->capacity : old('capacity') }}" class="form-control @error('capacity')  is-invalid @enderror" placeholder="{{ trans('forms.capacity_placeholder') }}" />
            @error('capacity')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        @endif

        <div class="row mt-15">

            @if($webinar->isWebinar())
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label class="input-label">{{ trans('public.start_date') }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="dateInputGroupPrepend">
                                <i data-feather="calendar" width="18" height="18" class="text-white"></i>
                            </span>
                        </div>
                        <input type="text" name="start_date" value="{{ (!empty($webinar) and $webinar->start_date) ? dateTimeFormat($webinar->start_date, 'Y-m-d H:i', false, false, $webinar->timezone) : old('start_date') }}" class="form-control @error('start_date')  is-invalid @enderror datetimepicker" aria-describedby="dateInputGroupPrepend" />
                        @error('start_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            @endif

            <div class="col-12 @if($webinar->isWebinar()) col-md-6 @endif">
                <div class="form-group">
                    <label class="input-label" data-bs-toggle="tooltip" data-bs-placement="right" title="Duração do total do curso">
                        {{ trans('public.duration') }} <i class="fa fa-info-circle"></i>
                    </label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="timeInputGroupPrepend">
                                <i data-feather="clock" width="18" height="18" class="text-white"></i>
                            </span>
                        </div>

                        <input type="text" name="duration" value="{{ (!empty($webinar) and !empty($webinar->duration)) ? $webinar->duration : old('duration') }}" class="form-control @error('duration')  is-invalid @enderror" />
                        @error('duration')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror


                    </div>
                    <div class="py-2">
                        <p class="font-12 text-gray">Exemplo: 6 semestres</p>
                        <p class="font-12 text-gray">Exemplo: 2 horas</p>
                    </div>
                </div>
            </div>
        </div>

        @if($webinar->isWebinar() and getFeaturesSettings('timezone_in_create_webinar'))
        @php
        $selectedTimezone = getGeneralSettings('default_time_zone');

        if (!empty($webinar->timezone)) {
        $selectedTimezone = $webinar->timezone;
        } elseif (!empty($authUser) and !empty($authUser->timezone)) {
        $selectedTimezone = $authUser->timezone;
        }
        @endphp

        <div class="form-group">
            <label class="input-label">{{ trans('update.timezone') }}</label>
            <select name="timezone" class="form-control select2" data-allow-clear="false">
                @foreach(getListOfTimezones() as $timezone)
                <option value="{{ $timezone }}" @if($selectedTimezone==$timezone) selected @endif>{{ $timezone }}</option>
                @endforeach
            </select>
            @error('timezone')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        @endif

        <div class="form-group mt-30 d-flex align-items-center justify-content-between mb-5">
            <label class="cursor-pointer input-label" for="forumSwitch">{{ trans('update.course_forum') }}</label>
            <div class="custom-control custom-switch">
                <input type="checkbox" name="forum" class="custom-control-input" id="forumSwitch" {{ !empty($webinar) && $webinar->forum ? 'checked' : (old('forum') ? 'checked' : '')  }}>
                <label class="custom-control-label" for="forumSwitch"></label>
            </div>
        </div>
        <div>
            <br>
            <p class="font-12 text-gray">- {{ trans('update.panel_course_forum_hint') }}</p>
        </div>

        <div class="form-group mt-30 d-flex align-items-center justify-content-between">
            <label class="cursor-pointer input-label" for="supportSwitch">{{ trans('webinars.support') }}</label>
            <div class="custom-control custom-switch">
                <input type="checkbox" name="support" class="custom-control-input" id="supportSwitch" {{ ((!empty($webinar) && $webinar->support) or old('support') == 'on') ? 'checked' :  '' }}>
                <label class="custom-control-label" for="supportSwitch"></label>
            </div>
        </div>
        <div>
            <p class="font-12 text-gray">- Ao habilitar esse opção os alunos conseguirão tirar dúvidas direto com o professor pela plataforma.</p>
        </div>

        <div class="form-group mt-30 d-flex align-items-center justify-content-between">
            <label class="cursor-pointer input-label" for="certificateSwitch">{{ trans('update.include_certificate') }}</label>
            <div class="custom-control custom-switch">
                <input type="checkbox" name="certificate" class="custom-control-input" id="certificateSwitch" {{ ((!empty($webinar) && $webinar->certificate) or old('certificate') == 'on') ? 'checked' :  '' }}>
                <label class="custom-control-label" for="certificateSwitch"></label>
            </div>
        </div>

        <div>
            <p class="font-12 text-gray">- {{ trans('update.certificate_completion_hint') }}</p>
        </div>

        <div class="form-group mt-30 d-flex align-items-center justify-content-between">
            <label class="cursor-pointer input-label" for="downloadableSwitch">{{ trans('home.downloadable') }}</label>
            <div class="custom-control custom-switch">
                <input type="checkbox" name="downloadable" class="custom-control-input" id="downloadableSwitch" {{ ((!empty($webinar) && $webinar->downloadable) or old('downloadable') == 'on') ? 'checked' : '' }}>
                <label class="custom-control-label" for="downloadableSwitch"></label>
            </div>
        </div>
        <div>
            <p class="font-12 text-gray">- Ao habilitar esse opção os alunos conseguirão fazer o download dos conteúdos do curso.</p>
        </div>
        {{--
            <div class="form-group mt-30 d-flex align-items-center justify-content-between">
            <label class="cursor-pointer input-label" for="partnerInstructorSwitch">
                {{ trans('public.partner_instructor') }}
        </label>
        <div class="custom-control custom-switch">
            <input type="checkbox" name="partner_instructor" class="custom-control-input" id="partnerInstructorSwitch" {{ ((!empty($webinar) && $webinar->partner_instructor) or old('partner_instructor') == 'on') ? 'checked' : ''  }}>
            <label class="custom-control-label" for="partnerInstructorSwitch"></label>
        </div>
    </div>
    <div>
        <p class="font-12 text-gray">- Ao habilitar esse opção o professor convidado terá acesso ao conteúdo do curso. Seu perfil será mostrado na página do curso.</p>
        <p class="font-12 text-gray">- O professor precisa ter conta no All Learn.</p>

    </div>
    --}}
    <div class="form-group mt-15">
        <label class="input-label d-block">
            {{ trans('public.tags') }} (opcional)
        </label>
        <div>
            <p class="font-12 text-gray">- Palavra-chave que ajudará os usuários a encontrar seu curso.</p><br>
        </div>
        <input type="text" name="tags" data-max-tag="5" value="{{ !empty($webinar) ? implode(',',$webinarTags) : '' }}" class="form-control inputtags" placeholder="{{ trans('public.type_tag_name_and_press_enter') }} ({{ trans('forms.max') }} : 5)" />
    </div>


    <div class="form-group mt-15">
        <label class="input-label">{{ trans('public.category') }}</label>
        <div>
            <p class="font-12 text-gray">- Através dela que seus compradores encontrarão seu curso com mais facilidade.</p><br>
        </div>

        <select id="categories" class="custom-select @error('category_id')  is-invalid @enderror" name="category_id" required>
            <option {{ (!empty($webinar) and !empty($webinar->category_id)) ? '' : 'selected' }} disabled>{{ trans('public.choose_category') }}</option>
            @foreach($categories as $category)
            @if(!empty($category->subCategories) and $category->subCategories->count() > 0)
            <optgroup label="{{  $category->title }}">
                @foreach($category->subCategories as $subCategory)
                <option value="{{ $subCategory->id }}" {{ ((!empty($webinar) and $webinar->category_id == $subCategory->id) or old('category_id') == $subCategory->id) ? 'selected' : '' }}>{{ $subCategory->title }}</option>
                @endforeach
            </optgroup>
            @else
            <option value="{{ $category->id }}" {{ ((!empty($webinar) and $webinar->category_id == $category->id) or old('category_id') == $category->id) ? 'selected' : '' }}>{{ $category->title }}</option>
            @endif
            @endforeach
        </select>
        @error('category_id')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <section class="mt-50">
        <div class="">
            <h2 class="section-title after-line">{{ trans('public.prerequisites') }} ({{ trans('public.optional') }})</h2>
        </div>
        <div>
            <br>
            <p class="font-12 text-gray">- Aqui você deve incluir os pré requisitos necessários para que o aluno ingressar neste curso. Ex. Curso Excel Avançado, você pode definir como pré-requisito que o aluno tenha excel intermediário.</p>
            <p class="font-12 text-gray">- Só pode escolher como requsito necessário, os seus cursos e não de outros.</p>
            <br>
        </div>

        <button id="webinarAddPrerequisites" data-webinar-id="{{ $webinar->id }}" type="button" class="btn btn-primary btn-sm mt-15">{{ trans('public.add_prerequisites') }}</button>

        <div class="row mt-10">
            <div class="col-12">

                <div class="accordion-content-wrapper mt-15" id="prerequisitesAccordion" role="tablist" aria-multiselectable="true">
                    @if(!empty($webinar->prerequisites) and count($webinar->prerequisites))
                    <ul class="draggable-lists" data-order-table="prerequisites">
                        @foreach($webinar->prerequisites as $prerequisiteInfo)
                        @include('web.default.panel.webinar.create_includes.accordions.prerequisites',['webinar' => $webinar,'prerequisite' => $prerequisiteInfo])
                        @endforeach
                    </ul>
                    @else
                    @include(getTemplate() . '.includes.no-result',[
                    'file_name' => 'comment.png',
                    'title' => trans('public.prerequisites_no_result'),
                    'hint' => trans('public.prerequisites_no_result_hint'),
                    ])
                    @endif
                </div>
            </div>
        </div>
    </section>

    <div id="newPrerequisiteForm" class="d-none">
        @include('web.default.panel.webinar.create_includes.accordions.prerequisites',['webinar' => $webinar])
    </div>

</div>
</div>

@push('scripts_bottom')
<script src="/assets/default/vendors/select2/select2.min.js"></script>
<script src="/assets/default/vendors/moment.min.js"></script>
<script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>
<script src="/assets/default/vendors/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
@endpush