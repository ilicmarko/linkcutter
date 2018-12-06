<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Links;
use App\Tracked;
use App\Visitors;

class Dashboard extends Controller
{
    public function view($hash) {

        $info = Tracked::where('trackeds.hash', '=', $hash)
                       ->join('links', 'link_id', '=', 'links.id')
                       ->first();
        if ($info === null) {
            return redirect('/');
        }
        // Moze da se gurne sve u jedan upit, ali ovako je 'elegantnije'
        $visitors = Visitors::where('link_id', '=', $info->link_id)->get();

        $chart_data = [];
        foreach($visitors->groupBy('country_code') as $key => $code) {
            $chart_data[] = [$key, $code->count()];
        }
        
        $data = [
            'url'           => $info->link,
            'short_url'     => url('/r/' . $info->hash),
            'email'         => $info->email,
            'visitors'      => $visitors,
            'chart_data'    => $chart_data,
        ];
        return view('dashboard', $data);
    }
}
