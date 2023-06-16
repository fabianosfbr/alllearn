<section class="mt-30">
    <h2 class="section-title after-line">Transferir valor</h2>
    <div class="text-center">
        <img src="/assets/default/img/activity/36.svg" class="account-balance-icon" alt="">

        <h3 class="font-16 font-weight-500 text-gray mt-25">{{ trans('panel.account_balance') }}</h3>
        <span class="mt-5 d-block font-30 text-secondary">{{ formatar_moeda($authUser->getAccountingBalance()) }}</span>
    </div>

    <div class="row mt-20">
        <div class="col-12 col-lg-4">



            <div class="form-group">
                <label class="input-label">Valor</label>
                <input type="text" name="amount" class="form-control @error('amount')  is-invalid @enderror" placeholder="" />
                @error('amount')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>


            <div class="form-group">
                <label class="form-label" for="description">Descrição</label>
                <textarea id="description" name="description" rows="4" class="form-control @error('description')  is-invalid @enderror"></textarea>
                @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

        </div>
    </div>

</section>