<?php

namespace App\Http\Controllers\search\treatment;

use App\Http\Controllers\Controller;
use App\search\Treatment\part;

class partsController extends Controller
{

    public function search($query)
    {
        return part::like($query)->get(['id']);
    }

    public function searchMultiple($words)
    {
        $i=0;
        $part = part::query();
        foreach($words as $word)
        {
            $condition = $i == 0 ? 'like' : 'OrLike';
            $part->{$condition}($word);
            $i++;
        }
        return $part->pluck('id');
    }
}
