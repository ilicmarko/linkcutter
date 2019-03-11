<?php

namespace App\Http\Controllers;

use App\Link;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data['links'] = Link::where('user_id', auth()->user()->id)
                            ->where('tracked', '=', 1)
                            ->withCount([
                                'visits',
                                'visits as unique_visits' => function($query){
                                    $query->where('unique_visit', '=', 1);
                                },
                                'visits as vpn_visits' => function($query) {
                                    $query->where('is_vpn', '=', 1);
                                }])
                            ->get();

//        $data['visits'] = Link::where('user_id', auth()->user()->id)
//                                ->with(['visits' => function($query) {
//                                    $lastMonth = Carbon::now()->subMonth()->toDateString();
//                                    $query->where('created_at', '>=', $lastMonth);
//                                }])
//                                ->get();
        $data['visitsByDay'] = Link::selectRaw('COUNT( * ) as `visits`, COUNT( DISTINCT unique_id ) as `unique_visits`, day(visits.created_at) as `day`')
                                ->join('visits', 'links.id', '=', 'link_id')
                                ->where('user_id', '=', auth()->user()->id)
                                ->whereYear('visits.created_at', '=', Carbon::now()->year)
                                ->whereMonth('visits.created_at', '=', Carbon::now()->month)
                                ->groupBy('day')
                                ->get();
        return view('dashboard.index' , $data);
    }

    public function show($link)
    {
        $data['link'] = Link::where('hash', '=', $link)->with('visits')->firstOrFail();
        $data['visits'] = [];

        foreach ($data['link']->visits->groupBy('city') as $city => $val) {
            $data['visits'][] = [
                'label' => $city . ': ' .count($val),
                'lat' => $val[0]->lat,
                'lng' => $val[0]->lng,
            ];
        }

        return view('dashboard.link', $data);
    }
}
