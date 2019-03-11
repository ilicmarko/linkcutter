@if (Auth::user()->hasFeature('geo-location'))
    <h3 class="c-link-header__info-title">Top countries</h3>
    <ul class="c-link-list c-link-list--graph">
        @foreach($link->getTopNCountries() as $country => $value)
            <li class="c-link-list--graph__item">
                <div class="c-link-list--graph__bar" style="width: {{ $value['scaled'] }}%"></div>
                <span class="c-link-list--graph__desc">{{ $country }}</span>
                <strong class="c-link-list--graph__num">{{ $value['count'] }}</strong>
            </li>
        @endforeach
    </ul>
@endif