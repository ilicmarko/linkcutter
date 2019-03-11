<?php

namespace App\Http\Controllers;

use App\Link;
use App\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Ixudra\Curl\Facades\Curl;

class URLFactory extends Controller
{
    /**
     * Clean the given URL, remove spaces and remove tailing slash.
     *
     * @param string $url
     * @return string
     */
    public static function URLCleaner($url)
    {
        $new_url = trim($url);
        $new_url = rtrim($new_url, '/');
        return $new_url;
    }

    /**
     * Return a random string of provided length.
     * @param $length
     * @return string
     */

    private static function generateRandomString($length)
    {
//        return substr(base_convert(hash('sha256', uniqid(rand())), 16, 36), 0, $length);
        return substr(base_convert(bin2hex(random_bytes(10)), 16, 36), 0, $length);
    }

    /**
     * Generate a unique hash.
     *
     * @return string
     */
    public static function generateUniqueHash()
    {
        $hash = self::generateRandomString(rand(1, 5));

        while (self::checkIfHashInDB($hash)) {
            $hash = self::generateRandomString(rand(1, 5));
        }

        return $hash;
    }

    /**
     * Check if URL is already in database.
     *
     * @param string $longUrl
     * @param bool $clean
     * @return bool
     */
    private static function checkIfLinkInDB($longUrl, $clean = true)
    {
        $url = ($clean) ? self::URLCleaner($longUrl) : $longUrl;
        $link = Link::where('link', '=', $url)->where('tracked', 0);

        return ($link->exists()) ? $link->first() : false;
    }

    /**
     * Check if provided hash already exists in database.
     *
     * @param string $customHash
     * @return bool
     */
    private static function checkIfHashInDB($customHash)
    {
        $link = Link::where('hash', '=', $customHash);

        return ($link->exists()) ? $link->first() : false;
    }

    /**
     * Check if provided URL is a valid.
     *
     * @param string $url
     * @return bool
     */
    private static function validateURL($url)
    {
        return preg_match('/^[a-zA-Z0-9-_]+$/', $url);
    }

    /**
     * @param $longUrl
     * @param bool $isTracked
     * @param null $customHash
     * @return null|string
     * @throws \Exception
     */
    public static function generateShortLink($longUrl, $isTracked = false, $customHash = null)
    {
        // If the URL isn't tracked nor custom (check if in database)
        if (!$isTracked && !isset($customHash)) {
            if ($link = self::checkIfLinkInDB($longUrl)) {
                return $link->hash;
            }
        }

        // If there is a custom URL
        if (isset($customHash)) {
            if (!self::validateURL($customHash)) {
                throw new \Exception(__('url.error.customHashInvalidChars', ['hash' => $customHash]));
            }

            if (self::checkIfHashInDB($customHash)) {
                throw new \Exception(__('url.error.customHashExists', ['hash' => $customHash]));
            }
            $urlHash = $customHash;
        } else {
            $urlHash = self::generateUniqueHash();
        }

        Link::create([
            'hash' => $urlHash,
            'link' => self::URLCleaner($longUrl),
            'tracked' => is_null($isTracked) ? false : $isTracked,
            'user_id' => \Auth::id(),
        ]);

        return $urlHash;
    }

    private static function getIPInfo($ip_address)
    {
        $info = geoip()->getLocation($ip_address);

        return [
            'ip_address' => $info->ip,
            'lat' => $info->lat,
            'lng' => $info->lon,
            'country' => $info->country,
            'country_code' => $info->iso_code,
            'city' => $info->city,
        ];
    }

    private static function checkIfBrowserIpIsUnique($link, $userAgent, $ip)
    {
        return Visit::where('link_id', $link->id)
            ->where('user_agent', $userAgent)
            ->where('ip_address', $ip)
            ->exists();
    }

    private static function checkIfUserVisitedLink($link, $sid)
    {
        return Visit::where('unique_id', $sid)
            ->where('link_id', $link->id)
            ->exists();
    }

    /**
     * Return the domain host.
     * @param string $url
     * @return string
     */
    public static function getHost($url)
    {
        return parse_url($url, PHP_URL_HOST);
    }

    private static function checkIfVPN($ip)
    {
        $PROXY_CHECKER_URL = 'http://proxy.mind-media.com/block/proxycheck.php?ip=';

        $response = Curl::to($PROXY_CHECKER_URL . $ip)
            ->get();

        switch (strtoupper($response))
        {
            case 'Y': $response = 1; break;
            case 'N': $response = 0; break;
        }

        return $response;
    }

    public static function registerClick(Link $link, $request)
    {
        $sid = Cookie::get('sid');
        $unique = 0;

        if ($link->tracked == false) {
            return;
        }

        $ip = self::getIPInfo($request->ip());
        $userAgent = $request->server('HTTP_USER_AGENT');
        $referer = $request->server('HTTP_REFERER');
        $isVPN = self::checkIfVPN($ip['ip_address']);

        if ($sid !== null) {
            if (self::checkIfUserVisitedLink($link, $sid)) {
                $unique = 0;
            } else {
                $unique = 1;
            }
        }

        if ($sid === null) {
            $sid = session_create_id('linkcutter-');
            $unique = 1;
            Cookie::queue('sid', $sid, 2628000); //Cookie::forever('sid', $sid);

            if (self::checkIfBrowserIpIsUnique($link, $userAgent, $ip['ip_address'])) {
                $unique = 0;
            }
        }
        $store = [
            'unique_id'     => $sid,
            'user_agent'    => $userAgent,
            'unique_visit'  => $unique,
            'referer'       => $referer,
            'referer_host'  => self::getHost($referer),
            'link_id'       => $link->id,
            'is_vpn'        => $isVPN,
        ];

        $store = array_merge($store, $ip);

        Visit::create($store);
    }
}
