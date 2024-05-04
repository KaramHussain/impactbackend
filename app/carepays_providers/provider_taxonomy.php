<?php

namespace App\carepays_providers;

use Illuminate\Database\Eloquent\Model;

class provider_taxonomy extends Model
{
    protected $table = 'provider_taxonomies';
    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'code',
        'grouping',
        'classification',
        'specialization',
        'effective_date',
        'deactivation_date',
        'last_modified_date',
        'display_name'
    ];
}
