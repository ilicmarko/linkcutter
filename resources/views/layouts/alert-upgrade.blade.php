@if ($msg = session('upgrade_msg'))
    <div class="c-alert c-alert--info" role="alert">
        {{$msg}}
    </div>
@endif