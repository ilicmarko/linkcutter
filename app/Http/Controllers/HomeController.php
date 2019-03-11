<?php

namespace App\Http\Controllers;

use App\Feature;
use App\Plan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['features'] = Feature::all();
        $data['plans'] = Plan::with('features')->orderBy('order', 'asc')->get();

        return view('home', $data);
    }
}
