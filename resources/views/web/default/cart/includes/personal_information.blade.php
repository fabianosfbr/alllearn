<div>
    <p style="padding-bottom: 20px;">
        Informe seus dados pessoais para pagamento
    </p>

    <!-- Nome -->
    <div class="form-group row mb-4">
        <label class="input-label">Nome*</label>
        <input id="full_name" type="text" name="full_name"
            class="form-control @error('full_name')  is-invalid @enderror" placeholder=""
            value="{{ !empty($user) ? $user->full_name : old('full_name') }}" />
        @error('full_name')
        <div class="invalid-feedback d-flex">
            {{ $message }}
        </div>
        @enderror
    </div>
    <!-- Documentos -->
    <div class="form-group row mb-4">
        <div class="col-4">
            <div class="form-outline">
                <label class="input-label" for="form-checkout__identificationType">Tipo de documento*</label>

                <select name="identificationType" id="form-checkout__identificationType" class="form-control"></select>

                @error('identificationType')
                <div class="invalid-feedback d-flex">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="col-8">
            <div class="form-outline">
                <label class="input-label" for="form-checkout__identificationNumber">Número do documento*</label>
                <input type="text" name="identificationNumber" id="form-checkout__identificationNumber"
                    class="form-control" />
                @error('identificationNumber')
                <div class="invalid-feedback d-flex">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
    </div>
    <!-- Email -->
    <div class="form-group row mb-4">
        <label class="input-label" for="email">E-mail*</label>
        <input type="email" class="form-control @error('cardholderEmail')  is-invalid @enderror "
            value="{{ !empty($user) ? $user->email : old('cardholderEmail') }}" name="cardholderEmail"
            id="form-checkout__cardholderEmail" />
        @error('cardholderEmail')
        <div class="invalid-feedback d-flex">
            {{ $message }}
        </div>
        @enderror

    </div>

    <!-- Telefone /CEP -->
    <div class="form-group row mb-4">
        <div class="col-2">
            <label class="input-label">DDD*</label>
            <input id="ddd" class="form-control @error('code_zone')  is-invalid @enderror""
                                type=" text" name="code_zone"
                value="{{ !empty($user) ? $user->mobile_code_area : old('code_zone') }}">
            @error('code_zone')
            <div class="invalid-feedback d-flex">
                {{ $message }}
            </div>
            @enderror

        </div>

        <div class="col-5">
            <label class="input-label">Celular*</label>
            <input id="phone" type="tel" name="phone_number"
                class="form-control @error('phone_number')  is-invalid @enderror"
                value="{{ !empty($user) ? $user->mobile : old('mobile') }}" />
            @error('phone_number')
            <div class="invalid-feedback d-flex">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="col-5">
            <label class="input-label">CEP*</label>
            <input id="zip_code" type="text" name="zip_code"
                class="form-control @error('zip_code')  is-invalid @enderror"
                value="{{ !empty($user) ? $user->zip_code : old('zip_code') }}" />
            @error('zip_code')
            <div class="invalid-feedback d-flex">
                {{ $message }}
            </div>
            @enderror
        </div>

    </div>

    <!-- Endereço/Nº/Complemento -->
    <div class="form-group row mb-4">
        <div class="col-6">
            <label class="input-label">Nome da rua*</label>
            <input id="street_name" type="text" name="street_name"
                class="form-control @error('street_name')  is-invalid @enderror"
                value="{{ !empty($user) ? $user->street_name : old('street_name') }}" />
            @error('street_name')
            <div class="invalid-feedback d-flex">
                {{ $message }}
            </div>
            @enderror

        </div>

        <div class="col-3">
            <label class="input-label">Número*</label>
            <input id="street_number" type="text" name="street_number"
                class="form-control @error('street_number')  is-invalid @enderror"
                value="{{ !empty($user) ? $user->street_number : old('street_number') }}" />
            @error('street_number')
            <div class="invalid-feedback d-flex">
                {{ $message }}
            </div>
            @enderror

        </div>

        <div class="col-3">
            <label class="input-label">Complemento*</label>
            <input id="complement" type="text" name="complement"
                class="form-control @error('neigborhood')  is-invalid @enderror"
                value="{{ !empty($user) ? $user->complement : old('complement') }}" />
            @error('complement')
            <div class="invalid-feedback d-flex">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <!-- Bairro/Cidade/UF -->
    <div class="form-group row mb-4">
        <div class="col-4">
            <label class="input-label">Bairro*</label>
            <input id="neigborhood" type="text" name="neigborhood"
                class="form-control @error('neigborhood')  is-invalid @enderror"
                value="{{ !empty($user) ? $user->neigborhood : old('neigborhood') }}" />
            @error('neigborhood')
            <div class="invalid-feedback d-flex">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="col-4">
            <label class="input-label">Cidade*</label>
            <input id="city" type="text" name="city" class="form-control @error('city')  is-invalid @enderror"
                value="{{ !empty($user) ? $user->city : old('city') }}" />
            @error('city')
            <div class="invalid-feedback d-flex">
                {{ $message }}
            </div>
            @enderror

        </div>
        <div class="col-4">
            <label class="input-label">Estado*</label>
            <select class="form-control @error('federal_unit')  is-invalid @enderror"" id=" federal_unit"
                name="federal_unit">
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