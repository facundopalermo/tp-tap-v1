<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreQuestion;
use App\Models\Answer;

/**
 * Clase controlador de Preguntas
 */
class QuestionController extends Controller
{

    /**
     * Mustra todas las preguntas con sus posibles respuestas
     */
    public function index()
    {
        $questions = Question::with('answers')->get(['id', 'text']);
        return response($questions, Response::HTTP_OK);
    }

    /**
     * Crea una nueva pregunta, admite array de respuestas para cada pregunta
     */
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

    /**
     * Muestra una pregunta en particular
     */
    public function show($id)
    {
        return Question::findOrFail($id);
    }

    /**
     * Actualiza una pregunta. Solo el texto
     */
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

    /**
     * Elimina una pregunta
     */
    public function destroy($id)
    {
        Question::findOrFail($id)->delete();
        return response()->json(['result' => 'Pregunta eliminada'], Response::HTTP_OK);
    }
}
