<?php

namespace App\Http\Controllers\admin;

use DB;
use App\checkout;
use App\invoice;
use App\Http\Controllers\Controller;
use App\order;
use App\doctors\doctor;
use App\Http\Resources\claimsResource;

class reportsController extends Controller
{

    public function getCheckoutReport()
    {

        return response()->json(invoice::with([
            'order' => function($query) {
                $query->where('order_status', 'processing');
            },
            'order.user',
            'order.checkout',
            'order.insurance_plan'
        ])->latest()->get());


    }

    public function invoiceReport(invoice $invoice)
    {
        //DB::enableQueryLog();
        return response()->json($invoice->load([
            'order',
            'order.user',
            'order.user.address',
            'order.checkout',
            'order.insurance_plan'
        ]));

        // return (new claimsResource(
        //     $order
        // ));
        //return DB::getQueryLog();

    }

}
