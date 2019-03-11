<?php

namespace App\Http\Controllers;

use App\Plan;
use Illuminate\Http\Request;
use DB;
use Stripe\Stripe;

class PlanController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id'    => 'required|string',
            'name'          => 'required|string|unique:plans,id',
            'amount'        => 'required|integer',
            'duration'      => 'required|integer',
            'interval'      => 'required',
            'features.*'    => 'distinct|integer|exists:features,id',
            'order_dir'     => 'integer',
            'order'         => 'integer',
        ]);

        $name = request('name');
        $interval = request('interval');
        $orderDirection = request('order_dir');
        $order = request('order') ? request('order') + $orderDirection : 1;

        if ($orderDirection == 1) {
            Plan::where('order', '>=', $order)->update([
                'order' => DB::raw('`order` + 1'),
                'updated_at' => DB::raw('NOW()'),
            ]);
        } elseif ($orderDirection == -1) {
            Plan::where('order', '<=', $order)->update([
                'order' => DB::raw('`order` - 1'),
                'updated_at' => DB::raw('NOW()'),
            ]);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $planStripe = \Stripe\Plan::create([
            'currency'          => 'usd',
            'interval'          => $interval,
            'interval_count'    => request('duration'),
            'product'           => request('product_id'),
            'nickname'          => $name,
            'amount'            => request('amount') * 100, // The amount in cents
        ]);

        $plan = Plan::create([
            'id' => $planStripe->id,
            'name' => $name,
            'amount' => request('amount'),
            'product_id'           => request('product_id'),
            'interval' => $interval,
            'interval_count' => request('duration'),
            'order' => $order,
        ]);

        $plan->features()->attach(request('features'));

        return redirect(route('admin.plans'))->with('alert_msg', "You have successfully added a `{$name}` plan.");
    }

    public function destroy(Plan $plan)
    {
        if ($plan->delete()) {
            session()->flash('alert_msg', 'Plan deleted successfully');
        } else {
            session()->flash('alert_msg', 'Unable to delete plan. Please try again');
        }

        return back();
    }

    public function edit(Plan $plan)
    {
        // Not sure if I should implement this, see later.
    }

    public function subscribe(Request $request)
    {
        $user = \Auth::user();
        $stripeToken = request('stripeToken');
        $planID = request('planID');
        $plan = Plan::find($planID);

        $user->newSubscription('default', $planID)->create($stripeToken);

        return redirect()->route('home')->with('alert_msg', "Thank you for subscribing to our `{$plan->name}` plan");
    }

    public function change(Request $request)
    {
        $user = \Auth::user();
        $planID = request('planID');
        $oldPlan = $user->subscriptions->first();

        $user->subscription('default')->swap($planID);

        return redirect()->route('home')->with('alert_msg', "You have successfully upgrade to `{$oldPlan->name}` plan");
    }
}
