<?php

namespace App\Http\Controllers\search;


use DB;
use App\state;
use Illuminate\Http\Request;
use App\search\Treatment\code;
use App\manager\connectionManager;
use App\Http\Controllers\Controller;
use App\Http\Controllers\search\treatment\treatment;
use App\Http\Resources\search\children_term_resource;

class searchController extends Controller
{
    protected $limit = 8;
    public function getCities(Request $request)
    {
        $id = $request->state_id;
        $states = DB::table('states');
        $states->join('cities', 'states.id', '=', 'cities.state_id');
        $states->where('states.id', $id);
        $results = $states->get(['states.id as state_id', 'states.state', 'cities.city', 'cities.state_id', 'cities.id as city_id']);
        return response()->json($results);
    }

    public function getStates()
    {
        $states = state::all();
        return response()->json($states);
    }

    public function get_codes_terms(Request $request)
    {
        $codes = $request->codes;

        $code_ids = code::whereIn('code', $codes)
        ->orderByFrequency()->get()->makeHidden('icds');
        $terms = [];

        foreach($code_ids as $code)
        {
            $terms []= ['code' => $code->code, 'terms' => $code->children_term, 'description' => $code->description];
        }

        return response()->json($terms);
    }

    public function getCodeTerms($code)
    {
        return code::where('code', $code)->first();
    }

    public function search(Request $request)
    {

        $query = $request->q;
        $category_id = $request->category;

        if($category_id == -1 || $category_id == '-1')
        {
            $category_id = 6;
            $treatment = new treatment;
            $data = $treatment->get_consultant_codes($category_id);

            return children_term_resource::collection($data['data'])
                    ->additional(['table' => 'children_terms']);
        }

        $queries = explode(' ', $query);

        $treatment = new treatment;
        $search_words = $this->exclude_stop_word($queries);
        $data = $treatment->get($search_words, $query, $category_id);

        //if not found in specified category then search in all categories and return category

        if(!count($data['data']))
        {
            $data = $treatment->get($search_words, $query, 0);
        }

        if($data['table'] == 'children_terms')
        {
            return children_term_resource::collection($data['data'])
            ->additional([
                'table' => 'children_terms', 
                'categories' => gettype($data['categories']) === 'object' ? $data['categories']->values() : $data['categories']
            ]);
        }

        return $data;


    }

    public function exclude_stop_word($queries)
    {
        //if a word is stop word ignore the iteration
        $stop_words = $this->stopWords();

        foreach($queries as $index => $word)
        {
            if(in_array($word, $stop_words))
            {
               unset($queries[$index]);
            }
        }

        return array_values($queries);

    }

    public function stopWords()
    {
        $stop_words = DB::select("SELECT * FROM INFORMATION_SCHEMA.INNODB_FT_DEFAULT_STOPWORD");

        $stop_words_array = [];

        foreach($stop_words as $word)
        {
            $stop_words_array []= $word->value;
        }
        return $stop_words_array;
    }

    public function search_submit(Request $request)
    {

        $query    = $request->q;
        $location = $request->location;
        $category = $request->category;


        $db_layterms = DB::connection(
            app(connectionManager::class)->getConnection('icd10cm_cpts_layterms_crosswalk')
        );

        if($category == 'diseases')
        {

            $type = ['type' => 'diseases'];

            $layterms = $db_layterms->table('icd10cm');
            $layterms->where('icd10cm_description', 'LIKE', "%$query%");

            $results = $layterms
            ->orderByRaw("icd10cm_description REGEXP '^$query' DESC")
            ->get(['icd10cm_description as term', 'icd10cm_code as code']);


            $layterms = $db_layterms->table('icd10cm');

            $i=0;
            foreach($results as $result)
            {
                $code = $result->code;

                //check if code has '.'
                if(strpos($code, '.'))
                {
                    $code = explode('.', $code);
                    $code = $code[0];
                }

                $condition = $i==0 ? 'where' :'Orwhere';

                $layterms->$condition('icd10cm_code', 'LIKE', "$code%");
                $i++;
            }

            $results = $layterms
            ->get(['icd10cm_description as term', 'icd10cm_code as code']);

            //make diseases response an Array
            $res = $this->diseasesToArray($results);

            //grouping diseases
            $groupedDiseases = ['data' => $this->groupDiseases($res)];

            //merge type in groupDisease
            $results = array_merge($groupedDiseases, $type);

            //return reponse
            return response()->json($results);

        }

        if($category === 'symptom')
        {

            $symptoms = DB::connection(
                app(connectionManager::class)->getConnection('anatomy')
            )->table('symptoms');

            $symptoms->join('questions', 'symptoms.id', '=', 'questions.symptom_id');
            $symptoms->join('answers', 'questions.id', '=', 'answers.question_id');

            $symptoms->select('questions.question', 'questions.id', 'answers.answer', 'answers.question_id', 'answers.id as answerId', 'answers.type as type');

            $symptoms = $symptoms->where('symptoms.name', 'LIKE', "%$query%")
            ->orderByRaw("questions.question REGEXP '^$query' DESC")
            ->get();

            $data = [];

            foreach($symptoms as $symptom)
            {
                //if already exists question in data array then skip iteration
                if(!in_array($symptom->id, array_column($data, 'id')))
                {
                    $data []= ['question' => $symptom->question, 'id' => $symptom->id];
                }

                //checking if question id in data array is matched with answer.question_id
                //and then fetch that key append to that key
                $key = array_search($symptom->question_id, array_column($data, 'id'));

                if($key !== '' or $key !== null)
                {
                    $data[$key]['answers'][] = ['question_id' => $symptom->question_id, 'answer' => $symptom->answer, 'answerId' => $symptom->answerId, 'type' => $symptom->type];
                }

            }

            //returing the response in json format
            return response()->json(['data' => $data, 'type' => 'symptom']);
        }

        if($category === 'treatment')
        {

            //make the connection
            $db = DB::connection(
                app(connectionManager::class)->getConnection('search_engine')
            );

            $children = $db->table('children_terms');
            $children->join('code', 'code.term_id', '=', 'children_terms.id');

            $children = $children->where('children_terms.name', 'LIKE', "%$query%")
            ->orderByRaw("children_terms.name REGEXP '^$query' DESC");

            $results = $children->get(['children_terms.name', 'code.code']);

            if(!count($results)) {
                return "No record found";
            }

            return response()->json(
                ['data' => $results, 'type' => 'treatment']
            );
        }

    }

