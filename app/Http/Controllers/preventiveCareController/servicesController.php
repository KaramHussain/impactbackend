<?php

namespace App\Http\Controllers\preventiveCareController;

use DB;
use Illuminate\Http\Request;

class servicesController extends preventiveCareController
{

    public function fetch($id)
    {
        $db = DB::connection($this->connection);
        $table = $db->table('service');

        return $table->where('id', $id)->get();
    }

    public function fetchServiceIdsFromIds($ids)
    {

      $service_ids = array();
      $table = DB::connection($this->connection)->table('preventive_service_deps');

      for($i=0; $i<count($ids); $i++)
      {
        $condition = $i==0 ? 'where' : 'Orwhere';
        $table->$condition('id', '=', $ids[$i]);
      }

      foreach ($table->get(['service_id']) as $service)
      {
        $service_ids []= $service->service_id;
      }

      return $service_ids;

    }

    public function services(Request $request, $service_ids)
    {

      //fetching Services
      $services = $this->fetchServices($service_ids);
      return $services;

      session(['services' => $services]);

      $get_request = $request->isMethod('get');

      if(Session::exists('services') and $get_request)//method of http is get
      {
        $services = $request->session()->get('services');
      }

      $user_selected = array();//empty array bydefault

      if(Session::exists('user_selected_services'))
      {
        $user_selected = $request->session()->get('user_selected_services');
      }

      //return $user_selected;
    //   return view('preventive_care.preventive_care_step')->with([
    //     'title'    => $this->title,
    //     'step'     => $step,
    //     'services' => $services,
    //     'user_selected_services' => $user_selected
    //   ]);

    }//services


  public function fetchServices($service_ids)
  {
    $service = array();

    if(!empty($service_ids))
    {

      $db = DB::connection($this->connection);

      $services = $db->table('service')->leftJoin('service_definition', 'service.id', '=', 'service_definition.service_id');

      for($i=0; $i<count($service_ids); $i++)
      {
        $condition = $i == 0 ? 'where' : 'orWhere';
        $services->$condition('service.id', $service_ids[$i]);
      }

      $service = $services->get();

    }//empty

    return $service;

  }

}
