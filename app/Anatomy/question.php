<?php

namespace App\Anatomy;

use DB;
use App\Anatomy\anatomy;
use App\Anatomy\traits\mappings\part_mappings;
use App\Anatomy\{answer, symptom, body_part, sub_part};
use App\Http\Controllers\AnatomyController\BodyPartController;

class question extends anatomy
{
    use part_mappings;

    protected $guarded = ['created_at', 'updated_at'];

    public function answers()
    {
    	return $this->hasMany(answer::class);
    }

    public function symptom()
    {
    	return $this->belongsTo(symptom::class);
    }

    public function parts()
    {
        return $this->belongsTo(body_part::class);
    }

    public function subparts()
    {
        return $this->belongsTo(sub_part::class);
    }

    public function fetch($id, $gender, $part, $subpart)
    {

        $data = array();

        $partsController = new BodyPartController;

        //get the specific part mappings
        $parts = $this->part_mappings()[$part];

        //get part_ids from part names
        $part_ids = $partsController->fetch($parts);


        $db = DB::connection($this->connection);
        $table = $db->table('questions');

        $questions =
        $table
        ->join('answers', 'answers.question_id', '=', 'questions.id')
        ->select('questions.id', 'questions.symptom_id', 'questions.question', 'questions.type', 'questions.part', 'questions.sub_part', 'questions.gender', 'answers.id as answerId', 'answers.question_id', 'answers.answer', 'answers.warning_text', 'answers.type as answerType')
        ->where('questions.symptom_id', $id)
        ->where(function($query) use ($gender) {
            $query->where('questions.gender', $gender)
            ->orWhere('questions.gender', 3);
        })
        ->where(function($query) use ($part_ids) {
            $i=0;
            $condition = $i==0 ? 'where' : 'Orwhere';
            foreach ($part_ids as $part) {
                $condition = $i==0 ? 'where' : 'Orwhere';
                $query->$condition('questions.part', $part);
                $i++;
            }
        })->where('questions.sub_part', $subpart)->get();

    	$data = $this->groupQuestions($questions);
    	return $data;

    }

    public function groupQuestions($questions)
    {

        $data = [];

        foreach($questions as $question)
        {

            //if already exists question in data array then skip iteration
            if(!in_array($question->id, array_column($data, 'id')))
            {
                $data []= [
                    'id'         => $question->id,
                    'question'   => $question->question,
                    'symptom_id' => $question->symptom_id,
                    'type'       => $question->type,
                    'part'       => $question->part,
                    'sub_part'   => $question->sub_part,
                    'gender'     => $question->gender
                ];
            }

            //checking if question id in data array is matched with answer.question_id
            //and then fetch that key and append to that key
            $key = array_search($question->question_id, array_column($data, 'id'));

            if($key !== '' or $key !== null)
            {
                $data[$key]['answers'][] = [

                    'id'            => $question->answerId,
                    'question_id'   => $question->question_id,
                    'answer'        => $question->answer,
                    'warning_text'  => $question->warning_text,
                    'type'          => $question->answerType

                ];
            }

        }//foreach

        return $data;

    }//groupQuestions


}
