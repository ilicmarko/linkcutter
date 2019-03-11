<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Plan;
use App\Feature;


class AdminController extends Controller
{
    public function index()
    {
        return view('admin.home');
    }

    public function plans() 
    {
        $data['features'] = Feature::all();
        $data['products'] = Product::all();
        $data['plans'] = Plan::with('features')->orderBy('order', 'asc')->get();

        return view('admin.plans', $data);
    }

    public function planEdit($plan)
    {
        $data = [];
        $data['plan'] = Plan::where('id', '=', $plan)->with('features')->firstOrFail();
        $data['features'] = Feature::all();

        return view('admin.plan-edit', $data);
    }

    public function products()
    {
        $data['products'] = Product::all();
        //$data['plans'] = Plan::orderBy('order', 'asc')->get();

        return view('admin.products', $data);
    }

    public function features()
    {
        $data['features'] = Feature::all();
        $data['plans'] = Plan::orderBy('order', 'asc')->get();

        return view('admin.features', $data);
    }

    public function orders()
    {
        return view('admin.orders');
    }

    public function users()
    {
        return view('admin.users');
    }
}
