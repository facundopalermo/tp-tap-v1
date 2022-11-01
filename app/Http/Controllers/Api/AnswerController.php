<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AnswerController extends Controller
{

    public function index()
    {
        $answers = Answer::all();
        return response($answers, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'question_id'=> 'required|numeric',
            'isCorrect' => 'required|boolean'
        ]);

        if($question = Question::find($request->question_id)){

            $answer = $question->answers()->create([
                'text' => $request->text,
                'question_id' => $request->question_id,
                'isCorrect' => $request->isCorrect
            ]);

            return response($answer, Response::HTTP_CREATED);

        }else{

            return response()->json(["error" => "question_id: $request->question_id no existe"], Response::HTTP_NOT_FOUND);
        }

    }

    public function show($id)
    {
        $answer = Answer::findOrFail($id);
        return response($answer, Response::HTTP_OK);
    }
 
    public function update(Request $request, $id)
    {
        $request->validate([
            'text' => 'required|string'
        ]);

        $answer = Answer::findOrFail($id);
        $answer->text = $request->text;
        $answer->save();

        return response()->json(['updated' => $answer], Response::HTTP_ACCEPTED);
    }

    public function destroy($id)
    {
        Answer::findOrFail($id)->delete();
        return response()->json(['result' => 'Respuesta eliminada'], Response::HTTP_OK);
    }
}
