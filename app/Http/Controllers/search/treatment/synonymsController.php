<?php

namespace App\Http\Controllers\search\treatment;

use App\Http\Controllers\Controller;
use App\search\Treatment\synonym;

class synonymsController extends Controller
{
    public function search($query, $related = 'term')
    {
        return synonym::like($query, $related)->pluck('related_id');
    }

    public function searchMultiple($words, $type = 'term')
    {
        $i=0;
        $synonym = synonym::query();
        foreach($words as $word)
        {
            $condition = $i == 0 ? 'like' : 'OrLike';
            $synonym->{$condition}($word, $type);
            $i++;
        }
        return $synonym->pluck('related_id');
    }
}
