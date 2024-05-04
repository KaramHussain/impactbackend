<?php

namespace App\Http\Controllers\search\treatment;

use App\Http\Controllers\Controller;
use App\search\Treatment\sub_category;

class subcategoryController extends Controller
{

    public function search($query)
    {
        return sub_category::like($query)->pluck('id');
    }

    public function searchMultiple($words)
    {
        $i=0;
        $subcategory = sub_category::query();
        foreach($words as $word)
        {
            $condition = $i == 0 ? 'like' : 'OrLike';
            $subcategory->{$condition}($word);
            $i++;
        }
        return $subcategory->pluck('id');
    }

}
