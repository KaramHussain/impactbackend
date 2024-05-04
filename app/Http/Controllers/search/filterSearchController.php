<?php

namespace App\Http\Controllers\search;

use Illuminate\Http\Request;
use App\search\Treatment\part;
use App\manager\connectionManager;
use App\Http\Controllers\Controller;
use App\Http\Controllers\search\treatment\treatment;
use App\search\Treatment\code;

class filterSearchController extends Controller
{
    protected $connection;

    public function __construct()
    {
        $this->connection = app(connectionManager::class)->getConnection('search_engine');
    }

    public function filter_search(Request $request)
    {
        $part     = $request->part;
        $term     = $request->term;
        $category = $request->category;
        $codes    = $request->codes;

        //$part = $this->getPart($part);

        //$terms = $this->getTermsForSearchTerm($term, $category);

        //$filtered_terms = $this->getFilteredTerms($terms, $part);

        //$data = $this->extractCodesFromTerms($filtered_terms);

        $data = $this->extractCodesForPart($codes, $part);

        return response()->json($data);
    }

    public function extractCodesForPart($codes, $part)
    {
        $cptCodes = [];
        foreach($codes as $code)
        {
            $code = code::where('code', $code)->first();
            $parts = $code->parts->toArray();

            if(in_array($part, array_column($parts, 'id')))
            {
                $cptCodes []= ['codes' => $code];
            }

        }
        return $cptCodes;
    }

    public function extractCodesFromTerms($terms)
    {
        $cptCodes = [];
        foreach($terms as $term)
        {
            foreach($term->codes as $code)
            {
                $cptCodes []= ['codes' => $code, 'parts' => $code->parts];
            }
        }
        return $cptCodes;
    }

    public function getPart($part)
    {
        return part::where('name', $part)->first();
    }

    public function getTermsForSearchTerm($term, $category)
    {
        $treatment = new treatment;
        $queries = explode(' ', $term);
        $search_words = (new searchController)->exclude_stop_word($queries);
        return $treatment->get($search_words, $term, $category)['data'];
    }

    public function getFilteredTerms($terms, $part)
    {
        $filtered_terms = [];
        foreach($terms as $term)
        {
            $part_id = $term->mappings->part_id;
            if($part_id == $part->id)
            {
                $filtered_terms []= $term;
            }
        }
        return $filtered_terms;
    }

    public function verifyCodes($codes, $requestedCodes)
    {
        $filtered_codes = [];
        foreach($codes as $code)
        {
            if(in_array($code->code, $requestedCodes))
            {
                $filtered_codes []= $code;
            }
        }

        return $filtered_codes;
    }

}
