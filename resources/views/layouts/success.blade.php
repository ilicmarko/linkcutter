@if (session('success_msg'))
    <div class="c-alert c-alert--success" role="alert">
        {!! session('success_msg') !!}
    </div>
@endif