<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreQuestion;
use App\Models\Answer;

class QuestionController extends Controller
{

    public function index()
    {
        $questions = Question::with('answers')->get(['id', 'text']);
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
        return Question::findOrFail($id);

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'text' => 'required|string'
        ]);

        $question = Question::findOrFail($id);
        $question->text = $request->text;
        $question->save();

        return response()->json(['updated' => $question], Response::HTTP_ACCEPTED);
    }

    public function destroy($id)
    {
        Question::findOrFail($id)->delete();
        return response()->json(['result' => 'Pregunta eliminada'], Response::HTTP_OK);
    }
}
