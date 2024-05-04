<?php

namespace App\Http\Controllers;

use App\master_directory;
use Illuminate\Http\Request;
use App\master_directories_npi_cw;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class masterDirectoryController extends Controller
{
    public function fetch_specialaites() 
    {
        $specialities = Cache::remember(
            'specialities', 
            '2592000', // 1 month
            fn() => master_directories_npi_cw::select(DB::raw("distinct speciality as specialties"))
                ->whereNotNull('speciality')
                ->pluck('specialties')
        );

        return response()->json($specialities);
    }

    public function fetch_sub_specialaites(Request $request) 
    {
        $request->validate([
            'speciality' => ['required']
        ]);

        return response()->json(
            master_directories_npi_cw::select(DB::raw('distinct description as specialities'))
            ->where('speciality', $request->speciality)
            ->whereNotNull('description')
            ->pluck('specialities')
        );
    }

    public function fetch_doctors(Request $request) 
    {
        $request->validate([
            'speciality'    => ['required', 'notIn:0'],
            'subSpeciality' => ['required', 'notIn:0'],
            'address'       => ['required', 'numeric']
        ]);
        $zipcode = substr($request->address, 0, 3);
        return response()->json(
            master_directory::select(DB::raw('count(master_directories.npi) as doctors_count'))
            ->join('master_directories_npi_cw', 'master_directories.npi', '=', 'master_directories_npi_cw.npi')
            ->where('master_directories.zip', 'LIKE', "$zipcode%")
            ->where('master_directories_npi_cw.speciality', $request->speciality)
            ->where('master_directories_npi_cw.description', $request->subSpeciality)
            ?->first()?->doctors_count
        );
    }

}
