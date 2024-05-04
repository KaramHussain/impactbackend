<?php

namespace App\Http\Resources\search;

use Illuminate\Http\Resources\Json\JsonResource;

class children_term_resource extends JsonResource
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
            'description'     => $this->description,
            'category_id'     => $this->category_id
        ];
    }

}