    public function diseasesToArray($results)
    {
        $res = [];

        foreach($results as $result)
        {
            $res []= ['code' => $result->code, 'term' => $result->term];
        }

        return $res;

    }

    public function groupDiseases($res)
    {

        $array = [];

        for($i=0; $i<count($res); $i++)
        {
            $response = $res[$i];
            $code = $response['code'];

            if(strpos($code, '.'))
            {
                //dotted values which are children
                $code_splits = explode('.', $code);
                $code_splits = $code_splits[0];

                $key = array_search($code_splits, array_column($array, 'code'));

                if($key!=='' or $key !==null)
                {
                    $array[$key]['children'][] = ['code' => $code, 'term' => $response['term']];
                }
            }
            else
            {
                //parent values
                if(!in_array($code, array_column($array, 'code')))
                {
                    $array[] = ['code' => $code, 'term' => $response['term']];
                }
            }
        }

        return $array;

    }//groupDiseases

    public function searchAndFetchCptLayterms(Request $request)
    {

        $term = $request->term;
        $category = $request->category;

        if($category == -1) $category = 6;
    
        /*
            # we are again searhing all data beacuse we dont know what
            # he typed in search box it could be term, children_term,
            # category, part or code then we must have to identify it
            # and its possibility that he did'nt select choice in search box
        */

        $data = $this->getTreatmentsData($term, $category);

        $cpts = $this->getTermsCodesAndParts($data);

        return response()->json($cpts);

    }

    public function getTermsCodesAndParts($terms)
    {
        $cpts = [];
        foreach($terms as $term)
        {
            $codes = $term->codes()->orderByFrequency()->get();
            foreach($codes as $code)
            {
                $cpts []= [
                    'codes' => $code,
                    'parts' => $code->parts
                ];
            }
        }
        return $cpts;
    }

    public function getTreatmentsData($term, $category)
    {
        $treatment = new treatment;
        $queries = explode(' ', $term);
        $search_words = $this->exclude_stop_word($queries);
        return $treatment->get($search_words, $term, $category)['data'];
    }

    public function searchAndFetchCpts(Request $request)
    {

        $term = json_decode($request->term, true);
        $icd = $term['code'];

        $category = $request->category;

        $db = DB::connection(
            app(connectionManager::class)->getConnection('search_engine')
        );

        $category_id = $db->table('categories_cpts_crosswalk');
        $codes_from_categories = $category_id->where('name', $category)->get(['cpt']);

        $category_codes = [];

        foreach($codes_from_categories as $code)
        {
           $category_codes []= $code->cpt;
        }
        //look for 0 and 00 both in last icd character e.g A30.0 and A30.00
        $icd_another = $icd[-1] == '0' ? $icd."0" : '';

        $db = DB::connection(
            app(connectionManager::class)->getConnection('icd10cm_cpts_layterms_crosswalk')
        );
        $table = $db->table('icd_cpts_crosswalk');
        $codes_from_crosswalk = $table->where('icd_id', $icd)
        ->Orwhere('icd_id', $icd_another)
        ->get(['cpt_id']);

        $crosswalk_codes = [];

        foreach($codes_from_crosswalk as $code)
        {
           $crosswalk_codes []= $code->cpt_id;
        }

        $codes = [];

        if(count($crosswalk_codes) > 0)
        {
            foreach($crosswalk_codes as $code)
            {
                //if crosswalk code is available in category code then pop in to codes array
                if(in_array($code, $category_codes))
                {
                    $codes[]= $code;
                }
            }

            return response()->json($codes);
        }
        return response()->json('No code found');
    }

}
