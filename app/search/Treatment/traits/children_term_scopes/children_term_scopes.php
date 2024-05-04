<?php

namespace App\search\Treatment\traits\children_term_scopes;

use App\search\Treatment\code;
use App\search\Treatment\part;
use App\search\Treatment\term;
use Illuminate\Database\Eloquent\Builder;

trait children_term_scopes
{
    public function scopeWhereCategory(Builder $builder, $category = 1)
    {
        if($category == 0) return $builder;
        return $builder->where('category_id', $category);
    }

    public function scopeOrderByFirstWord(Builder $builder, $first_word, $order='DESC')
    {
        return $builder->orderByRaw("name REGEXP '^{$first_word}' {$order}");
    }

    public function scopeJoinTerms(Builder $builder)
    {
        return $builder->join('children_term_term', 'children_term_term.children_term_id', '=', 'children_terms.id');
    }

    public function scopeJoinParts(Builder $builder, $type)
    {
        return $builder->join('partables', function($join) use ($type) {
            $join->on('partables.partable_id', '=', 'children_terms.id')
            ->where('partables.partable_type', $type);
        });
    }

    public function scopeJoinCodes(Builder $builder)
    {
        return $builder->join('codes', function($join) {
            $join->on('code.children_term_id', '=', 'children_terms.id');
        });
    }

    public function scopeWhereInPartIds(Builder $builder, $query, $part_ids = [])
    {
        // if(empty($part_ids))
        // {
        //     return $builder->whereIn('partables.part_id', part::subqueryIds($query));
        // }

        return $builder->whereIn('partables.part_id', $part_ids);

    }

    public function scopeWhereInTermIds(Builder $builder, $query, $term_ids = [])
    {
        // if(empty($term_ids))
        // {
        //     return $builder->whereIn('children_term_term.term_id', term::subqueryIds($query));
        // }

        return $builder->whereIn('children_term_term.term_id', $term_ids);

    }

    public function scopeWhereChildLikes(Builder $builder, $words)
    {
        $i = 0;

        foreach($words as $word)
        {
            $condition = $i == 0 ? 'where' : 'orWhere';
            $builder->{$condition}('name', 'like', "%{$word}%");
            $i++;
        }
        return $builder;
    }


    public function scopeWhereAgeBetween(Builder $builder, $age)
    {
        return (new code)->whereAgeBetween($age);
    }

    public function scopeGender(Builder $builder, $gender)
    {
        return (new code)->gender($gender);
    }


}
