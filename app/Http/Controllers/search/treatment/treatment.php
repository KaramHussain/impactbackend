<?php

namespace App\Http\Controllers\search\treatment;

use App\Http\Controllers\search\searchController;
use App\Http\Controllers\search\treatment\codesController;
use App\Http\Controllers\search\treatment\icdsController;
use App\Http\Controllers\search\treatment\childrenController;
use App\Http\Controllers\search\treatment\childrenTermsController;
use App\Http\Controllers\search\treatment\termsController;

class treatment extends searchController
{

    public function get($search_words, $query, $category_id)
    {

        /*****************CASE 1******************
        *
        * find in parent
        *
        */

        $termsController = new termsController;
        $results = $termsController->searchAll($query, $category_id);
        if(count($results['data'])) return $results;

        /*****************CASE 2******************
        *
        * find in synoyms for parent
        *
        */

        $results = $termsController->search_terms_from_synonyms($query, $category_id);
        if(count($results['data'])) return $results;

        /*****************CASE 3******************
        *
        * find in children
        *
        */

        $childrenController = new childrenController;
        $childrenTermsController = new childrenTermsController;
        $results = $childrenController->searchAll($query, $category_id);
        if(count($results['data'])) return $results;


        /*****************CASE 4******************
        *
        * find in synonyms for children
        *
        */

        $results = $childrenController->search_for_synonyms($query, $category_id);
        if(count($results['data'])) return $results;


        /*****************CASE 5******************
        *
        * search in part and return assoicated parent terms || children terms
        *
        */

        $results = $childrenController->search_for_parts($query, $category_id);
        if(count($results['data'])) return $results;



        /*****************CASE 6******************
        *
        * search in categories and return assoicated parent terms || children terms
        *
        */

        $results = $childrenController->search_for_categories($query, $category_id);
        if(count($results['data'])) return $results;



        /*****************CASE 7******************
        *
        * search in sub categories and return assoicated parent terms || children terms
        *
        */

        $results = $childrenController->search_for_subcategories($query, $category_id);
        if(count($results['data']))  return $results;


        /*****************CASE 8******************
        *
        * search in codes for children terms
        *
        */

        $results = (new codesController)->search_for_codes($query, $category_id);
        if(count($results['data'])) return $results;
        
        /*****************CASE 9******************
        *
        * search in icds and fetch children terms
        *
        */

        $results = (new icdsController)->search_icds($query, $category_id);
        if(count($results['data'])) return $results;



        /**********************************************************************
        ***********************************************************************
        ********CASES FOR MORE THAN 1 WORDS IF RESULTS NOT FOUND ABOVE*********
        ***********************************************************************
        ***********************************************************************/
        
        /*****************CASE 1******************
        *
        * find in categories and/or in part and fetch children
        *
        */

        $results = $childrenTermsController->search_in_parts_or_categories_for_children($search_words, $category_id);
        if(count($results['data'])) return $results;


        /*****************CASE 2******************
        *
        * find in subcategories and/or in part and fetch children
        *
        */

        $results = $childrenTermsController->search_in_parts_or_subcategories_for_children($search_words,$category_id);
        if(count($results['data'])) return $results;



        /*****************CASE 3******************
        *
        * find in term and other in part or vice versa and fetch children
        *
        */

        $results = $childrenTermsController->search_in_parts_or_terms_for_children($search_words, $category_id);
        if(count($results['data'])) return $results;



        /*****************CASE 4******************
        *
        * find in chidlren term and other in part or vice versa and fetch children
        *
        */

        $results = $childrenTermsController->search_in_parts_or_children($search_words, $category_id);
        if(count($results['data'])) return $results;


        /*****************CASE 5******************
        *
        * find both in terms and fetch children
        *
        */

        $results = $termsController->search_both_in_terms_or_synonyms($search_words, $category_id);
        if(count($results['data'])) return $results;


        /*****************CASE 6******************
        *
        * find both in terms and fetch children
        *
        */

        $results = $childrenTermsController->search_both_in_child_terms_or_synonyms($search_words, $category_id);
        return $results;


        // if(count($search_words) == 1)
        // {

        //     $word = $search_words[0];

        //     //*****************CASE 1******************//
        //     //find in parent

        //     $search = $db->table('term');

        //     $terms = $search
        //         ->join('children_terms', 'children_terms.term_id', '=', 'term.id')
        //         ->join('synonyms', 'synonyms.related_id', '=', 'term.id')
        //         ->select('children_terms.name as term', 'synonyms.name as synonyms', 'children_terms.description')
        //         ->where('term.name', 'LIKE', "%$word%")
        //         ->Orwhere(function($query) use ($word) {
        //             $query->where('synonyms.name', 'LIKE', "%$word%")
        //             ->where('synonyms.related_type', 'term');
        //         })
        //         ->limit(8)
        //         ->distinct()
        //         ->get();

        //     if(count($terms))
        //     {
        //         return $terms;
        //     }

        //     //*****************CASE 2******************//
        //     //find in children

        //     $search = $db->table('children_terms');

        //     $terms = $search->where('name', 'LIKE', "%$word%")
        //         ->limit(8)
        //         ->distinct()
        //         ->get(['name as term', 'description']);

        //     if(count($terms))
        //     {
        //         return $terms;
        //     }

        //     //*****************CASE 3******************//
        //     //find in parts

        //     $search = $db->table('parts');

        //     $terms = $search->where('parts.name', 'LIKE', "%$word%")
        //         ->join('children_terms', 'children_terms.part_id', '=', 'parts.id')
        //         ->select('children_terms.name as term', 'children_terms.description')
        //         ->distinct()
        //         ->limit(8)
        //         ->get();


        //     if(count($terms))
        //     {
        //         return $terms;
        //     }

        //     //*****************CASE 4******************//
        //     //find in categories

        //     $search = $db->table('categories');

        //     $terms = $search->where('categories.name', 'LIKE', "%$word%")
        //         ->join('children_terms', 'children_terms.category_id', '=', 'categories.id')
        //         ->select('children_terms.name as term', 'children_terms.description')
        //         ->distinct()
        //         ->limit(8)
        //         ->get();


        //     if(count($terms))
        //     {
        //         return $terms;
        //     }


        //     //*****************CASE 5******************//
        //     //find in sub categories

        //     $search = $db->table('sub_categories');

        //     $terms = $search->where('sub_categories.name', 'LIKE', "%$word%")
        //         ->join('children_terms', 'children_terms.sub_category_id', '=', 'sub_categories.id')
        //         ->select('children_terms.name as term', 'children_terms.description')
        //         ->distinct()
        //         ->limit(8)
        //         ->get();


        //     if(count($terms))
        //     {
        //         return $terms;
        //     }

        //     //*****************CASE 6******************//
        //     //find in sub categories

        //     $search = $db->table('code');

        //     $terms = $search
        //         ->join('children_terms', 'children_terms.id', '=', 'code.term_id')
        //         ->join('synonyms', 'code.id', '=', 'synonyms.type_id')
        //         ->select('children_terms.name as term', 'children_terms.description')
        //         ->where('code.code', 'LIKE', "$word%")
        //         ->Orwhere(function($query) use ($word) {
        //             $query->where('synonyms.name', 'LIKE', "%$word%")
        //             ->where('synonyms.related_type', 'code');
        //         })
        //         ->limit(8)
        //         ->distinct()
        //         ->get();


        //     if(count($terms))
        //     {
        //         return $terms;
        //     }

        // }//count of words == 1


        // if(count($search_words) >= 2)
        // {

        //     $first_word = $search_words[0];

        //     ////***************CASE 0**************////
        //     //find in categories and/or in part and fetch children

        //     $search = $db->table('categories');

        //     $category_ids = $helpingFunctions->getCategoryIds($search_words, $db, 'categories');

        //     $part_ids = $helpingFunctions->getPartIds($search_words, $db);

        //     $results = [];

        //     if(count($category_ids) && count($part_ids))
        //     {
        //         $results = $helpingFunctions->getChildrenByCategories($category_ids, $part_ids, $db, 'category');
        //     }

        //     else if(count($category_ids))
        //     {
        //         $results = $helpingFunctions->getChildrenByCategories($category_ids, $part_ids, $db, 'category');
        //     }

        //     if(count($results))
        //     {
        //         return $results;
        //     }

        //     ////***************CASE 1**************////
        //     //find in sub_categories and/or in part and fetch children

        //     $search = $db->table('sub_categories');

        //     $category_ids = $helpingFunctions->getCategoryIds($search_words, $db, 'sub_categories');

        //     $part_ids = $helpingFunctions->getPartIds($search_words, $db);

        //     $results = [];

        //     if(count($category_ids) and count($part_ids))
        //     {
        //         $results = $helpingFunctions->getChildrenByCategories($category_ids, $part_ids, $db, 'sub_category');
        //     }

        //     else if(count($category_ids))
        //     {
        //         $results = $helpingFunctions->getChildrenByCategories($category_ids, $part_ids, $db, 'sub_category');
        //     }

        //     if(count($results))
        //     {
        //         return $results;
        //     }

        //     ///***********CASE 2*************///

        //     //search term whose part is abdomen
        //     //now the part can be first and the term can be second and vice versa

        //     $term_ids = $helpingFunctions->getTermIds($search_words, $db);

        //     $part_ids = $helpingFunctions->getPartIds($search_words, $db);

        //     $results = [];
        //     if(count($term_ids) && count($part_ids))
        //     {
        //         $results = $helpingFunctions->getChildren($term_ids, $part_ids, $db, $first_word);
        //     }

        //     if(count($results))
        //     {
        //         return $results;
        //     }

        //     ///***********CASE 3*************///

        //     //search term whose both terms can be parent term or its synonym term and then find its children

        //     $term_ids = $helpingFunctions->getTermIds($search_words, $db);

        //     $results = [];
        //     //get children without part id
        //     if(count($term_ids))
        //     {
        //         $results = $helpingFunctions->getChildrenWithoutPart($term_ids, $db, $first_word);
        //     }

        //     //returning response
        //     if(count($results))
        //     {
        //         return $results;
        //     }

        //     ////***************CASE 4**************////
        //     //find in child terms

        //     $search = $db->table('children_terms');
        //     $i=0;
        //     foreach($search_words as $word)
        //     {
        //         $condition = $i==0 ? 'where' : 'Orwhere';
        //         $search->where('name', 'LIKE', "%$word%");
        //         $i++;
        //     }

        //     $results = $search->limit(8)->distinct()->get(['name as term', 'description']);

        //     if(count($results))
        //     {
        //         return $results;
        //     }


        //     ////***************CASE 5**************////
        //     //find in synonyms and return children

        //     $search = $db->table('synonyms');
        //     $search->join('code', 'synonyms.type_id', '=', 'code.id');
        //     $search->join('children_terms', 'code.term_id', '=', 'children_terms.id');

        //     $search->where(function($query) use ($search_words) {
        //         $i=0;
        //         foreach($search_words as $word) {
        //             $condition = $i==0 ? 'where' : 'Orwhere';
        //             $query->where('synonyms.name', 'LIKE', "%$word%");
        //             $i++;
        //         }
        //     });

        //     $search->where('synonyms.type', 'code');
        //     $results = $search
        //             ->distinct()
        //             ->orderBy('children_terms.name', 'ASC')
        //             ->get(['children_terms.name as term', 'children_terms.description']);

        //     if(count($results))
        //     {
        //         return $results;
        //     }

        // }//if count(words) are multiple

    }

    public function get_consultant_codes($category)
    {
        return (new childrenController)->get_consultant_terms($category);
    }

}


?>
