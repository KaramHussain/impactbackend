<?php

namespace App\Anatomy;

use App\Anatomt\disease;
use App\Anatomt\symptom;
use App\Anatomt\gender;
use App\Anatomt\sub_parts;
use App\Anatomy\anatomy;

class symptom_all_diseases extends anatomy
{

    public $timestamps = false;
    protected $table = 'symptom_all_diseases';

    public function fetchRecord($data)
    {
        $data_scores = [];

        foreach ($data as $d)
        {
            $data_scores []= $d->disease_score;
        }

        $data_store = [];
        //fetch Diseases
        $disease_obj = new disease;
        $diseases = $disease_obj->fetchDiseases($data);

        foreach($data as $record)
        {

            //fetch Symptom
            $symptom_id = $record->symptom_id;

            $symptom_obj = new symptom;
            $symptom = $symptom_obj->fetchSymptom($symptom_id);

            //fetch Gender
            $gender_id  = $record->gender_id;
            $gender_obj = new gender;
            $gender = $gender_obj->fetch($gender_id);
            //fetch Part
            $part_id    = $record->part_id;
            $part_obj = new sub_parts;
            $part = $part_obj->fetch($part_id);

            $data_store []= ['symptom' => $symptom, 'diseases'=>$diseases, 'gender'=>$gender, 'part' => $part, 'scores' => $data_scores];

        }
        return $data_store;
    }
}
