<?php

namespace App\Http\Controllers\AnatomyController;

use DB;
use App\Http\Controllers\AnatomyController\AnatomyController;
use App\manager\connectionManager;

class diseaseIcdsController extends AnatomyController
{

    public function fetch($diseases)
    {
        $disease_icds = $this->anatomy->table('disease_icds');
        $disease_icds->whereIn('disease_id', $diseases);
        return $disease_icds->get(['icd']);
    }

    public function fetch_icds($icds)
	{

        $icds_table = DB::connection(
            app(connectionManager::class)->getConnection('all_cpts_and_icds')
        )->table('icds');

        $disease_icds_ranges = [];
        $disease_icds = [];
		foreach($icds as $icd)
		{
			$icd = $icd->icd;

			if (strpos($icd, '-'))
			{
                $icd_range = explode('-', $icd);


				$from = $icd_range[0];
				$to = $icd_range[1];

				$icds_ids =  $icds_table->whereBetween('icd_value', array($from, $to))
                ->pluck('icd_value')->toArray();

                if(count($icds_ids))
                {
                    $disease_icds []= $icds_ids;
                }

			}
			else
			{
				$disease_icds []= [$icd];
			}
        }
		return count($disease_icds) ?  call_user_func_array('array_merge', $disease_icds) : $disease_icds;
    }

    public function applyRules($rules, $asset, $type)
	{
		$icd_codes = [];

		$icd_codes_fetched = $rules->table($type)
		->where($type, '<>', $asset)
		->pluck('icd_code')->toArray();

        return $icd_codes_fetched;

		foreach($icd_codes_fetched as $icds)
		{
			$icd_codes []= $icds->icd_code;
		}
		return $icd_codes;
    }

    public function applyRulesAndMerge($rules, $age, $gender)
    {
        $icd_codes_from_age = $this->applyRules($rules, $age, 'age');
        $icd_codes_from_gender = $this->applyRules($rules, $gender, 'gender');

        return array_unique(array_merge($icd_codes_from_age, $icd_codes_from_gender));
    }

    public function getLaytermsCrosswalk($icds_ids)
    {

        $icds_cpts_crosswalk = DB::connection(
            app(connectionManager::class)->getConnection('icd10cm_cpts_layterms_crosswalk')
        )->table('icd_cpts_crosswalk');

        $icds_cpts_crosswalk->whereIn('icd_id', $icds_ids);

        $cpts = $icds_cpts_crosswalk->pluck('cpt_id')->toArray();

        if(count($cpts))
        {
            return array_unique($cpts);
        }
        return $cpts;

    }

}
