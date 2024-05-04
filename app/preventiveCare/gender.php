<?php

namespace App\preventiveCare;

use App\preventiveCare\preventiveCare;

class gender extends preventiveCare
{
    protected $table = 'gender';
    protected $guarded = ['_token'];
}
