@extends('layouts.app')

@section('content')
    <section class="c-section--dark">
        <header class="c-dashboard__header">
            <h1 class="c-dashboard__header-title">Dashboard</h1>
        </header>
        <div class="c-dashboard__chart">
            <canvas id="generalChart"
                    data-visits="{{ json_encode($visitsByDay->pluck('visits')) }}"
                    data-unique="{{ json_encode($visitsByDay->pluck('unique_visits')) }}"></canvas>
        </div>
    </section>
    <div class="c-dashboard__card-container">
        <div class="c-dashboard__card">
            <div class="c-dashboard__card-num">{{ $links->count() }}</div>
            <div class="c-dashboard-card-caption">Number of links</div>
        </div>
        <div class="c-dashboard__card">
            <div class="c-dashboard__card-num">{{ $links->sum('visits_count') }}</div>
            <div class="c-dashboard-card-caption">Number of visits</div>
        </div>
        <div class="c-dashboard__card">
            <div class="c-dashboard__card-num">{{ $links->sum('unique_visits') }}</div>
            <div class="c-dashboard-card-caption">Number of unique visits</div>
        </div>
        <div class="c-dashboard__card">
            <div class="c-dashboard__card-num">{{ $links->sum('vpn_visits') }}</div>
            <div class="c-dashboard-card-caption">Number of VPN visits</div>
        </div>
    </div>
    <section class="c-section--container">
        <h2>Links</h2>
        <div class="table">
            <table class="data-table">
                <thead>
                <tr>
                    <th>Hash</th>
                    <th>Link</th>
                    <th>Clicks</th>
                    <th>Unique Clicks</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($links as $link)
                        <tr>
                            <td>
                                <a href="{{ route('dashboard.link.show', ['link' => $link->hash]) }}">
                                    {{ $link->hash }}
                                </a>
                            </td>
                            <td>{{ $link->link }}</td>
                            <td>{{ $link->visits_count }}</td>
                            <td>{{ $link->unique_visits }}</td>
                            <td>
                                <form action="{{ route('link.delete', $link->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit"
                                            href="{{ route('link.delete', $link->hash) }}"
                                            class="btn"
                                            onclick="return confirm('Are you sure?')">
                                        @icon('trash-2')
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection