<?php

namespace App\Http\Controllers\search\treatment;

use App\search\Treatment\icd;
use App\search\Treatment\children_term;
use App\Http\Controllers\search\searchController;

class icdsController extends searchController
{

    public function search_codes($query)
    {
        return icd::like($query)->get(['children_term_id']);
    }

    public function search_icds($query, $category)
    {
        $children_ids = $this->search_codes($query)->pluck('children_term_id')->unique()->toArray();
        $children_terms = children_term::groupBy('name')->orderBy('name');

        $categories = $children_terms
        ->whereCategory(0)
        ->whereIn('id', $children_ids)
        ->pluck('category_id')
        ->unique();

        $children_terms = $children_terms
        ->whereCategory($category)
        ->limit($this->limit)
        ->find($children_ids);

        return ['data' => $children_terms, 'table' => 'children_terms', 'categories' => $categories];

    }

}
