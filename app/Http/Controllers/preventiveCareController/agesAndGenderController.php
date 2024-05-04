<?php

namespace App\Http\Controllers\preventiveCareController;

use DB;
use Illuminate\Http\Request;
//use App\Http\Controllers;
use App\preventiveCare\ageGroup;

class agesAndGenderController extends preventiveCareController
{

  public function agesAndGender(Request $request)
  {

    $service_ids = array();

    if($request['age'] and $request['gender'])
    {

      $age = $request['age'];
      $gender = $request['gender'];
      $both = 3; //id for both genders
      $ages = new ageGroup;

      $db = DB::connection($this->connection);

      $validate = $request->validate([
        'age' => 'required'
      ]);

      if ($validate)
      {
        // putting values to session
        session(
          [
            'age'    => $request['age'],
            'gender' => $request['gender']
          ]);

        //fetch age groups
        $ageGroups = $this->calculate_ages($ages, $age);

        //fetch_services
        $deps = $db->table('preventive_service_deps');

        for ($i=0; $i < count($ageGroups); $i++)
        {

          $condition = $i ==0 ? 'where' : 'orWhere';

          $deps->$condition('age', '=', $ageGroups[$i])
          ->where(function($query) use ($both, $gender) {
            $query->where('gender','=',$gender)->orwhere('gender','=',$both);
          });

        }

        foreach($deps->get() as $service_id)
        {
          $service_ids []= $service_id->service_id;
        }

        $service_ids = array_values(array_unique($service_ids));

      }//if validate age

    }//in age and gender selection


    return $service_ids;


  }//agesAndGender


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

}
