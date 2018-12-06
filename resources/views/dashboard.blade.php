@extends('layouts.app')

@section('title', 'Dashboard')

<?php
  $filterUnique = function ($item) { if($item->unique_visit) { return $item; } }
?>

@section('scripts')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {
    'packages':['geochart'],
    'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
  });
  google.charts.setOnLoadCallback(drawRegionsMap);

  const map = document.getElementById('regions_div');
  const points = JSON.parse(map.dataset.map);
  points.unshift(['Country', 'Popularity']);
  console.log(points);

  function drawRegionsMap() {
    var data = google.visualization.arrayToDataTable(points);

    var options = {};

    var chart = new google.visualization.GeoChart(map);

    chart.draw(data, options);
  }
</script>

@endsection

@section('content')
<h1>Welcome to your dashboard</h1>
<h3>Your original url: <a href="{{ $url }}" target="_blank">{{ $url }}</a></h3>
<h3>Your short url: <a href="{{ $short_url }}" target="_blank">{{ $short_url }}</a></h3>
<div class="row">
  <div class="col-xs-12 col-md-4">
      <div class="card">
        <div class="card-header">Number of visits:</div>
        <div class="card-body">{{ $all = $visitors->count() }}</div>
      </div>
  </div>
  <div class="col-xs-12 col-md-4">
      <div class="card">
        <div class="card-header">Number of <strong>unique</strong> visits:</div>
        <div class="card-body">{{ $unique = $visitors->filter($filterUnique)->count() }}</div>
      </div>
  </div>
  <div class="col-xs-12 col-md-4">
      <div class="card">
        <div class="card-header">Percentage of unique visitors:</div>
        <div class="card-body">{{ number_format($unique /  $all * 100, 2)}}%</div>
      </div>
  </div>
</div>
<div id="regions_div" data-map="{{ json_encode($chart_data) }}" style="width: 900px; height: 500px;"></div>
<h2>Activity Log:</h2>
<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Country</th>
      <th>City</th>
      <th>IP</th>
      <th>User Agent</th>
      <th>Date</th>
      <th>gMaps location</th>
    </tr>
  </thead>
  @foreach($visitors->all() as $visitor)
    <tr>
      <td>
        <img src="http://www.countryflags.io/{{ $visitor->country_code }}/flat/16.png">
        {{ $visitor->country }}
      </td>
      <td>{{ $visitor->city }}</td>
      <td>{{ $visitor->ip_address }}</td>
      <td>{{ $visitor->user_agent }}</td>
      <td>{{ $visitor->created_at }}</td>
      <td><a href="https://maps.google.com/?q={{$visitor->lat}},{{$visitor->lng}}" target="_blank">Link</a></td>

    </tr>
  @endforeach
</table>
@endsection
