<?php

namespace App\Http\Controllers\search\treatment;

use App\Http\Controllers\search\searchController;
use App\Http\Controllers\search\treatment\termsController;
use App\search\Treatment\children_term;

use App\Http\Controllers\search\treatment\{
    partsController,
    subcategoryController,
    categoryController,
    synonymsController
};

class childrenTermsController extends searchController
{

    public function search_in_parts_or_categories_for_children(array $words, $category)
    {

        $category_ids = (new categoryController)->searchMultiple($words);
        $part_ids = (new partsController)->searchMultiple($words);

        $children_terms = children_term::selectRaw('children_terms.*')
        ->joinParts('children_term')
        ->whereInPartIds('', $part_ids)
        ->groupBy('name')
        ->orderBy('name');

        $categories = $children_terms->whereCategory(0)
                    ->pluck('category_id')
                    ->unique();

        $children_terms = $children_terms->whereIn('category_id', $category_ids)
        ->limit($this->limit)
        ->get();

        return ['data' => $children_terms, 'table' => 'children_terms', 'categories' => $categories];

    }

    public function search_in_parts_or_subcategories_for_children(array $words, $category)
    {

        $subcategory_ids = (new subcategoryController)->searchMultiple($words);

        $part_ids = (new partsController)->searchMultiple($words);

        $children_terms = children_term::selectRaw('children_terms.*')
        ->joinParts('children_term')
        ->whereInPartIds('', $part_ids)
        ->groupBy('name')
        ->orderBy('name');

        $categories = $children_terms->whereCategory(0)
                    ->pluck('category_id')
                    ->unique();

        $children_terms = $children_terms->whereIn('sub_category_id', $subcategory_ids)
        ->whereCategory($category)
        ->limit($this->limit)
        ->get();

        return ['data' => $children_terms, 'table' => 'children_terms', 'categories' => $categories];

    }

    public function search_in_parts_or_terms_for_children($words, $category)
    {

        $term_ids = (new termsController)->searchMultiple($words);
        $part_ids = (new partsController)->searchMultiple($words);


        $children_terms = children_term::selectRaw('children_terms.*')
        ->joinTerms()
        ->whereInTermIds(null, $term_ids)
        ->joinParts('children_term')
        ->whereInPartIds(null, $part_ids)
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

    public function search_in_parts_or_children($words, $category)
    {

        $part_ids = (new partsController)->searchMultiple($words);

        $children_terms = children_term::selectRaw('children_terms.*')
        ->joinParts('children_term')
        ->whereInPartIds(null, $part_ids)
        ->whereChildLikes($words)
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

    public function search_both_in_child_terms_or_synonyms($words, $category)
    {

        $first_word = $words[0];

        $children_terms = children_term::whereChildLikes($words);

        $children_terms = $this->attachIdsFromSynonyms($children_terms, $words);

        $children_terms = $children_terms
            ->groupBy('name')
            ->orderByFirstWord($first_word);

        $categories = $children_terms->whereCategory(0)
                ->pluck('category_id')
                ->unique();

        $children_terms = $children_terms
            ->whereCategory($category)
            ->limit($this->limit)
            ->get();

        return ['data' => $children_terms, 'table' => 'children_terms', 'categories' => $categories];
    }

    public function attachIdsFromSynonyms($children_terms, $words)
    {

        $synonym_ids  = (new synonymsController)->searchMultiple($words, 'children_term')->toArray();

        return !empty($synonym_ids) ? $children_terms->whereIn('id', $synonym_ids) : $children_terms;
    }

    public function searchMultiple($words)
    {
        $i=0;
        $child = children_term::query();
        foreach($words as $word)
        {
            $condition = $i == 0 ? 'like' : 'OrLike';
            $child->{$condition}($word);
            $i++;
        }
        return $child->get(['id']);
    }

}
