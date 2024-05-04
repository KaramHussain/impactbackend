<?php

namespace App\Http\Controllers\search\treatment;

use App\Http\Controllers\search\searchController;
use App\search\Treatment\children_term;
use App\search\Treatment\code;

class codesController extends searchController
{

    public function search_codes($query)
    {
        return code::like($query)->get(['children_term_id']);
    }

    public function search_for_codes($query, $category)
    {

        $code_ids = $this->search_codes($query)->pluck('children_term_id')->unique()->toArray();
        $children_terms = children_term::groupBy('name')->orderBy('name');

        $categories = $children_terms
        ->whereCategory(0)
        ->whereIn('id', $code_ids)
        ->pluck('category_id')
        ->unique();

        $children_terms = $children_terms
        ->whereCategory($category)
        ->limit($this->limit)
        ->find($code_ids);

        return ['data' => $children_terms, 'table' => 'children_terms', 'categories' => $categories];

    }

    public function getCodeUniqueChildTerms($children_terms)
    {
        $unique_terms = [];
        foreach($children_terms as $term)
        {
            foreach($term as $attrs)
            {
                if(count($unique_terms) >= 8)
                {
                    break;
                }
                if(!in_array($attrs->id, array_column($unique_terms, 'id')))
                {
                    $unique_terms []= $this->formattedAttributes($attrs);
                }
            }
        }
        return $unique_terms;
    }

    public function formattedAttributes($attrs)
    {
        return [
            'id'   => $attrs->id,
            'term' => $attrs->name,
            'description' => $attrs->description
        ];
    }

    public function getCodeTerms($codes)
    {
        $children_terms = [];
        foreach($codes as $code)
        {
            $children_terms []= $code->terms;
        }
        return $children_terms;
    }

}
