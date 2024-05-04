<?php

namespace App\Http\Controllers\AnatomyController;

use DB;
use App\rules\part_code;
use App\Http\Controllers\Controller;
use App\manager\connectionManager;

class AnatomyController extends Controller
{
    public $connection;
    public $anatomy;

    public function __construct()
    {
        $this->connection = app(connectionManager::class)->getConnection('anatomy');
        $this->anatomy = DB::connection($this->connection);
    }

    public function return_value_if_exists($id, $diseases = [])
	{
        $key = array_search($id, array_column($diseases, 'disease'));
		if($key != '' || $key != null)
		{
			return $diseases[$key];
		}
		return null;
    }

    public function sort_array_desc($array)
	{

		//initializing arrays
		$keys = [];
        $values = [];

		foreach($array as $item)
		{
			$keys[]   = $item['disease'];
			$values[] = $item['score'];
        }

		for($i=0; $i<count($values); $i++)
		{
			if($i < count($values)-1)
			{
				for($j=$i+1; $j<count($values); $j++)
				{
					if((int) $values[$i] < (int) $values[$j])
					{

						//values
						$temp = $values[$i];
						$values[$i] = $values[$j];
						$values[$j] = $temp;

						//their keys
						$temp = $keys[$i];
						$keys[$i] = $keys[$j];
						$keys[$j] = $temp;

					}
				}
			}
        }

		$associated_array = [];

		for($i=0;$i<count($values); $i++)
		{
            $value = $values[$i];
			$key = $keys[$i];

			$associated_array[$key] = $value;
        }

		return $associated_array;

    }

    public function getWeightedCpts(array $allowed_cpts, $part)
    {

        $db = DB::connection(
            app(connectionManager::class)->getConnection('master')
        );

        $table = $db->table('weighted_cpts');

        if(count($allowed_cpts))
        {

            $weighted_cpts = $table->whereIn('cpt', $allowed_cpts)
            ->groupBy('cpt')
            ->orderBy('weight', 'desc')
            ->get(['cpt as code', 'weight']);

            if(count($weighted_cpts))
            {
                $cpts = [];
                foreach($weighted_cpts as $result)
                {
                    $cpts []= ['codes' => $result, 'part' => $part];
                }
                return $cpts;
            }

        }

        return [];

    }

    public function cpts_parts_mapping($parts, $subpart)
    {
        $parts = $this->formatArray($parts);

        $codes = part_code::whereIn('part_id', $parts)
        ->where('subpart_id', $subpart)
        ->where('code_type', 'cpt')
        ->get(['code']);

        $cpts = $this->formatArray($codes, 'code');
        return $cpts;

    }

    public function formatArray($array, $param = 'id')
    {
        $formatted_array = [];
        foreach($array as $item)
        {
            $formatted_array [] = $item->$param;
        }
        return $formatted_array;
    }

}

?>
