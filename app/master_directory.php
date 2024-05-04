<?php

namespace App;

use App\master_directories_npi_cw;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class master_directory extends Model
{
    use HasFactory;

    public function cw() 
    {
        return $this->hasOne(master_directories_npi_cw::class, 'npi');
    }

}
