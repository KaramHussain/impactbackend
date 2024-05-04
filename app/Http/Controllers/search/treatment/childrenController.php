<?php

namespace App\Http\Controllers\search\treatment;

use App\Http\Controllers\search\searchController;
use App\search\Treatment\children_term;

use App\Http\Controllers\search\treatment\{
    partsController,
    subcategoryController,
    categoryController,
    synonymsController
};
use App\Http\Resources\search\code_resource;
use App\search\Treatment\part;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class childrenController extends searchController
{

    public function searchAll($query, $category)
    {

        $children_terms = children_term::like($query);

        $categories = $children_terms->whereCategory(0)
                    ->pluck('category_id')
                    ->unique();

        $children_terms = $children_terms->whereCategory($category)
        ->limit($this->limit)
        ->get();

        return ['data' => $children_terms, 'table' => 'children_terms', 'categories' => $categories];

    }

    public function search_for_synonyms($query, $category)
    {

        $ids = (new synonymsController)->search($query, 'children_term');

        $children_terms = children_term::whereIn('id', $ids);
        
        $categories = $children_terms->whereCategory(0)
                    ->pluck('category_id')
                    ->unique();
        $children_terms = $children_terms->whereCategory($category)
        ->limit($this->limit)
        ->get();

        return ['data' => $children_terms, 'table' => 'children_terms', 'categories' => $categories];

    }

    public function search_for_parts($query, $category)
    {

        $parts = (new partsController)->search($query);

        $children_terms = children_term::selectRaw('children_terms.*')
        ->joinParts('children_term')
        ->whereInPartIds($query, $parts)
        ->groupBy('name');

        $categories = $children_terms->whereCategory(0)
                    ->pluck('category_id')
                    ->unique();

        $children_terms = $children_terms->whereCategory($category)
        ->limit($this->limit)
        ->get();

        return ['data' => $children_terms, 'table' => 'children_terms', 'categories' => $categories];

    }

    public function search_for_categories($query, $category)
    {

        $category = (new categoryController)->search($query)->first();

        if(!$category) return ['data' => []];

        $children_terms = new Collection;
        if(!empty($category->children_terms))
        {
            $children_terms = $category->children_terms()
            ->groupBy('name');
        }

        $categories = $children_terms->whereCategory(0)
                    ->pluck('category_id')
                    ->unique();

        $children_terms = $children_terms->get();                

        return ['data' => $children_terms, 'table' => 'children_terms', 'categories' => $categories];

    }

    public function search_for_subcategories($query, $category)
    {

        $subcategories = (new subcategoryController)->search($query);

        $children_terms = children_term::whereIn('sub_category_id', $subcategories);

        $categories = $children_terms->whereCategory(0)
                    ->pluck('category_id')
                    ->unique();            

        $children_terms = $children_terms
        ->whereCategory($category)
        ->limit($this->limit)
        ->get();

        return ['data' => $children_terms, 'table' => 'children_terms', 'categories' => $categories];

    }

    public function fetch_terms_from_category_and_bodypart(Request $request)
    {

        $category = $request->category;
        $part = $request->part;
        $age  = $request->age;
        $gender = $request->gender;

        $part = $this->getPart($part);

        $codes = $part
                ->codes()
            //     ->load('children_term')
            //     ->makeHidden('icds');

            // return $codes;

            ->whereAgeBetween($age)
            ->gender($gender)
            ->where('category_id', $category)
            ->orderByFrequency()
            ->groupBy('code')
            ->get()
            ->makeHidden('icds');

        return code_resource::collection($codes);

    }

    function find_treatment_and_set_codes(Request $request)
    {
        $treatment = $request->treatment;
        $age = $request->age;
        $gender = $request->gender;
        $part = $request->part;

        $term = children_term::find($treatment);
        if(!$term) return [];

        $codes = $term->codes()
        ->whereAgeBetween($age)
        ->gender($gender)
        ->orderByFrequency()
        ->get();

        $cptCodes = [];

        foreach($codes as $code)
        {
            $cptCodes []= ['codes' => $code];
        }

        return response()->json($cptCodes);

    }

    public function getPart($part)
    {
        return part::where('name', $part)->first();
    }

    public function get_consultant_terms($category)
    {
        $children_terms = children_term::where('category_id', $category)->get();
        return ['data' => $children_terms, 'table' => 'children_terms'];
    }


}
