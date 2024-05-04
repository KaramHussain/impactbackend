<?php

namespace App\Http\Controllers\AnatomyController;

use DB;

use Illuminate\Http\Request;

use App\Http\Controllers\AnatomyController\{AnatomyController, diseasesController, agesController, categoriesCptsController};

use App\Anatomy\traits\mappings\{age_mappings, part_mappings};

use App\Anatomy\{disease, symptom, body_part, symptom_all_diseases, question};
use App\manager\connectionManager;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class symptomsController extends AnatomyController
{
	use age_mappings, part_mappings;

	public $symptoms_obj;

	public function __construct()
	{
        $this->symptoms_obj = new symptom;
        parent::__construct();
    }

    public function searchCptsFromDiseases(Request $request)
    {

        $rules = DB::connection(
            app(connectionManager::class)->getConnection('all_cpts_and_icds')
        );
        $diseases = [];

        $db = DB::connection($this->connection);
        $symptoms_all_diseases = $db->table('symptom_all_diseases');

        $answers = $request->answers;
        $symptom = $request->term;

        $symptom_id = symptom::where('name', $symptom)->get();

        if(count($symptom_id) > 0)
        {
            $symptom_id = $symptom_id->first()->id;
        }
        else
        {
            $symptom_id = 0;
        }

        $g = 1;
        $part_ids = [6];
        $symptoms = [];
        $symptoms['id'] = $symptom_id;

        $results = $symptoms_all_diseases->where('symptom_id', $symptom_id)
        ->where(function ($query) use ($g) {
			$query->where('gender_id', $g)
			->Orwhere('gender_id', 3);
        })->where(function($query) use ($part_ids) {
			$j=0;
			foreach($part_ids as $part_id) {
				$condition = $j == 0 ? 'where' : 'Orwhere';
				$query->$condition('part_id', $part_id);
				$j++;
			}
        });

        $disease_ids = $results->get(['disease_id', 'disease_score']);

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

		if(is_array($answers) && count($answers)!=0)
		{
			//making connection with answer_diseases_scores

			$answer_diseases_scores = DB::connection($this->connection)
			->table('answer_diseases_scores');

            $i=0;
			//fetching disease_ids and scores from answer_diseases_scores
			foreach($answers as $answer)
			{
                //converting string to array
                $answer = json_decode($answer, true);

				$condition = $i == 0 ? 'where' : 'Orwhere';
				$answer_diseases_scores->$condition('answer_id', $answer['answerId']);
				$i++;
            }

			$answer_ids = $answer_diseases_scores
			->get(['disease_id', 'score']);

			//fill in diseases array with diseases ids and scores
			foreach($answer_ids as $answer)
			{

				$id = $answer->disease_id;
				$score = $answer->score;

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
		}//if count answers

        $diseases = $this->sort_array_desc($diseases);

        //fetching top 5 diseases
        $top_diseases = (new diseasesController)->top_diseases($diseases);

        //make connection with disease_icds

		$disease_icds = DB::connection($this->connection)
		->table('disease_icds');

		//get icds from disease_icds
		foreach($top_diseases as $disease)
		{

			$condition = $i == 0 ? 'where' : 'Orwhere';
			$disease_icds->$condition('disease_id', $disease);

		}

        $icds = $disease_icds->get();
        $age = '0-1';
        $gender = 'm';

        // 	fetching icd ranges from all cpts_and_icds records
        $icds_controller = new diseaseIcdsController;
        $icds_ids = $icds_controller->fetch_icds($icds);
        $icd_codes = $icds_controller->applyRulesAndMerge($rules, $age, $gender);

        //make difference from disease_icds and rules icds || filtering icds
		$icds_ids = array_diff($icds_ids, $icd_codes);
        $icds_ids = array_unique($icds_ids);

        $icds_cpts_crosswalk = DB::connection(
            app(connectionManager::class)->getConnection('icd10cm_cpts_layterms_crosswalk')
        )->table('icd_cpts_crosswalk');

		$i=0;
		//$icds_cpts_crosswalk = $icds_cpts_crosswalk->distinct();

		foreach($icds_ids as $icd)
		{
            $condition = $i == 0 ? 'where' : 'Orwhere';
            $icd_another = $icd[-1] == '0' ? $icd."0" : '';
			$icds_cpts_crosswalk->$condition('icd_id', $icd);
			$icds_cpts_crosswalk->Orwhere('icd_id', $icd_another);
			$i++;
		}

        $cpts_array = [];
        $cpts = $icds_cpts_crosswalk->get(['cpt_id']);

        foreach($cpts as $cpt)
        {
            $cpts_array[]= $cpt->cpt_id;
        }

        $crosswalk = $rules->table('categories_cpts_crosswalk');
        $cpts_array_from_crosswalk = [];
        $category = "surgery";
        $cpts_from_crosswalk = $crosswalk->where('name', $category)->get(['cpt']);

        foreach($cpts_from_crosswalk as $cpt)
        {
            $cpts_array_from_crosswalk []= $cpt->cpt;
        }

        $allowed_cpts = [];

        foreach($cpts_array as $cpt)
        {
            if(in_array($cpt, $cpts_array_from_crosswalk))
            {
                $allowed_cpts []= $cpt;
            }
        }

        return response()->json(array_unique($allowed_cpts));

    }

    public function fetchSymptomsInAllParts(Request $request)
    {
        $symptom = $request->key;
        $gender = $request->gender;

        $symptoms = DB::connection($this->connection)->table('symptoms');

        // $symptoms->join('symptoms', 'symptoms.id', '=', 'symptom_all_diseases.symptom_id');

        // $symptom_ids = $symptoms
        // ->where('symptoms.name', 'LIKE', "%$symptom%")
        // ->where(function($query) use ($gender) {
        //     $query
        //     ->where('symptom_all_diseases.gender_id', $gender)
        //     ->Orwhere('symptom_all_diseases.gender_id', 3);
        // });


        // $symptoms = $symptom_ids->get(['symptoms.id', 'symptoms.name', 'symptoms.has_questions', 'symptoms.warning_text', 'symptoms.created_at', 'symptoms.updated_at']);

        $symptoms = $symptoms->where('name', 'LIKE', "%$symptom%")->get();

		return response()->json($symptoms);
    }

	public function fetchSymptomsFromParts(request $request)
	{

        $sub_part   = (int) $request->id;
        $gender     = (int) $request->gender;
        $body_part  = $request->parentPart;

		$symptom_all_diseases_obj = $this->anatomy->table('symptom_all_diseases');

        $part_obj = new body_part;

        $body_part = $part_obj->getId([$body_part])->first()->id;

		$symptom_ids = $symptom_all_diseases_obj
        ->where('sub_part', $sub_part)
        ->where(function($query) use ($gender) {
           $query->where('gender_id', $gender)
           ->orWhere('gender_id', 3);
        })
        ->where('part_id', $body_part);

        $symptom_ids = $symptom_ids->distinct()->get(['symptom_id']);

        if(!count($symptom_ids))
        {
            return [];
        }

		return
		response()
		->json($this->symptoms_obj->fetchNamesFromSymptomIds($symptom_ids));

	}

	public function fetchSymptoms(Request $request)
	{

		$request->validate([
            'age' => 'required',
            'gender' => 'required',
            'part' => 'required'
        ]);

		//map body_part according to model

        $parts = $this->part_mappings()[$request->part];

        //map Age
        $age = $this->age_mappings($request->age);

        if(count($parts) === 0)
		{
			throw new ValidationException("part not found");
        }

        //fetch parts
        $partsController = new BodyPartController;
        $parts = $partsController->fetch($parts);

		if(!count($parts))
		{
			throw new ValidationException("Part not found");
        }

        $symptoms = $this->getSymptoms($parts, $request->gender);

        return response()->json($symptoms);

    }

    /**
    *
    *   @require parts, gender
    *   @return symptoms
    *
    */

    public function getSymptoms($parts, $gender)
    {

        $symptom_all_diseases_obj = $this->anatomy
        ->table('symptom_all_diseases');

        $symptom_ids = $symptom_all_diseases_obj
        ->join('symptoms', 'symptoms.id', '=', 'symptom_all_diseases.symptom_id')
        ->where(function($query) use ($gender) {
            $query->where('symptom_all_diseases.gender_id', $gender)
            ->orWhere('symptom_all_diseases.gender_id', 3);
        })
        ->where(function($query) use ($parts) {
            $i=0;
            foreach ($parts as $part)
            {
                $condition = $i == 0 ? 'where' : 'orWhere';
                $query->$condition('symptom_all_diseases.part_id', $part);
                $i++;
            }
        });

        $symptoms = $symptom_ids
        ->groupBy('symptoms.name')
        ->get([
            'symptoms.id',
            'symptoms.name',
            'symptoms.has_questions',
            'symptoms.warning_text',
            'symptoms.created_at'
        ]);

        return $symptoms;

    }


	public function age_mappings($age)
	{
		$age_mappings = array('All');

		if($age == '0-1')
		{
			$age_mappings []= '0-1';
		}
		else if($age == '1-5')
		{
			$age_mappings []= '1-5';
		}
		else if($age == '6-17')
		{
			$age_mappings []= '5+';
		}
		else
		{
			$age_mappings []= 'All';
		}

		return $age_mappings;
	}

	public function selectLaytermsOfCpt(Request $request)
	{
        $cpt = $request->cpt;

		$layterms = DB::connection(
            app(connectionManager::class)->getConnection('icd10cm_cpts_layterms_crosswalk')
        )->table('cpts_layterms');

		return $layterms->where('cpt_code', $cpt)->get();

	}

	public function fetchCptsFromRanges($ranges_all)
	{
		$cpts = array();
		$all_cpts = DB::connection(
            app(connectionManager::class)->getConnection('all_cpts_and_icds')
        )->table('cpts');

		$i=0;
		foreach($ranges_all as $range)
		{
			$range = $range->codes;
			if(strpos($range, '-'))
			{
				$ranges = explode('-', $range);
				$condition = $i==0 ? 'whereBetween' : 'orWhereBetween';
				$all_cpts->$condition('cpt_value', $ranges);
			}
			$i++;
		}
		$all = $all_cpts->get(['cpt_value']);

		foreach($all as $cpt)
		{
			$cpts []= $cpt->cpt_value;
		}

		return $cpts;
	}

	public function calculate_cpt_ranges($cpts_all, $cpts)
	{
		$cpts_collection = array();

		return array_values(array_unique($cpts_collection));
	}

	public function relatedRecord()
	{
		$model = request()->model;
		$symptom_id = request()->symptom;

		$symptoms_all_diseases = new symptom_all_diseases;

		$data = $symptoms_all_diseases::where('symptom_id', $symptom_id)->get();

		if($model == 'disease')
		{
			$disease = new disease;
			$data = $disease->fetchDiseases($data);
		}
		elseif($model == 'question')
		{
			$question = new question;
			$data = $question->fetchQuestions($symptom_id);
		}
		else if($model == 'symptom_all_diseases')
		{
			$data = $symptoms_all_diseases->fetchRecord($data);
		}


		return response()->json([
			'table' => lcfirst($model),
			'data'  => $data
		]);

	}


	public function fetch_old_symptoms()
	{

		$symptoms = new symptom;
		$symptom_req  = request()->symptom;
		$part         = request()->part;
		$gender       = request()->gender;

	    $symptoms_all = $symptoms->where('name', 'LIKE', "%$symptom_req%")->limit(5)->get();

		return response()->json([
			'data' => $symptoms_all
		]);
	}

	public function fetch(Request $request)
	{

		$symptoms = new symptom;

		$symptom_req  = $request->symptom;
		$part         = $request->part;
        $gender       = $request->gender;

		$symptom_id = $symptoms->where('name', $symptom_req)->first()->id;

		$diseases = DB::table('diseases')
					->join('symptom_all_diseases', 'diseases.id', '=', 'symptom_all_diseases.disease_id')
					->where('symptom_all_diseases.symptom_id', $symptom_id)
					->where('symptom_all_diseases.part_id', $part)
					->where('symptom_all_diseases.gender_id', $gender)->get();

		if($diseases->count())
		{
			return $diseases;
		}

		return false;

	}

    public function fetchTreatmentName(Request $request)
    {
        $cpt = $request->cpt;
        $db = DB::connection(
            app(connectionManager::class)->getConnection('search_engine')
        );
        $table = $db->table('children_terms');
        $table->join('code', 'code.term_id', 'children_terms.id');
        $table->select('children_terms.name as name');
        $result = $table->where('code.code', $cpt)->get();
        return response()->json($result);
    }


}
