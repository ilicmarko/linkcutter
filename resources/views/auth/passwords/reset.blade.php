@extends('layouts.app')

@section('content')
    <section class="c-login-container">
        <div class="c-login__box">
            <h1>{{ __('Reset Password') }}</h1>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.request') }}>
                @csrf

                <div class="c-pricing-modal__row">
                    <div class="c-pricing-modal__field">
                        <input id="email" type="email" class="c-pricing-modal__input" name="email" value="{{ $email ?? old('email') }}" required autofocus>
                        <label class="c-pricing-modal__label" for="email">{{ __('E-Mail Address') }}</label>
                        @if ($errors->has('email'))
                            <strong>{{ $errors->first('email') }}</strong>
                        @endif
                    </div>
                </div>

                <div class="c-pricing-modal__row">
                    <div class="c-pricing-modal__field">
                        <input id="password" type="password" class="c-pricing-modal__input" name="password" required>
                        <label class="c-pricing-modal__label" for="password">{{ __('Password') }}</label>
                        @if ($errors->has('password'))
                            <strong>{{ $errors->first('password') }}</strong>
                        @endif
                    </div>
                </div>

                <div class="c-pricing-modal__row">
                    <div class="c-pricing-modal__field">
                        <input id="password-confirm" type="password" class="c-pricing-modal__input" name="password_confirmation" required>
                        <label class="c-pricing-modal__label" for="email">{{ __('Confirm Password') }}</label>
                        @if ($errors->has('password-confirm'))
                            <strong>{{ $errors->first('password-confirm') }}</strong>
                        @endif
                    </div>
                </div>

                <div class="c-pricing-modal__footer"><a class="btn" href="{{ route('register') }}">{{ __('Register') }}</a>
                    <button type="submit" class="btn btn-primary">
                        {{ __('Reset Password') }}
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection

