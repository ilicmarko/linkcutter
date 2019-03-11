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

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="c-pricing-modal__row">
                    <div class="c-pricing-modal__field {{ $errors->has('email') ? ' is-invalid' : '' }}">
                        <input id="email" type="email" class="c-pricing-modal__input" name="email" value="{{ old('email') }}" required>
                        <label class="c-pricing-modal__label" for="email">{{ __('E-Mail Address') }}</label>
                    </div>
                    @if ($errors->has('email'))
                        <small>{{ $errors->first('email') }}</small>
                    @endif
                </div>

                <div class="c-pricing-modal__footer"><a class="btn" href="{{ route('register') }}">{{ __('Register') }}</a>
                    <button type="submit" class="btn btn-primary">
                        {{ __('Send Password Reset Link') }}
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
