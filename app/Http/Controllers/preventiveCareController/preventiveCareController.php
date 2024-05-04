<?php

namespace App\Http\Controllers\preventiveCareController;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\manager\connectionManager;

use App\preventiveCare\{
    services,
    excludes,
    questions,
    ageGroup,
    frequency,
    preventive_service_deps,
    gender
};

//helping controllers
use App\Http\Controllers\preventiveCareController\{
    agesAndGenderController,
    servicesController,
    frequenciesController
};


class preventiveCareController extends Controller
{

    public $skipped = false;
    public $notfound = false;
    public $connection;

    public function __construct()
    {
        $this->connection = app(connectionManager::class)->getConnection('preventive_care');
    }

    public function save_a_life_step($step, Request $request)
    {

      $dependencies = new preventive_service_deps;
      $ages = new ageGroup;
      $service_obj = new services;
      $excludes = new excludes;
      $questions = new questions;
      $freq = new frequency;

      if($step == 2)
      {

        $ageController = new agesAndGenderController;
        $service_ids = $ageController->agesAndGender($request);

        $serviceController = new servicesController;
        $services = $serviceController->services($request, $service_ids);

        return response()->json($services);
      }
      //step 3 and 4 are served
      if($step == 3)
      {

        $type = 'questions';
        $excludesController = new excludesController;
        $excludes = $excludesController->excludes($request);

        if(!empty($excludes))
        {
            return response()->json(['data' => $excludes, 'type' => 'excludes']);
        }

        $questionsController = new questionsController;
        $questions = $questionsController->questions($request);
        return response()->json(['data' => $questions, 'type' => $type]);

      }
      //excludes found then fetch questions and subtract services based on excludes
      if($step == 4)
      {

        $services = $request->services;
        $excludes = $request->excludes;

        if(!empty($excludes))
        {
            $cpt_ids = $this->subtract_services($dependencies, $services, $excludes);
        }
        else
        {
            $cpt_ids = $this->fetchdeps($services);
        }

        $services = new servicesController;
        $availedServices = array_values(array_unique($services->fetchServiceIdsFromIds($cpt_ids)));

        $availedServices = $services->services($request, $availedServices);

        $questionsController = new questionsController;
        $questions = $questionsController->questions($request);

        return response()->json(['data' => $questions, 'services' => $availedServices]);

      }

      if($step == 5)
      {

        $services = $request->services;

        $frequenciesController = new frequenciesController;
        $servicesAndFrequencies = $frequenciesController->fetchFrequenciesWithServices($services);

        return response()->json($servicesAndFrequencies);

      }

      if($step == 6)
      {

        $services = $request->services;
        $frequenciesController = new frequenciesController;
        $servicesAndFrequencies = $frequenciesController->fetchFrequenciesWithServices($services);

        return response()->json($servicesAndFrequencies);

      }

      if($step == 7)
      {

        $services = $request->services;

        if($request->has('frequencies'))
        {

            $frequencies = $request->frequencies;

            $frequenciesController = new frequenciesController;
            $frequency_cpts_array = $frequenciesController->getCodesFromFrequencies($frequencies);

        }

        $cpt_ids = $this->fetchServices($services);
        $service_ids = [];

        foreach($cpt_ids as $cpt)
        {
            $service_ids []= $cpt->id;
        }

        $cpts_from_services = array_keys($this->fetchdeps($service_ids));

        if($request->has('frequencies'))
        {
            $cpts = array_diff($cpts_from_services, $frequency_cpts_array);
        }
        else
        {
            $cpts = $cpts_from_services;
        }

        return response()->json($cpts);
      }


    }//save a life step

    public function fetchCptsFromServicesAndAgesAndGender($services)
    {
        $code_ids = array();
        if(count($services))
        {

          //$age    = request()->session()->get('age');
          //$gender = request()->session()->get('gender');

          $age = request()->age;
          $gender = request()->gender;

          $ages = new ageGroup;
          $ages = $this->calculate_ages($ages, $age);

          $db = DB::connection($this->connection);
          $cpts = $db->table('preventive_service_deps');

          for ($i=0; $i < count($services); $i++)
          {

            $condition = $i == 0 ? 'where' : 'orWhere';

            $cpts->$condition('service_id', '=', json_decode($services[$i], true))->where(
            function($query) use($ages)
              {
                for ($j=0; $j < count($ages) ; $j++){
                  $condition = $j == 0 ? 'where' : 'orWhere';
                  $query->$condition('age', '=', $ages[$j]);
                }

              }
            )->where(function($query) use ($gender){
              $query->where('gender','=',$gender)->orWhere('gender','=',3);
            });

          }

          $cpts = $cpts->get();//fetching cpts from user selected services
          $code_ids = array();

          foreach ($cpts as $cpt)
          {
            $code_ids []= $cpt->id;
          }
          return $code_ids;
      }
    }

    public function deleteCptsAccordingToFrequencies($from, $to)
    {

      $values = array_values($to);
      $keys = array_keys($to);

      $table = DB::connection($this->connection)->table('preventive_service_deps');
      $once = false;

      for($i=0; $i < count($keys); $i++)
      {

        for ($j=0; $j < count($values); $j++)
        {

          for($k = 0; $k < count($values[$j]); $k++)
          {

            $value = $values[$j][$k];

            if($value !=0)
            {

              $condition = $once == false ? 'where' : 'orWhere';
              $table->$condition('service_id', '=', $keys[$i])->where('frequency_id', '=',$value);
              $once = true;

            }//if

          }//for

        }//for

      }//for

      $to = array();

      foreach ($table->get(['code_id']) as $cpt)
      {
        $to []= $cpt->code_id;
      }

      $from = $this->fetchCpts($from);

      //minus the cpt_codes selected from frequencies in specific service from services stored

      return array_diff($from, $to);

    }

