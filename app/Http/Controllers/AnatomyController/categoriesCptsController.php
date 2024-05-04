<?php

namespace App\Http\Controllers\AnatomyController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class categoriesCptsController extends Controller
{

    public function fetch($rules, $category)
    {
        $crosswalk = $rules->table('categories_cpts_crosswalk');
        return $crosswalk->where('name', $category)
        ->pluck('cpt')->toArray();
    }
}
