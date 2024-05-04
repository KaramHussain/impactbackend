<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class orderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'order_id'       => $this->order_id,
            'order_status'   => $this->order_status,
            'total'          => $this->total,
            'created_at'     => $this->created_at,
            'insurance'      => $this->insurance_plan,
            'payment_method' => $this->paymentMethod,
            'user'           => $this->user,
            'checkout'       => $this->checkout
        ];
    }
}
