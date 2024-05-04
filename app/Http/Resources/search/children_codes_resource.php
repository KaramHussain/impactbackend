<?php

namespace App\Http\Resources\search;

use Illuminate\Http\Resources\Json\JsonResource;

class children_codes_resource extends JsonResource
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
            'term'            => $this->name,
            'part_id'         => $this->part_id,
            'category_id'     => $this->category_id,
            'sub_category_id' => $this->sub_category_id,
            'term_id'         => $this->term_id,
            'description'     => $this->description,
            'part'            => $this->part,
            'category'        => $this->category,
            'sub_category'    => $this->sub_category,
            'codes'           => $this->codes()->like($request->code)->get()
        ];
    }
}
