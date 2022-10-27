<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Helper\Helper;
use App\Http\Requests\StoreQuestion;
use App\Models\Answer;

class QuestionController extends Controller
{

    public function index()
    {
        $questions = Question::all();
        return response($questions, Response::HTTP_OK);
    }

    public function store(StoreQuestion $request)
    {
        $question = Question::create([
            'text' => $request->text
        ]);

        foreach($request['answers'] as $answer ) {
            Answer::create([
                'text' => $answer['text'],
                'question_id' => $question->id,
                'isCorrect' => $answer['isCorrect']
            ]);
        }

        return response($question, Response::HTTP_CREATED);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
