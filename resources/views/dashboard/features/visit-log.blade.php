@if (Auth::user()->hasFeature('logger'))
    <h2>Visit log</h2>
    <div class="search-form">
        <input class="search-term" id="search-term" name="term" placeholder="Search"/>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                @if (Auth::user()->hasFeature('geo-location'))
                    <th>Country</th>
                    <th>City</th>
                @endif
                <th data-orderable="false">IP</th>
                @if (Auth::user()->hasFeature('vpn-detector'))
                    <th>VPN</th>
                @endif
                @if (Auth::user()->hasFeature('unique-visits'))
                    <th>Unique visit</th>
                @endif
                <th>User Agent</th>
                <th>Date</th>
                <th data-orderable="false">gMaps link</th>
            </tr>
        </thead>
        <tbody>
            @foreach($link->visits as $visitor)
                <tr>
                    @if (Auth::user()->hasFeature('geo-location'))
                        <td data-order="{{ $visitor->country }}">
                            <img src="http://www.countryflags.io/{{ $visitor->country_code }}/flat/16.png">
                            {{ $visitor->country }}
                        </td>
                        <td>{{ $visitor->city }}</td>
                    @endif
                    <td>{{ $visitor->ip_address }}</td>
                    @if (Auth::user()->hasFeature('vpn-detector'))
                        <td>{{ $visitor->is_vpn }}</td>
                    @endif
                    @if (Auth::user()->hasFeature('unique-visits'))
                        <td>{{ $visitor->unique_visit }}</td>
                    @endif
                    <td>{{ $visitor->user_agent }}</td>
                    <td data-order="{{ $visitor->created_at->timestamp }}">
                        {{ $visitor->created_at }}
                    </td>
                    <td>
                        <a href="https://maps.google.com/?q={{$visitor->lat}},{{$visitor->lng}}" target="_blank">Link</a>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
@endif