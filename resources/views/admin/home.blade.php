@extends('admin.layouts.master')


@section('content')
    <div class="dashboard-stats-container">
        <div class="dashboard-card dashboard-segment dashboard-segment--1">
            <div class="dashboard-segment__chart">
                <canvas id="segchar1" height="36"></canvas>
            </div>

            <div class="dashboard-segment__info">
                <strong class="dashboard-segment__title">Free Plans</strong>
                <span class="dashboard-segment__number">36%</span>
            </div>
        </div>

        <div class="dashboard-card dashboard-segment dashboard-segment--2">
            <div class="dashboard-segment__chart">
                <canvas id="segchar2" height="36"></canvas>
            </div>

            <div class="dashboard-segment__info">
                <strong class="dashboard-segment__title">Cat Plans</strong>
                <span class="dashboard-segment__number">42%</span>
            </div>
        </div>

        <div class="dashboard-card dashboard-segment dashboard-segment--3">
            <div class="dashboard-segment__chart">
                <canvas id="segchar3" height="36"></canvas>
            </div>

            <div class="dashboard-segment__info">
                <strong class="dashboard-segment__title">Mau Plans</strong>
                <span class="dashboard-segment__number">22%</span>
            </div>
        </div>

        <div class="dashboard-card dashboard-linechart">
            <h4>Purchases</h4>
            <canvas id="linechart" height="200"></canvas>
        </div>

        <div class="dashboard-card dashboard-info">
            <h4>Link Visits By Country</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Country</th>
                        <th>Nuber of visits</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><img src="http://www.countryflags.io/rs/flat/16.png"> Serbia</td>
                        <td>500</td>
                    </tr>
                    <tr>
                        <td><img src="http://www.countryflags.io/us/flat/16.png"> America</td>
                        <td>23</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="dashboard-card dashboard-card--primary dashboard-info--2">
            <h3>Monthly Earnings</h3>
            <strong>34051 $</strong>
        </div>
        <div class="dashboard-card dashboard-info--3">
            <h3>Today's Earnings</h3>
            <strong>42 $</strong>
        </div>
    </div>
@endsection
