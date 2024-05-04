<?php

namespace App\Anatomy;

use DB;
use App\Anatomy\anatomy;
use App\Anatomy\{question, disease, body_part, sub_part, gender};
use App\manager\connectionManager;

class symptom extends anatomy
{

	protected $table = 'symptoms';

	protected $guarded = ['created_at', 'updated_at'];

    protected $fillable = [
        'name',
        'gender',
        'body_part',
        'questions',
        'warning_text'
    ];


	public function fetchRanges()
	{
		$crosswalk = DB::connection(
            app(connectionManager::getConnection('icd10cm_cpts_layterms_crosswalk'))
        );

		$cpt_ranges_table = $crosswalk->table('cpt_ranges');
		return $cpt_ranges_table->where('level', 1)->where('category_id', 5)->get();
	}

	public function questions()
    {
    	return $this->hasMany(question::class);
    }

    public function diseases()
    {
        return $this->belongsToMany(disease::class, 'symptom_all_diseases')->withPivot('disease_score');
    }

    public function parts()
    {
        return $this->belongsToMany(body_part::class, 'symptom_all_diseases')->withPivot('disease_score');
    }

    public function subparts()
    {
        return $this->belongsToMany(sub_part::class, 'symptom_all_diseases')->withPivot('disease_score');
    }

    public function gender()
    {
        return $this->belongsToMany(gender::class, 'symptom_all_diseases')->withPivot('disease_score');
    }

    public function fetchSymptom($id)
    {
    	return $this->where('id', $id)->first()->name;
    }

    public function fetchNamesFromSymptomIds($symptom_ids)
    {

    	$data = array();
    	$i=0;

		$symptoms = DB::connection($this->connection)->table($this->table);

		foreach($symptom_ids as $symptom_id)
		{

			$symptom_id = $symptom_id->symptom_id;
			$condition = $i == 0 ? 'where' : 'orWhere';

			$symptoms->$condition('symptoms.id', $symptom_id);
			$i++;

		}

		$symptoms = $symptoms->orderBy('name', 'asc')->get();

		foreach($symptoms as $symptom)
		{
			$data []= $symptom;
		}

		return $data;

    }
}
