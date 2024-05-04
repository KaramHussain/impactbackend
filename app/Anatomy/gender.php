<?php

namespace App\Anatomy;

use App\Anatomy\anatomy;

class gender extends anatomy
{

    public $timestamps = false;

    public function fetch($id)
    {
    	return $this->where('id', $id)->first()->gender;
    }
}
