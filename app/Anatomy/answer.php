<?php

namespace App\Anatomy;

use App\Anatomy\anatomy;
use App\Anatomy\question;

class answer extends anatomy
{

    public function question()
    {
    	return $this->belongsTo(question::class);
    }

    public function diseases()
    {
        return $this->hasMany(disease::class)->withPivot('score');
    }

}
