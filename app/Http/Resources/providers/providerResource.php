<?php

namespace App\Http\Resources\providers;

use Illuminate\Http\Resources\Json\JsonResource;

class providerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $created_by = null;
        return  [
            'id'                   => $this->id,
            'name'                 => $this->name,
            'email'                => $this->email,
            'permissions'          => $this->permissionNames(),
            'roles'                => $this->roles->first(),
            'npi'                  => $this->npi,
            'is_doctor'            => $this->is_doctor,
            'created_at'           => $this->created_at,
            'practise_id'          => optional($this->practise)->id,
            'practise'             => $this->hasPermission('view-company') 
                                      ? $this->practise 
                                      : ['name' => $this->practise->name],
            'created_by'           => $this->created_by ? $created_by = $this->find($this->created_by) : null,
            'created_by_role'      => $created_by ? $created_by->roles->first()->name : null,
            'image'                => $this->providerImage,
            'formattedPermissions' => $this->allPermissions(),
            'payers'               => $this->payers(),
            'remark_codes'         => $this->remark_codes,
            'verified'             => $this->verified,
            'active'               => $this->active,
            'assigned_claims'      => $this->get_claims(),
            'submitted_claims'     => $this->get_claims('submitted') 
        ];
    }

    public function get_claims($status = 'assigned') 
    {
        return $this->claims()->where('status', $status)->groupBy('status')->count(); 
    }

}
