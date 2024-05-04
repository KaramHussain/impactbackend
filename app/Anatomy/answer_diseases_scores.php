<?php

namespace App\Anatomy;

use App\Anatomy\anatomy;

class answer_diseases_scores extends anatomy
{

	//model table
    protected $table = 'answer_diseases_scores';

    public $timestamps = false;


	public function answer()
	{
		return $this->belongsTo(answer::class);
	}
}
