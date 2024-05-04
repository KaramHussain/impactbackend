<?php

namespace App\Http\Resources\search;

use Illuminate\Http\Resources\Json\JsonResource;

class code_resource extends JsonResource
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
            'id'              => $this->id,
            'code'            => $this->code,
            'frequency'       => $this->frequency,
            'gender'          => $this->gender,
            'min_age'         => $this->min_age,
            'max_age'         => $this->max_age,
            'category_id'     => $this->category_id,
            'sub_category_id' => $this->sub_category_id,
            'children'        => $this->children_term
        ];
    }

}
