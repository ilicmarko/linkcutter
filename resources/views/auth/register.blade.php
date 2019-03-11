@extends('layouts.app')

@section('content')

    <div class="poster" style="background-image: url('{{ asset('images/secure.jpg') }}')"></div>
    <div class="c-login-canvas"><canvas></canvas></div>

    <section class="c-login-container">
        <div class="c-login__box">
            <h1>{{ __('Register') }}</h1>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="c-pricing-modal__row">
                    <div class="c-pricing-modal__field{{ $errors->has('name') ? ' is-invalid' : '' }}">
                        <input class="c-pricing-modal__input" id="name" name="name" value="{{ old('name') }}" required autofocus>
                        <label class="c-pricing-modal__label" for="name">{{ __('Name') }}</label>
                    </div>
                </div>
                <div class="c-pricing-modal__row">
                    <div class="c-pricing-modal__field{{ $errors->has('email') ? ' is-invalid' : '' }}">
                        <input class="c-pricing-modal__input" id="email" type="email" name="email" value="{{ old('email') }}" required>
                        <label class="c-pricing-modal__label" for="email">{{ __('E-Mail Address') }}</label>
                    </div>
                </div>
                <div class="c-pricing-modal__row">
                    <div class="c-pricing-modal__field">
                        <input class="c-pricing-modal__input" id="password" type="password" name="password" required>
                        <label class="c-pricing-modal__label" for="password" data-tid="elements_examples.form.city_label">{{ __('Password') }}</label>
                    </div>
                </div><small id="strength-output"></small>
                <div class="c-pricing-modal__row">
                    <div class="c-pricing-modal__field">
                        <input class="c-pricing-modal__input" id="rpw" type="password" name="password_confirmation" required>
                        <label class="c-pricing-modal__label" for="rpw" data-tid="elements_examples.form.city_label">{{ __('Confirm Password') }}</label>
                    </div>
                </div><small>If you want to keep a secret, you must also hide it from yourself.</small>
                <div class="c-pricing-modal__footer"><a class="btn" href="{{ route('login') }}">
                        <span class="icon-l">@icon('lock')</span>
                        {{ __('Login') }}
                    </a>
                    <button class="btn btn--secondary" type="submit">{{ __('Register') }}</button>
                </div>
            </form>
        </div>
    </section>

@endsection

@section('scripts')
    <script src="{{ asset('js/registration.js') }}" defer></script>
@endsection