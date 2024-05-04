<?php

namespace App\Http\Controllers;

use DB;
use App\manager\connectionManager;

class posTosController extends Controller
{

    protected $db;

    public function __construct()
    {
        $this->db = DB::connection(app(connectionManager::class)->getConnection('master'));
    }

    public function __invoke()
    {
        $type_of_services = $this->db->table('type_of_services')->get();
        $place_of_services = $this->db->table('place_of_services')->get();
        return response()->json($place_of_services);
    }

}
