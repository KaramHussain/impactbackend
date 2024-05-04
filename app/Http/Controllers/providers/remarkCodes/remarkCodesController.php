<?php

namespace App\Http\Controllers\providers\remarkCodes;

use App\Http\Controllers\Controller;
use App\remark_code;

class remarkCodesController extends Controller
{

    public function remarkCodes($codes)
    {
        $remark_codes = remark_code::query();

        if(in_array('low_fruit', $codes))
        {
            $remark_codes->where('low_fruit', 1);
        }

        if(in_array('avoidable', $codes))
        {
            $remark_codes->where('avoidable', 1);
        }

        if(in_array('compliance', $codes))
        {
            $remark_codes->where('compliance', 1);
        }

        return $remark_codes->get(['id']);
    }

}