    public function fetchCpts($service_ids)
    {
      $cpts = array();
      $db = DB::connection($this->connection);
      $table = $db->table('preventive_service_deps');

      for($i=0; $i<count($service_ids); $i++)
      {
        $condition = $i==0 ? 'where' : 'orWhere';
        $table->$condition('service_id', '=', $service_ids[$i]->service_id);
      }

      foreach($table->get() as $cpt)
      {
        $cpts []= $cpt->code_id;
      }

      return $cpts;

    }

    public function fetchdeps($cpt_ids)
    {

        $services = array();

        $freqs = DB::connection($this->connection)->table('preventive_service_deps');

        for($i=0; $i<count($cpt_ids); $i++)
        {
            $condition = $i == 0 ? 'where' : 'orWhere';
            $freqs->$condition('service_id', json_decode($cpt_ids[$i], true));
        }

        //fss == frequencyServices
        foreach ($freqs->get() as $fss)
        {

            $services []= $fss->service_id;
            $codes [$fss->code_id] = [$fss->service_id => $fss->frequency_id];

        }

        return $codes;

    }

    public function fetchIdsFromPreventive($code_ids)
    {
      $ids = array();

      $obj_ids = DB::connection($this->connection)->table('preventive_services');

      for($i=0; $i < count($code_ids); $i++)
      {
        $condition = $i==0 ? 'where' : 'orWhere';
        $obj_ids->$condition('preventive_code', $code_ids[$i]);
      }

      foreach ($obj_ids->get(['id']) as $id)
      {
        $ids []= $id->id;
      }
      return $ids;
    }

    public function fetchFrequencies($ids)
    {

      $freq = DB::connection($this->connection)->table('frequency');

      for($i=0; $i<count($ids); $i++)
      {
        $condition = $i==0 ? 'where' : 'orWhere';
        $freq->$condition('id', '=', $ids[$i]);
      }

      return $freq->get();

    }

    public function subtract_services(preventive_service_deps $deps, array $from, array $to)
    {

      $cpt_ids = array();

      $service_cpts = array();
      $exclude_cpts = array();

      for($i=0; $i<count($from); $i++)
      {
        $cpts = $deps->where('service_id', json_decode($from[$i], true))->get(['code_id']);
        foreach ($cpts as $cpt)
        {
          $service_cpts []= $cpt->code_id;
        }
      }

      for($i=0; $i<count($to); $i++)
      {
        $cpts = $deps::where('exclude_id', json_decode($to[$i], true))->get(['code_id']);
        foreach ($cpts as $cpt)
        {
          $exclude_cpts []= $cpt->code_id;
        }
      }

      $exclude_cpts = array_values(array_unique($exclude_cpts));
      $service_cpts = array_values(array_unique($service_cpts));

      //subtract the exclude cpts from service cpts

      $cpts = array_values(array_filter(array_diff($service_cpts, $exclude_cpts)));

      $prevent = DB::connection($this->connection)->table('preventive_services');

      for($i=0; $i<count($cpts);$i++)
      {
        $condition = $i == 0 ? 'where' : 'Orwhere';
        $cpt_id = $prevent->$condition('preventive_code', $cpts[$i]);
      }

      foreach($cpt_id->get(['id']) as $id)
      {
        $cpt_ids[] = $id->id;
      }

      return $cpt_ids;

    }


    public function fetchQuestions(questions $q, array $cpt_ids)
    {

      $key_questions = array();

      //if select services
      //fetch service_cpts and fetch exludes cpts subtract service - exludes then fetch questions against cpts remained

      //else fetch questions according to service cpts

      for($i=0;$i<count($cpt_ids);$i++)
      {
        $current = trim($cpt_ids[$i]);
        $questions = $q::where('code_id', $current)->get();
        foreach($questions as $question)
        {
          $key_questions[$question->code_id] = $question->questions;
        }
      }

      return $key_questions;
    }


  public function fetchServices($service_ids)
  {
    $service = array();

    if(!empty($service_ids))
    {
      $db = DB::connection($this->connection);
      $services = $db->table('service')->leftJoin('service_definition', 'service.id', '=', 'service_definition.service_id');

      for($i=0;$i<count($service_ids);$i++)
      {
        $condition = $i == 0 ? 'where' : 'orWhere';
        $services->$condition('service.id', json_decode($service_ids[$i], true));
      }

      $service = $services->get();

    }//empty

    return $service;

  }



  public function calculate_ages(ageGroup $ages, $user_age)
  {

    $age_group_ids = array();
    $age_group = $ages::all();

    if (count($age_group))
    {

      foreach ($age_group as $age)
      {

        if (strpos($age->age_group, '-'))
        {
          /*
          explode it with -
          check if age is greater than or equal to starting and less or equal to end
          if yes push that age id in array
          */
          $age_group = explode('-', $age->age_group);
          if($user_age >= $age_group[0] and $user_age <= $age_group[1])
          {
            $age_group_ids []= $age->id;
          }
        }

        else if(strpos($age->age_group,'+'))
        {
          /*
          if user age is greater than push this age id to that one
          */
          $data_age = (int) $age->age_group;
          if ($user_age > $data_age)
          {
            $age_group_ids []= $age->id;
          }
        }

        else if(strtolower($age) == 'all')
        {
          $age_group_ids []= $age->id;
        }

      }

    }//age_group

    return $age_group_ids;

}//calculate age

}//class
