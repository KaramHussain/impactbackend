<?php

namespace App\Http\Controllers;

use App\order;
use App\Http\Controllers\Controller;
use App\Http\Resources\orderResource;
use Illuminate\Http\Request;

class OrdersController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function complete(order $order)
    {
        $order->update(['order_status' => 'complete']);
        return response()->json("Order completed");
    }

    public function getFilters()
    {
        return [];
    }

    public function index(Request $request)
    {
        $user = $request->user();
        return orderResource::collection(
            $user->order()
            ->filter($request)
            ->orderBy('created_at', 'DESC')
            ->paginate(12)
        );
    }

    public function show(Request $request)
    {
        $user = $request->user();
        $order = $user->order()->where('id', $request->id)->firstOrFail();
        return new orderResource($order);
    }

}
