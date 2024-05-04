<?php

namespace App;

use App\master_directory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class master_directories_npi_cw extends Model
{
    use HasFactory;

    protected $table = 'master_directories_npi_cw';

    public function master_directory() 
    {
        return $this->belongsTo(master_directory::class, 'npi');
    }

}
