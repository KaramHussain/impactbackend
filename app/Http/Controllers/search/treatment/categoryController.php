<?php

namespace App\Http\Controllers\search\treatment;

use App\Http\Controllers\Controller;
use App\search\Treatment\category;
use App\search\Treatment\children_term;
use Illuminate\Http\Request;

class categoryController extends Controller
{

    public function index()
    {
        return response()->json(category::all());
    }

    public function search($query)
    {
        return category::like($query)->get();
    }

    public function searchMultiple($words)
    {
        $category = category::query();
        $i=0;
        foreach($words as $word)
        {
            $condition = $i == 0 ? 'like' : 'OrLike';
            $category->{$condition}($word);
            $i++;
        }
        return $category->pluck('id');
    }

    public function search_categories_for_selected_term(Request $request)
    {
        return children_term::find($request->id)->category;
    }

}
