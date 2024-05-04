<?php

namespace App\Http\Controllers\AnatomyController;

use App\Http\Controllers\AnatomyController\AnatomyController;

class agesController extends AnatomyController
{

    public function setAge($age)
    {
        if($age >= 0 && $age <= 1)
        {
            return '0-1';
        }
        if($age > 1 && $age <= 17)
        {
            return '1-17';
        }
        if($age > 17)
        {
            return '18-124';
        }
    }

}
