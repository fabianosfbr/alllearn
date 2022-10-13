@extends(getTemplate().'.layouts.app')

@section('content')
    <div class="container">
        @if(!empty(session()->has('msg')))
            <div class="alert alert-info alert-dismissible fade show mt-30" role="alert">
                {{ session()->get('msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row login-container">

            <div class="col-12 col-md-6 pl-0">
                <img src="{{ getPageBackgroundSettings('login') }}" class="img-cover" alt="Login">
            </div>
            <div class="col-12 col-md-6">
                <div class="login-card">
                    <h1 class="font-20 font-weight-bold">{{ trans('auth.login_h1') }}</h1>

                    <form method="Post" action="/login" class="mt-35">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="input-label" for="username">{{ trans('auth.email_or_mobile') }}:</label>
                            <input name="username" type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                                   value="{{ old('username') }}" aria-describedby="emailHelp">
                            @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="input-label" for="password">{{ trans('auth.password') }}:</label>
                            <input name="password" type="password" class="form-control @error('password')  is-invalid @enderror" id="password" aria-describedby="passwordHelp">

                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mt-20">{{ trans('auth.login') }}</button>
                    </form>

                   
                    <div class="mt-30 text-center">
                        <a href="/forget-password" target="_blank">{{ trans('auth.forget_your_password') }}</a>
                    </div>

                    <div class="mt-20 text-center">
                        <span>{{ trans('auth.dont_have_account') }}</span>
                        <a href="/register" class="text-secondary font-weight-bold">{{ trans('auth.signup') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
