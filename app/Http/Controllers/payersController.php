<?php

namespace App\Http\Controllers;

use App\insurance\payer_list;
use Illuminate\Http\Request;

class payersController extends Controller
{
    public function __invoke()
    {
        return payer_list::selectRaw('left(name, 50) as name, id, payer_id')->where('name', '<>', '')->groupBy('name')->get();
    }
}
