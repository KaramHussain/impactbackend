<?php

namespace App\Http\filters;

use Illuminate\Http\Request;

abstract class sorting
{

    protected $sorts = [];
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function resolveSortValue($value)
    {
        return isset($this->sorts[$value]) ? $this->sorts[$value] : null;
    }

    abstract public function sort($value, $order = 'asc');

}
