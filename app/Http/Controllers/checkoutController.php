<?php

namespace App\Http\Controllers;

use App\{order, cart};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class checkoutController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function create(Request $request)
    {

        $auth = $request->user();
        $insurance = $request->has('insurance') && $request->insurance != null ? $request->insurance : null;

        $validator = $this->validateOrder($request);

        if($validator->fails())
        {
            return response()->json(['errors' => $validator->getMessageBag()], 422);
        }

        //getCartItems

        $items = $auth->cart;

        if(!$items->count())
        {
            return response()->json(['errors' => $validator->setCustomMessages(['cart' => 'cart is empty'])], 422);
        }
        //create an order
        $order = (new order)->generate(
            $auth,
            $request->payment_method_id,
            $insurance
        );

        //create auth order checkout
        foreach($items as $item)
        {
            $order->checkout()->create([
                'user_id'             => $auth->id,
                'doctor_id'           => $item->doctor_id,
                'cpt'                 => $item->cpt,
                'date_of_appointment' => $item->date_of_appointment,
                'time_of_appointment' => $item->time_of_appointment,
                'date_of_booking'     => now(),
                'average_cost'        => $item->average_cost,
                'purchase_cost'       => $item->purchase_cost,
                'saved_cost'          => $item->saved_cost,
                'negotiated_cost'     => $item->negotiated_cost,
                'anesthesia_fee'      => $item->anesthesia_fee,
                'facility_expenses'   => $item->facility_expenses,
                'hidden_charges'      => $item->hidden_charges,
                'evob_charges'        => $item->add_evob_charges ? $item->evob_charges : null,
                'charges_details'     => $item->charges_details,
                'category'            => $item->category
            ]);
        }

        //create an inoice

        $order->invoices()->create([
            'created_at' => now(),
            'total'      => $order->total()
        ]);

        //delete all cart items
        cart::where('user_id', $auth->id)->delete();

        return response()->json(200);

    }

    public function validateOrder(Request $request)
    {
        $Validator = Validator::make($request->all(), [
                'payment_method_id' => [
                'required',
                Rule::exists('payment_methods', 'id')->where(function($builder) use($request) {
                    $builder->where('user_id', $request->user()->id);
                }),
                'first_name' => 'required',
                'last_name'  => 'required',
                'email'      => ['required','email'],
                'phone'      => ['required', 'numeric'],
                'address'    => 'required',
                'address2'   => 'required',
                'city'       => ['required', 'exists:cities,id'],
                'state'      => ['required', 'exists:states,id']
            ]
        ]);
        return $Validator;
    }
}
