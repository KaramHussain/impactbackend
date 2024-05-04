<?php

namespace App\Http\Controllers\AnatomyController;

use App\Anatomy\question;
use Illuminate\Http\Request;
use App\Http\Controllers\AnatomyController\AnatomyController;


class questionsController extends AnatomyController
{
    public $question;

    public function __construct()
    {
        $this->question = new question;
        parent::__construct();
    }

	public function fetch(Request $request)
	{

        $this->validateQuestions($request);

        $symptom_id = $request->id;
		$gender = $request->gender;
        $part = $request->part;
        $subpart = $request->subpart;

        if($subpart == 0 || $subpart == '')
        {
            $subpart = null;
        }
        $question = $this->question;
		return response()->json($question->fetch($symptom_id, $gender, $part, $subpart));
    }

    public function validateQuestions(Request $request)
    {
        return $request->validate([
            'id' => 'required',
            'gender' => 'required',
            'part' => 'required'
        ]);
    }

}
