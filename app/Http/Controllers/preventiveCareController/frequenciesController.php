<?php

namespace App\Http\Controllers\preventiveCareController;

use DB;
use Illuminate\Http\Request;

class frequenciesController extends preventiveCareController
{

    public function fetchFrequenciesWithServices($services)
    {

        $db = DB::connection($this->connection);
        $deps = $db->table('preventive_service_deps');

        $deps->join('service', 'service.id', '=', 'preventive_service_deps.service_id');
        $deps->join('frequency', 'frequency.id', '=', 'preventive_service_deps.frequency_id');

        $deps->select('service.id as service_id', 'service.service', 'frequency.id as frequency_id', 'frequency.frequency');

        $i=0;
        foreach($services as $service)
        {
            $condition = $i == 0 ? 'where' : 'Orwhere';
            $deps->$condition('preventive_service_deps.service_id', $service);
            $i++;
        }

        return $deps->distinct()->get();

    }

    public function getCodesFromFrequencies($frequencies)
    {

        $db = DB::connection($this->connection);
        $deps = $db->table('preventive_service_deps');

        $i=0;
        foreach($frequencies as $term)
        {
            $term = json_decode($term, true);

            $frequency_id = $term['frequency_id'];
            $service_id = $term['service_id'];

            $condition = $i==0 ? 'where' : 'Orwhere';
            $deps->$condition(function($query) use($service_id, $frequency_id) {
                $query->where('service_id', $service_id)->where('frequency_id', $frequency_id);
            });

            $i++;
        }

        $cpts_from_frequency = $deps->get(['code_id']);

        $frequency_cpts_array = [];

        foreach($cpts_from_frequency as $freq)
        {
            $frequency_cpts_array []= $freq->code_id;
        }

        return $frequency_cpts_array;
    }

    public function fetch($id)
    {

        $db = DB::connection($this->connection);
        $table = $db->table('frequency');

        return $table->where('id', $id)->get();

    }

    public function frequenciesAvailedSection(Request $request)
    {

      (array) $questions = $request['questions'];

      session(['user_selected_questions' => $questions]);

      $ids = array();

      $services = array();
      $frequencies = array();

      if(!$request->session()->get('notfound'))//exludes found
      {
        $cpt_ids = $request->session()->get('cpt_ids_after_subtract_services');
        $cpt_ids = fetchServiceIdsFromIds($cpt_ids);
      }
      else
      {
        $cpt_ids = $request->session()->get('user_selected_services');
      }

      $services = $this->fetchServices($cpt_ids);
      $codes = $this->fetchdeps($cpt_ids);

      //putting codes in session
      session(['cpts_service_freq' => $codes]);

    //   return view('preventive_care.preventive_care_step')->with([
    //     'title'     => $this->title,
    //     'step'      => $step,
    //     'services' => $services
    //   ]);


    }

    public function whichFrequencySection(Request $request, $cpts)
    {

      //$cpts = $request->session()->get('cpts_service_freq');
      $services = $request->services;

      $cpt_codes = array();
      $cptsAndServices = array();

      $service_deps = DB::connection($this->connection)->table('preventive_service_deps');

      foreach($services as $service => $value)
      {

        if ($value == 1)
        {
          foreach ($cpts as $sandf)//sandf means services and frequencies
          {

            foreach ($sandf as $service_from_array => $frequency)
            {

              if ($service_from_array == $service and $frequency == 82)
              {

                $service_deps->where('service_id', $service_from_array)->where('frequency_id', $frequency);

                foreach ($service_deps->get(['code_id']) as $cpt)
                {
                    $cpt_codes []= $cpt->code_id;
                }

              }

            }//foreach

          }
        }

      }//foreach

      //unset the cpt codes which have frequency 'once in a life'

      for($i=0; $i<count($cpt_codes); $i++)
      {
        unset($cpts[$cpt_codes[$i]]);
      }

      $service_ids = array();
      $frequency_ids = array();

      foreach($cpts as $array)
      {
        foreach($array  as $service => $frequency)
        {
          $service_ids []= $service;
        }
      }

      $service_ids = array_values(array_unique($service_ids));

      $services = $this->fetchServices($service_ids);
      return $services;

      session(['remaining_services_after_freqs_cancel' => $services]);

    //   return view('preventive_care.preventive_care_step')->with([
    //     'title'     => $this->title,
    //     'step'      => $step,
    //     'services'  => $services,
    //     'class'     => $this
    //   ]);

    }//whichFrequencySection
}
