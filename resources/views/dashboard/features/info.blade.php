<ul class="c-link-list">
    <li class="c-link-list__item">
        <span class="c-link-list__desc">Hash</span>
        <strong class="c-link-list__num">{{ $link->hash }}</strong>
    </li>
    <li class="c-link-list__item">
        <span class="c-link-list__desc">Link host</span>
        <strong class="c-link-list__num">{{ \App\Http\Controllers\URLFactory::getHost($link->link) }}</strong>
    </li>
    <li class="c-link-list__item">
        <span class="c-link-list__desc">Pageviews</span>
        <strong class="c-link-list__num">{{ $link->countVisits() }}</strong>
    </li>
    @if (Auth::user()->hasFeature('unique-visits'))
        <li class="c-link-list__item">
            <span class="c-link-list__desc">Total unique visitors</span>
            <strong class="c-link-list__num">{{ $link->countUniqueVisits() }}</strong>
        </li>
        <li class="c-link-list__item">
            <span class="c-link-list__desc">Total unique countries</span>
            <strong class="c-link-list__num">{{ $link->countUniqueCountryVisits() }}</strong>
        </li>
    @endif
    @if (Auth::user()->hasFeature('vpn-detector'))
        <li class="c-link-list__item">
            <span class="c-link-list__desc">Total visitors using VPN</span>
            <strong class="c-link-list__num">48</strong>
        </li>
    @endif
    <li class="c-link-list__item">
        <span class="c-link-list__desc">Link shortened</span>
        <strong class="c-link-list__num">{{ $link->created_at->format('j. M y.') }}</strong>
    </li>
</ul>
