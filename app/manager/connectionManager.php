<?php

namespace App\manager;

class connectionManager
{
    protected $connections = [];

    public function __construct()
    {
        $this->connections =  [
            'anatomy'                            => config('database.connections.anatomy_testing.database'),
            'mur'                                => config('database.connections.mur.database'),
            'preventive_care'                    => config('database.connections.preventive_care.database'),
            'master'                             => config('database.connections.master_database.database'),
            'carepays_testing'                   => config('database.connections.carepays_testing.database'),
            'search_engine'                      => config('database.connections.search_engine.database'),
            'all_cpts_and_icds'                  => config('database.connections.all_cpts_and_icds.database'),
            'rules'                              => config('database.connections.rules.database'),
            'icd10cm_cpts_layterms_crosswalk'    => config('database.connections.icd10cm_cpts_layterms_crosswalk.database')
        ];
    }

    public function setConnection($key, $value)
    {
        $this->connections[$key] = $value;
    }

    public function getConnection($key)
    {
        return $this->connections[$key];
    }
}
