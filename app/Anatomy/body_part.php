<?php

namespace App\Anatomy;

use DB;
use App\Anatomy\anatomy;
use App\Anatomy\{sub_part, disease, symptom, gender};

class body_part extends anatomy
{

    public function subparts()
    {
        return $this->hasMany(sub_part::class);
    }

    public function diseases()
    {
        return $this->belongsToMany(disease::class, 'symptom_all_diseases');
    }

    public function symptoms()
    {
        return $this->belongsToMany(symptom::class, 'symptom_all_diseases', 'part_id');
    }

    public function gender()
    {
        return $this->belongsToMany(gender::class, 'symptom_all_diseases');
    }

    public function fetch($id)
    {
    	return $this->where('id', $id)->first()->name;
    }

    public function fetchPartIdsFromNames($names)
    {

        $db = DB::connection($this->connection);
        $body_parts = $db->table('body_parts');

        for($i=0; $i<count($names); $i++)
        {
            $name = $names[$i];
            $condition = $i==0 ? 'where' : 'Orwhere';
            $body_parts->$condition('name', $name);
        }
        return $body_parts->get(['id']);
    }

    //getId from part name and view
    public function getId($parts)
	{

       return $this::where(function($query) use ($parts) {
            $i=0;
            foreach($parts as $part) {
                $condition = $i==0 ? 'where' : 'Orwhere';
                $query->$condition('name', $part);
                $i++;
            }
        })->get(['id']);
    }

}
