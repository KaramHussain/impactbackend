<?php

namespace App\Http\Controllers\providers;

use Illuminate\Http\Request;
use App\manager\connectionManager;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class suggestionsController extends Controller
{
    private $connection;
    public function __construct()
    {
        $this->connection = app(connectionManager::class)->getConnection('master');
    }
    public function fetch(Request $request) 
    {
        $table = $request->type;
        $param = $table == 'cpts' ? 'cpt_value' : 'icd_value';
        $results = DB::connection($this->connection)->table($table)
        ->where($param, 'LIKE', "%{$request->text}%")
        ->limit(6)
        ->get(["$param as term"]);
        return response()->json($results);
    }
}
