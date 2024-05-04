<?php

namespace App\Http\Controllers\layterms;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\manager\connectionManager;

class laytermsController extends Controller
{
    public $id;
    public $connection;

    public function __construct()
    {
        $this->connection = app(connectionManager::class)->getConnection('master');
    }

    public function getCodeCategory($code)
    {

        $db = DB::connection(
            app(connectionManager::class)->getConnection('search_engine')
        );

        $codes = $db->table('codes')
        ->join('categories', 'codes.category_id', '=', 'categories.id')
        ->select('categories.name')
        ->where('codes.code', $code)->get();

        if($codes->count())
        {
            return $codes->first()->name;
        }

        return null;

    }

    public function getCodeIcds($code)
    {

        $db = DB::connection($this->connection);

        $icds = $db->table('icd_cpt_crosswalk')
        ->where('cpt', $code)->limit(12)
        ->get(['icd as icd_code']);

        return $icds;
    }

    public function treatmentExtract(Request $request)
    {

        $code = $request->code;
        $db = DB::connection(
            app(connectionManager::class)->getConnection('master')
        );
        $extract = $db->table('rules_cpt_ranges_data');
        $data = $extract->orderBy('id')->get(['cpt_range', 'id']);

        $cpt_ranges = [];

        foreach($data as $range)
        {
            $cpt_ranges []= [
                'id' => $range->id,
                'range' => $range->cpt_range
            ];
        }

        foreach($cpt_ranges as $range)
        {
            $ranges = explode('-', $range['range']);
            $range_first = $ranges[0];
            $range_last = $ranges[1];

            if($code >= $range_first && $code <= $range_last)
            {
                $this->id = $range['id'];
                break;
            }
        }

        $response = $extract->where('id', $this->id)->get();

        return response()->json($response);

    }

    public function fetchSubCategoriesFromCodes(Request $request)
    {
        $codes = $request->codes;
        $db = DB::connection(
            app(connectionManager::class)->getConnection('master')
        );
        $table = $db->table('rules_categories_cpts');

        $i=0;
        $result = [];
        if($codes)
        {
            foreach($codes as $code)
            {
                $code = json_decode($code, true);
                $condition = $i == 0 ? 'where' : 'Orwhere';
                $table->$condition('code', $code);
                $i++;
            }
            $result = $table->get(['code', 'subcategory']);
        }

        return response()->json($result);
    }

}
