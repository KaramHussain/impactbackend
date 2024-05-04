<?php

namespace App\filters\doctors;
use App\filters\filtering;
use App\doctors\doctor;

use Illuminate\Database\Eloquent\Builder;

class credsFilter extends filtering
{

    public function mappings()
    {
       $creds = array_filter(doctor::pluck('credentials')->unique()->toArray());
       $creds_assoc = [];

       foreach($creds as $cred)
       {
           $creds_assoc[$cred] = $cred;
       }
       return $creds_assoc;
    }

    public function filter(Builder $builder, $value)
    {

        $value = $this->resolveFiltervalue($value);

        if($value == null)
        {
            return $builder;
        }
        return $builder->where('credentials', $value);
    }
}
