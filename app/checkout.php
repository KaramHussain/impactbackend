<?php

namespace App;

use DB;
use App\{order, User};
use App\doctors\doctor;
use App\doctors\doctorTreatments;
use App\Http\Controllers\layterms\laytermsController;
use App\Http\Controllers\shoppingWindowController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class checkout extends Model
{

    protected $fillable = [
        'order_id',
        'doctor_id',
        'user_id',
        'cpt',
        'date_of_appointment',
        'time_of_appointment',
        'date_of_booking',
        'average_cost',
        'purchase_cost',
        'negotiated_cost',
        'saved_cost',
        'anesthesia_fee',
        'facility_expenses',
        'hidden_charges',
        'charges_details',
        'category'
    ];

    protected $appends = [
        'doctor',
        'doctor_treatments',
        'doctor_address',
        'treatment_description',
        'category',
        'icds'
    ];

    protected $casts = [
        'charges_details' => 'array'
    ];

    public function order()
    {
        return $this->belongsTo(order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDoctorAttribute()
    {
        $doctor = new doctor;
        return $doctor->findById($this->doctor_id);
    }

    public function getDoctorAddressAttribute()
    {
        return $this->doctor->address;
    }

    public function getTreatmentDescriptionAttribute()
    {
        $shop = new shoppingWindowController;
        $desc = optional($shop->getDescriptionOfCptCode(request(), $this->cpt))->original;
        if(is_array($desc) || is_object($desc))
        {
            return $desc->first()->cpt_code_full_description;
        }
        return null;
    }

    public function getDoctorTreatmentsAttribute()
    {
        if($this->doctor)
        {
           $treatment = doctorTreatments::
            where('all_codes', $this->cpt)
            ->where('npi', $this->doctor->npi)
            ->get();

            if(count($treatment))
            {
                return $treatment->first();
            }
        }
        return [];
    }

    public function getCategoryAttribute()
    {
        $laytermsController = new laytermsController;
        return $laytermsController->getCodeCategory($this->cpt);
    }

    public function getIcdsAttribute()
    {
        $laytermsController = new laytermsController;
        return $laytermsController->getCodeIcds($this->cpt);
    }

}
