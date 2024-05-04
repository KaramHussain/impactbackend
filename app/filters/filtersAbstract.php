<?php

namespace App\filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class filtersAbstract
{
    public $request;
    protected $filters = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function filter(Builder $builder)
    {
        foreach($this->getFilters() as $filter => $value)
        {
            $this->resolveFilter($filter)->filter($builder, $value);
        }
    }

    public function add(array $filters = [])
    {
        $this->filters = array_merge($this->filters, $filters);
        return $this;
    }

    public function resolveFilter($value)
    {
        return new $this->filters[$value];
    }

    public function getFilters()
    {
        return $this->filterFilters();
    }

    public function filterFilters()
    {
        return array_filter($this->request->only(array_keys($this->filters)));
    }

}
