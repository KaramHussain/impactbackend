<?php

namespace App\doctors;

use App\doctors\doctor;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\filters\treatments\treatmentFilters;
use App\manager\connectionManager;

class doctorTreatments extends Model
{
    protected $connection;
    protected $table = 'cpt_codes';
    public $carepays_rate = 70;

    public function __construct()
    {
        $this->connection = app(connectionManager::class)->getConnection('mur');
    }

    protected $appends = [
        'out_of_pocket_cost',
        'market_rate',
        'purchase_cost',
        'average_cost',
        'average_saved',
        'covered_cost'
    ];

    public function doctor()
    {
        return $this->belongsTo(doctor::class, 'npi');
    }

    public function scopeFilter(Builder $builder, Request $request, array $filters = [])
    {
        return (new treatmentFilters($request))
                ->add($filters)
                ->filter($builder);
    }

    public function findById($id)
    {
        $treatment = $this->where('id', $id)->get();
        return optional($treatment)->first();
    }

    public function getOutOfPocketCostAttribute() // patient responsibility
    {
        //avg_medicare_payment_amount == net paid
        $cost = (float)($this->avg_medicare_allowed_amount - $this->avg_medicare_payment_amount);
        return number_format($cost, 2, '.', '');
    }

    public function getMarketRateAttribute()
    {
        $cost = (float) ($this->avg_medicare_payment_amount / $this->carepays_rate);
        $cost = 100 * $cost;
        return number_format($cost, 2, '.', '');
    }

    public function getAverageCostAttribute()
    {
        $cost = (float) $this->avg_submitted_charge_amount;
        return number_format($cost, 2, '.', '');
    }

    public function getPurchaseCostAttribute() // purchase cost is 90% of avg_submitted_charge_amount
    {
        $cost = (float) (($this->average_cost * 90) / 100);
        return number_format($cost, 2, '.', '');
    }

    public function getAverageSavedAttribute() // average saved is 10 percent of doctor charge amount
    {
        $cost = (float) (($this->average_cost * 10) / 100);
        return number_format($cost, 2, '.', '');
    }

    public function getCoveredCostAttribute() // net paid
    {
        $cost = (float) $this->avg_medicare_payment_amount;
        return number_format($cost, 2, '.', '');
    }

}
