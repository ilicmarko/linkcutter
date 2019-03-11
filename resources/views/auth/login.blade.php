@extends('layouts.app')

@section('content')
    <section class="c-login-container">
        <div class="c-login__box">
            <h1>{{ __('Login') }}</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="c-pricing-modal__row">
                    <div class="c-pricing-modal__field {{ $errors->has('email') ? ' is-invalid' : '' }}">
                        <input name="email" class="c-pricing-modal__input" id="email" type="email" placeholder="your@email.com" required="">
                        <label class="c-pricing-modal__label" for="email">{{ __('E-Mail Address') }}</label>
                    </div>
                    @if ($errors->has('email'))
                        <small>{{ $errors->first('email') }}</small>
                    @endif
                </div>
                <div class="c-pricing-modal__row">
                    <div class="c-pricing-modal__field half-width{{ $errors->has('password') ? ' is-invalid' : '' }}">
                        <input name="password" class="c-pricing-modal__input" id="pw" type="password" required="">
                        <label class="c-pricing-modal__label" for="pw">{{ __('Password') }}</label>
                    </div>
                </div>

                <small>If you want to keep a secret, you must also hide it from yourself.</small>

                <div class="u-flex u-flex--s-b">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                    </label>

                    <a href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                </div>
                <div class="c-pricing-modal__footer"><a class="btn" href="{{ route('register') }}">{{ __('Register') }}</a>
                    <button class="btn btn--secondary" type="submit">
                        {{ __('Login') }}
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
