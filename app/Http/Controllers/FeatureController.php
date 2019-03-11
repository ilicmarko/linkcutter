<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feature;

class FeatureController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required|string',
            'description'   => 'required|string',
            'plans.*'       => 'distinct|string|exists:plans,id'
        ]);

        $feature = Feature::create([
            'name'          => request('name'),
            'description'   => request('description'),
        ]);

        $feature->plans()->attach(request('plans'));

        $slug = $feature->slug;
        $msg = "You have successfully added a `{$feature->name}` feature. <br>
                Here your slug <strong>{$slug}</strong>, you will need for routing";

        return redirect(route('admin.features'))->with('alert_msg', $msg);

    }

    public function destroy(Feature $feature)
    {
        if ($feature->delete()) {
            session()->flash('alert_msg', 'Feature deleted successfully.');
        } else {
            session()->flash('alert_msg', 'Unable to delete feature. Please try again!');
        }

        return back();
    }
}
