<?php

namespace App\Http\Controllers\preventiveCareController;

use Illuminate\Http\Request;

class finalCptsController extends preventiveCareController
{

    public function finalCpts(Request $request)
    {

      $array = $request->except('_token','next');
      $services = $array['service_id'];
      $servicesAndFreqs = array();

      foreach ($services as $service)
      {
        if(isset($array[$service]))
        {
          $servicesAndFreqs[$service] = $array[$service];
        }
        else
        {
          $servicesAndFreqs[$service] = [0];
        }
      }

      $remaining_services = $request->session()->get('remaining_services_after_freqs_cancel');

      $cpts = $this->deleteCptsAccordingToFrequencies($remaining_services, $servicesAndFreqs);

    //   return view('preventive_care.preventive_care_step')->with([
    //     'title'   => $this->title,
    //     'step'    => $step,
    //     'cpts'    => $cpts
    //   ]);

    }
}
