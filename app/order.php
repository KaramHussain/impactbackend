<?php

namespace App;

use App\{checkout, invoice, User};
use App\claims\claim;
use App\Events\order\orderCreated;
use App\filters\orders\orderFilters;
use App\insurance\patient_insurance;
use App\payments\paymentMethod;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


class order extends Model
{
    protected $fillable = [
        'order_id',
        'order_status',
        'payment_method_id',
        'insurance',
        'created_at',
        'total'
    ];

    public $timestamps = false;

    protected $dates = [
        'created_at'
    ];

    public function scopeFilter(Builder $builder, Request $request, array $filters = [])
    {
        return (new orderFilters($request))->add($filters)->filter($builder);
    }

    public function status($key)
    {
        $status = [
            'processing'       => 'processing',
            'completed'        => 'completed',
            'payment_failed'   => 'payment_failed'
        ];

        return isset($status[$key]) ? $status[$key] : null;
    }

    public function generate($auth, $payment_method_id, $insurance = null)
    {
        $order = $auth->order()->create([
            'order_id'          => $this->getKey(),
            'order_status'      => $this->status('processing'),
            'payment_method_id' => $payment_method_id,
            'insurance'         => $insurance,
            'created_at'        => now(),
            'total'             => $this->total($auth)
        ]);

        //Fire an event that order is created
        event(new orderCreated($order));

        return $order;
    }

    public function getKey()
    {
        $key = substr(md5(time()), 0, 6);
        return $this->key = date('ymd').$key;
    }

    public function checkout()
    {
        return $this->hasMany(checkout::class);
    }

    public function invoices()
    {
        return $this->hasMany(invoice::class);
    }

    public function insurance_plan()
    {
        return $this->belongsTo(patient_insurance::class, 'insurance');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(paymentMethod::class);
    }

    public function claims()
    {
        return $this->hasMany(claim::class);
    }

    public function total($user = null)
    {
        $cartItems = !$user ? $this->user->cart : $user->cart;
        $total = 0;
        foreach($cartItems as $item)
        {
            $price = $item->purchase_cost;
            if($item->negotiated_cost != null && $item->negotiated_cost != '' && $item->negotiated_cost != 0)
            {
                $price = $item->negotiated_cost;
            }
            
            $radiology_fee = (float) $this->should_add_charges($item, 'radiology') ? $item->charges_details['radiology']['fee'] : 0;
            
            $pathology_fee = (float) $this->should_add_charges($item, 'pathology') ? $item->charges_details['pathology']['fee'] : 0;

            $cosurg_fee = (float) $this->should_add_charges($item, 'cosurg_details') && $item->charges_details['cosurg_details'] ? $item->charges_details['cosurg_details']['fee'] : 0;
            
            $hidden_charges = $item->hidden_charges !== null && $this->should_add_charges($item, 'hidden_charges') ? $item->hidden_charges : 0;
            
            $evob_charges = $item->add_evob_charges ? $item->evob_charges : 0;

            $facility_expenses = (float) ($this->should_add_charges($item, 'facility_expenses')) ? $item->facility_expenses : 0;

            $anesthesia_fee = (float) ($this->should_add_charges($item, 'anesthesia')) ? $item->anesthesia_fee : 0;
            
            $price += 
            $hidden_charges + 
            $anesthesia_fee + 
            $facility_expenses + 
            $evob_charges + 
            $radiology_fee + 
            $pathology_fee +
            $cosurg_fee;

            $total += $price;
        }
        return (int) ceil($total);
    }

    public function should_add_charges($item, $type) 
    {
        return $item->charges_details['added_charges_list'][$type];
    }


}
