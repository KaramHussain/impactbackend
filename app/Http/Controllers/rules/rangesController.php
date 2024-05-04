<?php

namespace App\Http\Controllers\rules;

use App\Anatomy\traits\mappings\part_mappings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\rules\body_part;
use App\rules\part_code;
use App\rules\part_range;

class rangesController extends Controller
{
    use part_mappings;

    public function index(Request $request)
    {

        $part = $request->part;
        $subpart = $request->subpart;
        $category = $request->category;

        $parts = $this->part_mappings()[$part];

        $part_ids = body_part::whereIn('name', $parts)->get(['id']);

        $ranges = part_range::with('codes')
        ->whereIn('part_id', $part_ids)
        ->where('subpart_id', $subpart)
        ->where('category', $category)
        ->get();

        return response()->json($ranges);

    }

    public function fetch_code_ranges(Request $request)
    {

        $codes = (array) $request->codes;

        $codes = part_code::with('range')
        ->whereIn('code', $codes)
        ->where('code_type', 'cpt')
        ->get();

        return response()->json($codes);

    }

}
