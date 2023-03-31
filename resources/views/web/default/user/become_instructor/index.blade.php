@extends(getTemplate().'.layouts.app')


@section('content')
<div class="container">

    <div class="row login-container">
        <div class="col-12 col-md-6 pl-0">
            <img src="{{ getPageBackgroundSettings('become_instructor') }}" class="img-cover" alt="Login">
        </div>

        <div class="col-12 col-md-6">
            <div class="login-card">
                <h1 class="font-20 font-weight-bold">Solicitação para tornar-se um parceiro.</h1>

                <form method="Post" action="/become-instructor" class="mt-35">
                    {{ csrf_field() }}

                    <div class="form-group">


                    </div>

                    <div class="form-group">
                        <label class="font-weight-500 text-dark-blue">Tipo de conta</label>
                        <select name="role" class="form-control @error('role')  is-invalid @enderror">
                            <option selected disabled>{{ trans('update.select_role') }}</option>
                            <option value="{{ \App\Models\Role::$business }}" {{ $isBusinessRole ? 'selected' : '' }}>Empresa</option>
                            <option value="{{ \App\Models\Role::$teacher }}" {{ $isInstructorRole ? 'selected' : '' }}>{{ trans('panel.teacher') }}</option>
                            <option value="{{ \App\Models\Role::$organization }}" {{ $isOrganizationRole ? 'selected' : '' }}>{{ trans('home.organization') }}</option>
                        </select>
                        @error('role')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="font-weight-500 text-dark-blue">Nº CNPJ</label>
                        <input type="text" name="cnpj_id" value="{{ (!empty($user)) ? $user->cnpj_id : old('cnpj_id') }}" class="form-control @error('cnpj_id')  is-invalid @enderror" placeholder=""/>
                        @error('cnpj_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="js-instructor-label font-weight-500 text-dark-blue {{ !$isInstructorRole ? 'd-none' : '' }}">Faça o upload do RG ou CNH ou Passaporte</label>
                        <label class="js-organization-label font-weight-500 text-dark-blue {{ !$isOrganizationRole ? 'd-none' : '' }}">Faça o upload do Contrato social da empresa</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="button" class="input-group-text panel-file-manager" data-input="certificate" data-preview="holder">
                                    <i data-feather="arrow-up" width="18" height="18" class="text-white"></i>
                                </button>
                            </div>
                            <input type="text" name="certificate" id="certificate" value="{{ (!empty($user)) ? $user->certificate : old('certificate') }}" class="form-control  @error('certificate')  is-invalid @enderror" readonly />
                            @error('certificate')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="js-instructor-label font-weight-500 text-dark-blue {{ !$isInstructorRole ? 'd-none' : '' }}">{{ trans('update.instructor_select_account_type') }}</label>
                        <label class="js-organization-label font-weight-500 text-dark-blue {{ !$isOrganizationRole ? 'd-none' : '' }}">{{ trans('update.organization_select_account_type') }}</label>
                        <select name="account_type" class="form-control @error('account_type')  is-invalid @enderror">
                            <option selected disabled>{{ trans('financial.select_account_type') }}</option>

                            @if(!empty(getOfflineBanksTitle()) and count(getOfflineBanksTitle()))
                            @foreach(getOfflineBanksTitle() as $accountType)
                            <option value="{{ $accountType }}" @if(!empty($user) and $user->account_type == $accountType) selected="selected" @endif>{{ $accountType }}</option>
                            @endforeach
                            @endif
                        </select>
                        @error('account_type')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>



                    <div class="form-group">
                        <label class="js-instructor-label font-weight-500 text-dark-blue {{ !$isInstructorRole ? 'd-none' : '' }}">{{ trans('update.instructor_account_id') }}</label>
                        <label class="js-organization-label font-weight-500 text-dark-blue {{ !$isOrganizationRole ? 'd-none' : '' }}">{{ trans('update.organization_account_id') }}</label>
                        <input type="text" name="account_id" value="{{ (!empty($user)) ? $user->account_id : old('account_id') }}" class="form-control @error('account_id')  is-invalid @enderror" placeholder="" />
                        @error('account_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="js-instructor-label font-weight-500 text-dark-blue {{ !$isInstructorRole ? 'd-none' : '' }}">Faça o upload do Cartão CNPJ digitalizado</label>
                        <label class="js-organization-label font-weight-500 text-dark-blue {{ !$isOrganizationRole ? 'd-none' : '' }}">Faça o upload do Cartão CNPJ digitalizado</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="button" class="input-group-text panel-file-manager" data-input="identity_scan" data-preview="holder">
                                    <i data-feather="arrow-up" width="18" height="18" class="text-white"></i>
                                </button>
                            </div>
                            <input type="text" name="identity_scan" id="identity_scan" value="{{ (!empty($user)) ? $user->identity_scan : old('identity_scan') }}" class="form-control @error('identity_scan')  is-invalid @enderror" readonly/>
                            @error('identity_scan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="js-instructor-label font-weight-500 text-dark-blue {{ !$isInstructorRole ? 'd-none' : '' }}">{{ trans('update.instructor_extra_information') }}</label>
                        <label class="js-organization-label font-weight-500 text-dark-blue {{ !$isOrganizationRole ? 'd-none' : '' }}">{{ trans('update.organization_extra_information') }}</label>
                        <textarea name="description" rows="6" class="form-control">{{ !empty($lastRequest) ? $lastRequest->description : old('description') }}</textarea>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="term" value="1" {{ (!empty(old('term')) and old('term') == '1') ? 'checked' : '' }} class="custom-control-input @error('term') is-invalid @enderror" id="term">
                        <label class="custom-control-label font-14" for="term">Eu li e estou de acordo com os
                            <a href="https://drive.google.com/file/d/1WEi_W8ZGod7aq0eZmQUlmz8_JbIfTEtB/view?usp=share_link" target="_blank" class="text-secondary font-weight-bold font-14">Termos de Parceria</a>
                        </label>

                        @error('term')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div>
                        <p class="js-instructor-label font-weight-500" style="font-size: 16px">
                        <span class="font-weight-bold" style="color: red; font-size: 16px;">Atenção:</span>
                         O prazo para aprovação de parceria é de no máximo 48 horas após a solicitação.
                        </p>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block mt-20">{{ (!empty(getRegistrationPackagesGeneralSettings('show_packages_during_registration')) and getRegistrationPackagesGeneralSettings('show_packages_during_registration')) ? trans('webinars.next') : trans('site.send_request') }}</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts_bottom')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>

<script src="/assets/default/js/parts/become_instructor.min.js"></script>
@endpush
