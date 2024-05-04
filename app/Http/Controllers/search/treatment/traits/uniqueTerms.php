<?php

namespace App\Http\Controllers\search\treatment\traits;

use Illuminate\Support\Collection;

trait uniqueTerms
{
    public function getUniqueTerms($terms, $limit=true)
    {
        $unique_terms = new Collection;
        $terms->each(function($term) use ($unique_terms, $limit) {
            $child = $term->associated_child_term;
            if($limit == true)
            {
                if($unique_terms->count() >= 8)
                {
                    return $unique_terms;
                }
            }

            if(!$unique_terms->contains('name', $child->name))
            {
                $unique_terms->push($child);
            }
        });
        return $unique_terms;
    }

    public function getChildUniqueTerms($terms, $limit=true)
    {
        $unique_terms = new Collection;
        $terms->each(function($term) use ($unique_terms, $limit) {

            if($limit == true)
            {
                if($unique_terms->count() >= 8)
                {
                    return $unique_terms;
                }
            }

            if(!$unique_terms->contains('name', $term->name))
            {
                $unique_terms->push($term);
            }
        });
        return $unique_terms;
    }

}
