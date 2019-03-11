@extends('layouts.app')

@section('content')
    <header class="c-dashboard__header">
        <h1 class="c-dashboard__header-title">Profile</h1>
    </header>
    <section class="c-section--container">
        <form action="{{ route('profile.edit') }}" method="POST">
            @csrf
            <div class="c-pricing-modal__row">
                <div class="c-pricing-modal__field">
                    <input class="c-pricing-modal__input is-changed" id="name" type="text" name="name" value="{{ Auth::user()->name }}">
                    <label class="c-pricing-modal__label" for="name">Name</label>
                </div>
                <div class="c-pricing-modal__field">
                    <input class="c-pricing-modal__input" id="pw" type="password" name="password">
                    <label class="c-pricing-modal__label" for="pw">Password</label>
                </div>
            </div>
            <div class="c-pricing-modal__footer">
                <button class="btn btn--secondary" type="submit">Change</button>
            </div>
        </form>
    </section>
    <header class="c-dashboard__header">
        <h1 class="c-dashboard__header-title">Billing</h1>
    </header>
    <section class="c-section--container">
        @if (Auth::user()->subscribed())
            <table>
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->date()->toFormattedDateString() }}</td>
                        <td>{{ $invoice->total() }}</td>
                        <td><a href="invoice/{{ $invoice->id }}">Download</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            You never subscribed to any of our plans. Maybe give them a spin?
        @endif
    </section>
@endsection