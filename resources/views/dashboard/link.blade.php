@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="c-link-header">
            <div class="c-link-header__info">
                @include('dashboard.features.info')
            </div>
            <div class="c-link-header__globe" id="globe" data-visits="{{ json_encode($visits) }}"></div>
            <div class="c-link-header__info">
                @include('dashboard.features.top-countries')
                @include('dashboard.features.top-referrals')
            </div>
        </div>
        <section class="c-section--link-container">
            @include('dashboard.features.visit-log')
        </section>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/globe.js') }}" defer></script>
    <script>

    </script>
@endsection