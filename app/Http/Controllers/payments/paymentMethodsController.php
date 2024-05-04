<?php

namespace App\Http\Controllers\payments;

use Illuminate\Http\Request;
use App\paymentGateways\gateway;
use App\Http\Controllers\Controller;
use App\Http\Requests\payments\paymentMethodStoreRequest;
use App\Http\Resources\paymentResource;

class paymentMethodsController extends Controller
{
    public function __construct(gateway $gateway)
    {
        $this->middleware(['auth:api']);
        $this->gateway = $gateway;
    }

    public function index(Request $request)
    {
        $userPayments = paymentResource::collection(
            $request->user()->paymentMethods
        );
        return $userPayments;
    }

    public function store(paymentMethodStoreRequest $request)
    {
        $card = $this->gateway->withUser($request->user())
                ->createCustomer()
                ->addCard($request->token);
        return new paymentResource($card);
    }

}
