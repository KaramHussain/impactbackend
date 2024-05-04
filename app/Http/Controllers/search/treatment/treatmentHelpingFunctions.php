<?php

namespace App\Http\Controllers\search\treatment;

class treatmentHelpingFunctions
{

    public function getChildrenByCategories($categories, $parts, $db, $type)
    {

        //define the table
        $search = $db->table('children_terms');

        if(count($categories))
        {
            $search->where(function($query) use ($categories, $type) {
                $i=0;
                foreach($categories as $id) {
                    $condition = $i==0 ? 'where' : 'Orwhere';
                    $query->$condition($type.'_id', $id);
                    $i++;
                }
            });
        }


        if(count($parts))
        {
            $search->where(function($query) use ($parts) {
                $i=0;
                foreach($parts as $id) {
                    $condition = $i==0 ? 'where' : 'Orwhere';
                    $query->$condition('part_id', $id);
                    $i++;
                }
            });
        }

        return $results = $search
        ->limit(10)
        ->distinct()
        ->orderByRaw("name ASC")
        ->get(['name as term', 'description']);
    }

    public function getCategoryIds($search_words, $db, $table)
    {

        $search = $db->table($table);

        $i=0;
        foreach($search_words as $word)
        {
            $condition = $i==0 ? 'where' : 'Orwhere';
            $search->$condition('name', 'LIKE', "%$word%");
            $i++;
        }

        $results = $search->get(['id']);

        $ids = array();

        foreach($results as $id)
        {
            if(!in_array($id->id, $ids))
            {
                $ids[] = $id->id;
            }
        }

        return $ids;
    }

    public function getTermIds($search_words, $db)
    {

        $search = $db->table('term');

        $search->join('synonyms', 'synonyms.related_id', '=', 'term.id');
        $search->select('term.id as id');

        $i=0;
        foreach($search_words as $word)
        {
            $condition = $i==0 ? 'where' : 'Orwhere';
            $search->$condition('term.name', 'LIKE', "%$word%");
            $i++;
        }

        $i=0;
        foreach($search_words as $word)
        {
            $search->Orwhere(function($query) use ($word) {
                $query->where('synonyms.name', 'LIKE', "%$word%");
                $query->where('synonyms.related_type', '=', "term");
            });
        }

        $results = $search->get();

        $ids = array();

        foreach($results as $id)
        {
            if(!in_array($id->id, $ids))
            {
                $ids[] = $id->id;
            }
        }

        return $ids;
    }

    public function getPartIds($search_words, $db)
    {

        $search = $db->table('parts');
        $i=0;
        foreach($search_words as $word)
        {
            $condition = $i==0 ? 'where' : 'Orwhere';

            $search->$condition(function($query) use ($word) {
                $query->where('name', 'LIKE', "%$word%");
            });

            $i++;
        }

        $ids = array();

        foreach($search->get(['id']) as $id)
        {
            if(!in_array($id->id, $ids))
            {
                $ids[] = $id->id;
            }
        }

        return $ids;
    }

    public function getChildrenWithoutPart($results, $db, $first_word)
    {
        //define the table
        $search = $db->table('children_terms');

        $i=0;
        foreach($results as $result)
        {

            $condition = $i==0 ? 'where' : 'Orwhere';

            $search->$condition('term_id', $result);

            $i++;
        }

        return $results = $search
        ->orderByRaw("name REGEXP '^$first_word' DESC")
        ->distinct()
        ->limit(8)
        ->get(['name as term', 'description']);
    }


    public function getChildren($terms, $parts, $db, $first_word)
    {
        //define the table
        $search = $db->table('children_terms');

        if(count($terms))
        {
            $search->where(function($query) use ($terms) {
                $i=0;
                foreach($terms as $id) {
                    $condition = $i==0 ? 'where' : 'Orwhere';
                    $query->$condition('term_id', $id);
                    $i++;
                }
            });
        }


        if(count($parts))
        {
            $search->where(function($query) use ($parts) {
                $i=0;
                foreach($parts as $id) {
                    $condition = $i==0 ? 'where' : 'Orwhere';
                    $query->$condition('part_id', $id);
                    $i++;
                }
            });
        }

        return $results = $search
        ->limit(10)
        ->distinct()
        ->orderByRaw("name ASC")
        ->get(['name as term', 'description']);

    }

}
