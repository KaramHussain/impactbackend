<?php

namespace App\Http\Controllers\AnatomyController;

use DB;
use App\Anatomy\body_part;
use App\Anatomy\sub_part;
use Illuminate\Http\Request;
use App\Anatomy\traits\mappings\part_mappings;
use App\search\Treatment\part;

class partsAndGenderController extends AnatomyController
{
	use part_mappings;

    public function index()
	{
		$sub_parts = body_part::all();
		return response()->json($sub_parts);
    }

    public function fetch_hpi_parts()
    {
        return response()->json(part::all(['name', 'id']));
    }

	public function getParts(Request $request)
	{
		$db = DB::connection($this->connection);

		$part = $request->part;
        $parts = $this->part_mappings()[$part];

		$parts_obj = new BodyPartController;
        $ids = $parts_obj->fetch($parts);

		$sub_parts = new sub_part;

        $result = $sub_parts->fetch($ids);

        //$results = $this->getUniqueResults($result);

		return response()->json($result);

    }


    public function getUniqueResults($result)
    {
        $results = [];
        foreach($result as $part)
        {
            if(!in_array($part->part, array_column($results, 'part')))
            {
                $results []= ['id'=>$part->id, 'parent_id'=>$part->parent_id, 'part'=>$part->part];
            }
        }
        return $results;
    }

	public function getAges()
	{
        $rules = DB::connection(
            app(connectionManager::class)->getConnection('rules')
        );
		$ages = $rules->table('age')->distinct()->get(['age']);
		return response()->json($ages);
	}

}
