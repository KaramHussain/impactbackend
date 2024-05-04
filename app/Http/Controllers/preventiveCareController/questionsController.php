<?php

namespace App\Http\Controllers\preventiveCareController;

use DB;
use Illuminate\Http\Request;

class questionsController extends preventiveCareController
{

    public function questions(Request $request)
    {

        //now find questions
        $services = $request->services;
        $code_ids = $this->fetchCptsFromServicesAndAgesAndGender($services);

        return $this->fetchQuestionsFromCodes($code_ids);

        // if ($request->session()->get('notfound') == false)//exludes found
        // {
        //     (array) $excludes = $request['excludes'];

        //     session(['user_selected_excludes' => $excludes]);

        //     if (count($excludes))
        //     {

        //         $services = $request->session()->get('user_selected_services');
        //         $cpt_ids = $this->subtract_services($dependencies, $services, $excludes, $preventive_services);

        //         //fetch questions according to exludes selected
        //         $questions = $this->fetchQuestions($questions, $cpt_ids);
        //         $questions = array_unique($questions);

        //         session(['questions' => $questions]);
        //         session(['cpt_ids_after_subtract_services' => $cpt_ids]);

        //         // return view('preventive_care.preventive_care_step')->with([
        //         //   'title'     => $this->title,
        //         //   'step'      => $step,
        //         //   'questions' => $questions
        //         // ]);
        //     }

        // }

        // if($request->session()->get('notfound') == true)//exludes not found
        // {
        //     //now found questions according to session of servies selected by user

        //     $code_ids = $request->session()->get('code_ids');

        //     $questions = $this->fetchQuestionsFromCodes($code_ids);

        //     session(['questions' => $questions]);

        //     // return view('preventive_care.preventive_care_step')->with([
        //     //   'title'     => $this->title,
        //     //   'step'      => $step,
        //     //   'questions' => $questions
        //     // ]);

        // }

    }//questions

    public function fetchQuestionsFromCodes($service_ids)
    {

      $service_cpts = array();
      $cpt_ids = array();

      $db = DB::connection($this->connection);
      $cpts = $db->table('questions');

      for($i=0; $i<count($service_ids); $i++)
      {
        $condition = $i == 0 ? 'where' : 'orWhere';
        $cpts->$condition('code_id', $service_ids[$i]);
      }

      foreach($cpts->get() as $cpt)
      {
        $cpt_ids[$cpt->code_id] = $cpt->questions;
      }

      $cpt_ids = array_unique($cpt_ids);

      return $cpt_ids;

    }
}
