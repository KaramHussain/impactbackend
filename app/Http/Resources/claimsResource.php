<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class claimsResource extends JsonResource
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
            'id' => $this->id,
            'order_id' => $this->order_id,
            'user_id' => $this->user_id,
            'insurance' => $this->insurance_plan,
            'user'      => $this->user,
            'checkout'  => $this->checkout
        ];
    }
}
