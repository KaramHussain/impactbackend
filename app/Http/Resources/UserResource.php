<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'middle_name' => $this->middle_name,
            'email' => $this->email,
            'address' => $this->address,
            'gender' => $this->gender,
            'dob' => rtrim($this->dob, " 00:00:00"),
            'phone' => $this->phone,
            'alt_phone' => $this->alt_phone,
            'alt_email' => $this->alt_email,
            'city' => $this->city,
            'state' => $this->state,
            'address2' => $this->address2,
            'language' => $this->language,
            'zipcode' => $this->zipcode,
            'security_question1' => $this->security_question1,
            'security_answer1' => $this->security_answer1,
            'security_question2' => $this->security_question2,
            'security_answer2' => $this->security_answer2,
            'user_image'       => $this->image

        ];
    }
}
