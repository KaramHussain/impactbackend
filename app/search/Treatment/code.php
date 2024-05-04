<?php

namespace App\search\Treatment;

use App\manager\connectionManager;
use App\search\Treatment\{search, children_term, category, sub_category, part};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class code extends search
{
    protected $appends = [
        'icds',
        //'children',
        'description'
    ];

    public function getIcdsAttribute($code = null)
    {
        $code = $code ?: $this->code;
        $conn = app(connectionManager::class)->getConnection('master');
        $icds = DB::connection($conn)->table(DB::raw('icd_cpt_crosswalk icw'))
                ->join('layterms_icd10cm', 'layterms_icd10cm.icd10cm_code', '=', 'icw.icd')
                ->where('icw.cpt', $code)
                ->where('icw.icd', 'NOT LIKE', '%.%')
                ->groupBy('icd10cm_code')
                ->get([
                    'icw.icd as icd_id',
                    'icw.cpt as cpt_id',
                    'layterms_icd10cm.icd10cm_description as description'
                ]);
        return $icds;
    }

    // public function getChildrenAttribute()
    // {
    //     return $this->children_term;
    // }

    public function category()
    {
        return $this->belongsTo(category::class);
    }

    public function sub_category()
    {
        return $this->belongsTo(sub_category::class);
    }

    public function terms()
    {
        return $this->belongsToMany(term::class);
    }

    public function parts()
    {
        return $this->morphToMany(part::class, 'partable');
    }

    public function children_term()
    {
        return $this->belongsTo(children_term::class);
    }

    public function scopeOrderByFrequency(Builder $builder, $order='DESC')
    {
        return $builder->orderBy('frequency', $order);
    }

    public function scopeLike(Builder $builder, $query)
    {
        return $builder->where('code', 'LIKE', "{$query}%");
    }

    public function scopeOrLike(Builder $builder, $query)
    {
        return $builder->Orwhere('code', 'LIKE', "{$query}%");
    }

    public function getDescriptionAttribute($code)
    {
        $code = $code ?: $this->code;
        $conn = app(connectionManager::class)->getConnection('master');
        $description = DB::connection($conn)->table('layterms_cpts_layterms')
                ->where('cpt_code', $code)
                ->get(['lay_summary'])->first();

        return $description;
    }

    public function scopeWhereAgeBetween(Builder $builder, $age)
    {
        return $builder->where(function($query) use($age) {

            $query->where(function($query) use ($age) {
                $query->where('min_age', '<=', $age)
                ->where('max_age', '>=', $age);
            })->orWhere(function($query) {
                $query->where('min_age', '=', null)
                ->where('max_age', '=', null);
            });

        });
    }

    public function scopeGender(Builder $builder, $gender)
    {
        $gender = $gender == 1 ? 'M' : 'F';
        return $builder->where(function($query) use($gender) {
            $query->where('gender', $gender)->orWhere('gender', null);
        });
    }

}
