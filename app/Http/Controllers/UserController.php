<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Stripe\Stripe;

class UserController extends Controller
{
    public function view()
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $user = Auth::user();
            if ($user->subscribed()) {
                $invoices = $user->invoices();
            }


        } catch (\Exception $ex) {
            return $ex->getMessage();
        }

        return view('user.edit', compact('invoices'));
    }

    public function edit(Request $request)
    {
        $this->validate($request, [
           'name' => 'nullable|string',
           'password' => 'nullable|string'
        ]);
        $msg = 'Changes applied';
        $user = Auth::user();

        if ($request->has('name')) {
           $user->name = request('name');
        }

        if ($request->has('password')) {
            $user->password = bcrypt(request('password'));
        }

        $user->save();

        return back()->with('success_msg', $msg);
    }

    public function invoice($invoice_id)
    {

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $user = Auth::user();

            return $user->downloadInvoice($invoice_id, [
                'vendor'  => 'LinkCutter',
                'product' => 'Monthly subscription',
            ]);

        } catch (\Exception $ex) {
            return $ex->getMessage();
        }

    }
}
