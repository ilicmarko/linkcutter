@if (Auth::user()->hasFeature('referral'))
    <h3 class="c-link-header__info-title">Top referrals</h3>
    <ul class="c-link-list c-link-list--graph">
        @foreach($link->getTopReferral() as $host => $value)
            <li class="c-link-list--graph__item">
                <div class="c-link-list--graph__bar" style="width: {{ $value['scaled'] }}%"></div>
                <span class="c-link-list--graph__desc">{{ $host }}</span>
                <strong class="c-link-list--graph__num">{{ $value['count'] }}</strong>
            </li>
        @endforeach
    </ul>
@endif