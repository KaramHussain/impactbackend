<?php

namespace App\Anatomy;

use DB;
use App\Anatomy\{body_part, sub_part, answer, symptom, gender};
use App\Anatomy\anatomy;

class disease extends anatomy
{

    protected $fillable = ['disease', 'symptom_id', 'score'];

    public function answers()
    {
        return $this->belongsToMany(answer::class, 'answer_diseases_scores')->withPivot('score');
    }

    public function symptoms()
    {
        return $this->belongsToMany(symptom::class, 'symptom_all_diseases')->withPivot('disease_score');
    }

    public function gender()
    {
        return $this->belongsToMany(gender::class, 'symptom_all_diseases')->withPivot('disease_score');
    }

    public function parts()
    {
        return $this->belongsToMany(body_part::class, 'symptom_all_diseases')->withPivot('disease_score');
    }

    public function subparts()
    {
        return $this->belongsToMany(sub_part::class, 'symptom_all_diseases')->withPivot('disease_score');
    }

    public function fetchDiseases($data)
    {
    	$i=0;
    	$table = DB::table('diseases');
    	foreach($data as $disease_data)
    	{
    		$condition = $i==0?'where':'orWhere';
    		$id = $disease_data->disease_id;
    		$table->$condition('id', '=', $id);
    		$i++;
    	}
    	$data = $table->get();
    	return $data;
    }

    public function fetch($id)
    {
        return $this->where('id', $id)->first()->disease;
    }

}
