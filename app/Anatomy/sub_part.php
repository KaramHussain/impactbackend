<?php

namespace App\Anatomy;

use App\Anatomy\anatomy;

class sub_part extends anatomy
{

	protected $table = 'sub_parts';
    protected $fillables = ['part'];

    public function parts()
    {
        return $this->belongsTo(body_part::class);
    }

    public function fetch($ids)
    {

        $sub_parts = $this::where(function($query) use ($ids) {
            $i=0;
            foreach($ids as $id)
            {
                $condition = $i == 0 ? 'where' : 'Orwhere';
                $query->$condition('parent_id', $id);
                $i++;
            }
        });


		return $sub_parts->get();
    }

}
