<?php

namespace App\Http\Controllers\preventiveCareController;

use DB;
use Illuminate\Http\Request;

class excludesController extends preventiveCareController
{

    public function excludes(Request $request)
    {

      $excludes = array();

      if ($request['services'])
      {

        (array) $services = $request['services'];

        session(['user_selected_services' => $services]);

        $code_ids = $this->fetchCptsFromServicesAndAgesAndGender($services);

        session(['code_ids' => $code_ids]);//cpt_codes against user selected services

        //fetch exlude ids
        $exclude_ids = $this->fetchExcludesFromIds($code_ids);

        if(!empty($exclude_ids))
        {
            //fetching original excludes
            $excludes = $this->fetchExcludes($exclude_ids);
        }

      }

      return $excludes;

      if (empty($excludes))
      {

        //session(['notfound'=>true]);
        //return redirect('preventive-care/step/4');
      }
      else
      {

        session(['excludes' => $excludes]);

        // return view('preventive_care.preventive_care_step')->with([
        //   'title'    => $this->title,
        //   'step'     => $step,
        //   'excludes' => $excludes
        // ]);

      }

    }//excludes

    public function fetchExcludes($exclude_ids)
    {

      $excludes = array();

      if(!empty($exclude_ids))
      {

        $db = DB::connection($this->connection);

        $exclude = $db->table('excludes');

        //$gender = request()->session()->get('gender');

        $gender = request()->gender;

        for($i=0; $i<count($exclude_ids);$i++)
        {
          $condition = $i == 0 ? 'where' : 'orWhere';
          $exclude->$condition('id', $exclude_ids[$i])->where(function($query) use ($gender) {
            $query->where('gender','=',$gender)->orWhere('gender', '=', 3);
          });
        }

        $excludes = $exclude->get();

      }
      return $excludes;

    }

    public function fetchExcludesFromIds($code_ids)
    {

      $exclude_ids = array();
      $db = DB::connection($this->connection);
      $excludes = $db->table('preventive_service_deps');

      for($i=0; $i<count($code_ids); $i++)
      {

        $condition = $i == 0 ? 'where' : 'orWhere';
        $excludes->$condition('id', $code_ids[$i]);

      }

      foreach ($excludes->get(['exclude_id']) as $exclude_id)
      {
        if($exclude_id->exclude_id != 0)
        {
          $exclude_ids []= $exclude_id->exclude_id;
        }
      }

      return $exclude_ids;
    }


}
