<?php

namespace App\Http\Resources\search;

use Illuminate\Http\Resources\Json\JsonResource;

class term_resource extends JsonResource
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
            'id'              => $this->term_id,
            'term'            => optional($this->associated_child_term)->name,
            'part_id'         => $this->part_id,
            'category_id'     => $this->category_id,
            'sub_category_id' => $this->sub_category_id,
            'description'     => $this->description
        ];
    }
}
