<?php

namespace App\Http\Controllers\AnatomyController;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AnatomyController\AnatomyController;

class answersController extends AnatomyController
{

    public function groupAnswersAndAddScores($answer_ids, $diseases)
    {

        //fill in diseases array with diseases ids and scores
        foreach($answer_ids as $answer)
        {
            $id = $answer['disease'];
            $score = $answer['score'];
            $key = array_search($id, array_column($diseases, 'disease'));

            $old_disease_score = $diseases[$key];

            if($old_disease_score != null)
            {
                $new_score = $score + $old_disease_score['score'];
                $diseases[$key] = ['disease' => $id, 'score' => "$new_score"];
            }
            else
            {
                $diseases[] = ['disease' => $id, 'score' => $score];
            }

        }
        return $diseases;
    }

    public function getAnswerIds($answers)
    {
        $answer_diseases_scores = $this->anatomy->table('answer_diseases_scores');

        $answer_diseases_scores->select('disease_id', DB::raw('SUM(score) as score'));
        $answer_diseases_scores->whereIn('answer_id', $answers);

        $answer_diseases_scores = $answer_diseases_scores->groupBy('disease_id')
        ->orderBy('score', 'desc')->get();

        $answer_diseases_scores_array = array();

        foreach($answer_diseases_scores as $disease)
        {
            $answer_diseases_scores_array []= ['disease' => $disease->disease_id, 'score' => $disease->score];
        }

        return $answer_diseases_scores_array;

    }

}
