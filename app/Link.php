<?php

namespace App;

use App\Helpers\Helper;
use DB;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Link
 *
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Visit[] $visits
 */
class Link extends Model
{
    protected $guarded = [];
//    protected $with = ['visits'];
//    protected $withCount = ['visits'];

    public function getRouteKeyName()
    {
        return 'hash';
    }


    public function visits()
    {
        return $this->hasMany('App\Visit');
    }

    public function countVisits()
    {
        return  $this->visits->count();
    }

    public function countUniqueVisits()
    {
        return  $this->visits->where('unique_visit', '=', 1)->count();
    }

    public function countVPNVisits()
    {
        return $this->visits->where('is_vpn', '=', 1)->count();
    }

    public function countUniqueCountryVisits()
    {
        return $this->visits->unique('country')->count();
    }

    public function getTopNCountries($n = 5)
    {
        return Helper::getScaledData($this->visits, 'country')->take($n);
    }

    public function getTopReferral($n = 5)
    {
        return Helper::getScaledData($this->visits, 'referer_host')->take($n);
    }
}
