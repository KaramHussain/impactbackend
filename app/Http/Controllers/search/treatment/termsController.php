<?php

namespace App\Http\Controllers\search\treatment;

use App\search\Treatment\term;
use App\Http\Controllers\search\searchController;
use App\Http\Controllers\search\treatment\traits\uniqueTerms;
use App\search\Treatment\children_term;

class termsController extends searchController
{
    use uniqueTerms;

    public function searchAll($query, $category)
    {
        $term_ids = term::like($query)->pluck('id');

        $children_terms = children_term::selectRaw('children_terms.*')
        ->joinTerms()
        ->whereInTermIds($query, $term_ids)
        ->groupBy('name')
        ->orderBy('name');

        $categories = $children_terms->whereCategory(0)
                    ->pluck('category_id')
                    ->unique();

        $children_terms = $children_terms
        ->whereCategory($category)
        ->limit($this->limit)
        ->get();

        return ['data' => $children_terms, 'table' => 'children_terms', 'categories' => $categories];
    }

    public function search_terms_from_synonyms($query, $category)
    {

        $term_ids = (new synonymsController)->search($query);

        $children_terms = children_term::selectRaw('children_terms.*')
        ->joinTerms()
        ->whereInTermIds($query, $term_ids)
        ->groupBy('name')
        ->orderBy('name');

        $categories = $children_terms->whereCategory(0)
                    ->pluck('category_id')
                    ->unique();
        
        $children_terms = $children_terms->whereCategory($category)            
        ->limit($this->limit)
        ->get();

        return ['data' => $children_terms, 'table' => 'children_terms', 'categories' => $categories];

    }

    public function searchMultiple($words)
    {
        $i=0;
        $term = term::query();
        foreach($words as $word)
        {
            $condition = $i == 0 ? 'like' : 'OrLike';
            $term->{$condition}($word);
            $i++;
        }
        return $term->pluck('id');
    }

    public function search_both_in_terms_or_synonyms($words, $category)
    {

        $term_ids    = $this->searchMultiple($words)->toArray();
        $synonym_ids = (new synonymsController)->searchMultiple($words)->toArray();

        $term_ids = array_unique(array_merge($term_ids, $synonym_ids));

        $children_terms =
        children_term::selectRaw('children_terms.*')
        ->joinTerms()
        ->whereInTermIds(null, $term_ids)
        ->groupBy('name')
        ->orderBy('name');

        $categories = $children_terms->whereCategory(0)
                    ->pluck('category_id')
                    ->unique();
        
        $children_terms = $children_terms->whereCategory($category)            
        ->limit($this->limit)
        ->get();

        return ['data' => $children_terms, 'table' => 'children_terms', 'categories' => $categories];

    }

}
