@if (session('alert_msg'))
    <div class="alert alert-primary" role="alert">
        {!! session('alert_msg') !!}
    </div>
@endif