<?php

namespace App\Http\Controllers\search\disease;


class disease
{

    public function get($search_words, $db_layterms, $query)
    {

        /*****************CASE 1******************
        *
        * find in category
        *
        */


        $layterms = $db_layterms->table('icd10cm_mapping');
        $layterms->join('icd10cm', 'icd10cm_mapping.icd_id', '=', 'icd10cm.id');
        $layterms->join('synonyms', 'icd10cm.id', '=', 'synonyms.type_id');

        $layterms->select('icd10cm_mapping.name as term', 'icd10cm.icd10cm_code as code');

        $first_word = $search_words[0];

        $i=0;
        foreach($search_words as $word)
        {
            $condition = $i==0 ? 'where' : 'Orwhere';
            $layterms->$condition('icd10cm_mapping.name', 'LIKE', "%$word%")
            ->Orwhere('synonyms.name', 'LIKE', "%$word%")
            ->Orwhere('icd10cm.icd10cm_code', 'LIKE', "%$word%");
            $i++;
        }

        $results = $layterms
        ->orderByRaw("icd10cm_mapping.name REGEXP '^$first_word' DESC")
        ->get();

        $parent_terms = [];
        $child_terms = [];

        foreach($results as $result)
        {
            $code = $result->code;
            $term = $result->term;
            //get only parent
            if(!strpos($code, '.'))
            {
                if(!in_array($term, array_column($parent_terms, 'term')))
                {
                    $parent_terms []= ['term' => $term];
                }
            }
            else
            {
                if(!in_array($term, array_column($child_terms, 'term')))
                {
                    $child_terms []= ['term' => $term];
                }
            }
        }

        if(count($parent_terms) >= 8)
        {
            $results = array_slice($parent_terms, 0, 8);
        }
        else
        {
            $results = array_merge($parent_terms, $child_terms);
            $results = array_slice($results, 0, 8);
        }

        return response()->json($results);
    }

}

?>
