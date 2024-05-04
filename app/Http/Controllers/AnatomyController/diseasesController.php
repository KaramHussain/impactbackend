<?php

namespace App\Http\Controllers\AnatomyController;

use DB;
use App\Anatomy\symptom;
use Illuminate\Http\Request;
use App\manager\connectionManager;
use App\Anatomy\traits\mappings\part_mappings;
use App\Http\Controllers\AnatomyController\AnatomyController;

class diseasesController extends AnatomyController
{

    use part_mappings;

    public function fetchDiseases(Request $request)
	{

        $diseases = [];

        $rules = DB::connection(
            app(connectionManager::class)->getConnection('rules')
        );

		//request parameters
		$answers 	= (array) $request->answers;
		$symptoms 	= (array) $request->symptoms;
        $part 		= $request->part;
        $subpart 	= $request->subpart;
		$age 		= $request->age;
		$g 			= $request->gender;
        $gender 	= $g == 1 ? 'm' : 'f';
        $category 	= $request->category;

        //get part mappings

        $parts = $this->part_mappings()[$part];

        $partsController = new BodyPartController;

        //get part ids
        $part_ids = $partsController->fetch($parts);

        //get disease_ids and Scores
        $diseases = $this->disesesAndScores($g, $symptoms, $part_ids);

		if(count($answers) != 0)
		{
            $answersController = new answersController;

            //get answer_ids from answers
            $answer_ids = $answersController->getAnswerIds($answers);

            //this method will take diseases and append to it
            $diseases = $answersController->groupAnswersAndAddScores($answer_ids, $diseases);

        }

		//fetching top 5 diseases
        $top_diseases = array_slice($diseases, 0, 5);

        //fetch icds from diseases
        $disease_icds_controller = new diseaseIcdsController;
        $icds = $disease_icds_controller->fetch(array_column($top_diseases, 'disease'));

        // fetching icd ranges from all cpts_and_icds records
        $icds_ids =  $disease_icds_controller->fetch_icds($icds);

        //getting age range based on user's age
        $age = (new agesController)->setAge($age);

        //apply rules and merge
        $icd_codes = $disease_icds_controller->applyRulesAndMerge($rules, $age, $gender);

        // make difference from disease_icds and rules icds || filtering icds
        $icds_ids = array_unique(array_diff($icds_ids, $icd_codes));

        if(!count($icds_ids)) return [];

        // get layterms crosswalk
        $cpts_from_layterms_crosswalk = $disease_icds_controller->getLaytermsCrosswalk($icds_ids);

		// get cpts from categories
        $cpts_from_categories = (new categoriesCptsController)->fetch($rules, $category);

        $allowed_cpts = array_unique(array_intersect($cpts_from_layterms_crosswalk, $cpts_from_categories));

        //get Cpts by its weight
        $allowed_cpts = $this->getWeightedCpts($allowed_cpts, $part);

        // $cpts_code_from_parts = $this->cpts_parts_mapping($part_ids, $subpart);
        // return $cpts_code_from_parts;


        // $similar_cpts = [];

        // foreach($allowed_cpts as $cpt)
        // {
        //     if(in_array($cpt, $cpts_code_from_parts))
        //     {
        //         $similar_cpts []= $cpt;
        //     }
        // }

        return response()->json($allowed_cpts);

    }

    public function disesesAndScores($g, $symptoms, $part_ids)
    {

		$symptom_all_diseases = $this->anatomy
        ->table('symptom_all_diseases');

        $symptom_all_diseases->select('disease_id', DB::raw('SUM(disease_score) as score'));

		$symptom_all_diseases
		->where(function ($query) use ($g) {
			$query->where('gender_id', $g)->orWhere('gender_id', 3);
		})
		->whereIn('symptom_id', $symptoms)
		->whereIn('part_id', $part_ids);

        $diseasesAndScores = $symptom_all_diseases->groupBy('disease_id')->orderBy('score', 'DESC')->get();

        $diseasesAndScoresArray = array();

        foreach($diseasesAndScores as $disease)
        {
            $diseasesAndScoresArray []= ['disease' => $disease->disease_id, 'score' => $disease->score];
        }

        return $diseasesAndScoresArray;

    }

    public function groupDiseasesAndAddScores($disease_ids, $diseases)
    {
        //fill in diseases array
		foreach($disease_ids as $disease)
		{
			$id = $disease->disease_id;
			$score = $disease->disease_score;

			if($old_id_score = $this->return_value_if_exists($id, $diseases))
			{
				$new_score = $score + $old_id_score;
				$diseases[$id] = $new_score;
			}
			else
			{
				$diseases[$id] = $score;
			}

        }
        return $diseases;
    }


    public function getCptsFromIcd()
    {

        $icd = request()->icd;
        $conn = DB::connection(
            app(connectionManager::class)->getConnection('all_cpts_and_icds')
        );
        $cpts = $conn->table('icd_cpts_crosswalk');

        $results = $cpts->where('icd_id', $icd);
        $results = $results->get(['cpt_id']);
        $results = $results->first();

        return response()->json($results);

    }

    public function top_diseases($diseases)
	{
		$top_diseases = [];
		$i=0;
		foreach($diseases as $disease => $score)
		{
			if($i==5)
			{
				break;
			}
			$top_diseases [$disease]= $score;
			$i++;
		}
		return $top_diseases;
	}


}
