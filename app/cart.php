<?php

namespace App;

use App\{User};
use App\doctors\doctor;
use App\manager\connectionManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\shoppingWindowController;

class cart extends Model
{

    const ANESTHESIA_FEE = 15;
    const FACILITY_EXPENSES = 20;
    protected $table = 'cart';

    protected $fillable = [
        'user_id',
        'doctor_id',
        'cpt',
        'date_of_appointment',
        'time_of_appointment',
        'date_of_booking',
        'average_cost',
        'purchase_cost',
        'saved_cost',
        'negotiated_cost',
        'anesthesia_fee',   
        'facility_expenses',
        'hidden_charges',
        'add_evob_charges',
        'charges_details',
        'category'
    ];

    protected $casts = [
        'doctor_id'          => 'integer',
        'user_id'            => 'integer',
        'average_cost'       => 'double',
        'saved_cost'         => 'double',
        'anesthesia_fee'     => 'double',
        'facility_expenses'  => 'double',
        'bunlde_treatment'   => 'double',
        'charges_details'    => 'array'
    ];

    protected $appends = [
        'treatment',
        'appointment_date',
        'doctor'
    ];

    protected $hidden = [
        'cpt',
        'doctor_id',
        'user_id',
        'date_of_appointment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTreatmentAttribute()
    {
        $shopping = new shoppingWindowController;
        $description = $shopping->getDescriptionOfCptCode(request(), $this->cpt);

        return ($description->original[0]->cpt_code_full_description);
    }

    public function getAppointmentDateAttribute()
    {
        return rtrim($this->date_of_appointment, ' 00:00:00');
    }

    public function getDoctorAttribute()
    {
        return doctor::where('id', $this->doctor_id)
        ->get()->first();
    }

    public function empty()
    {
        return optional($this->cart)->toArray();
    }

}
