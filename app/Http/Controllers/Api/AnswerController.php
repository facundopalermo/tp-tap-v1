<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Clse controlador de Respuestas.
 */
class AnswerController extends Controller
{

    /**
     * Muestra todas las respuestas
     */
    public function index()
    {
        $answers = Answer::all();
        return response($answers, Response::HTTP_OK);
    }

    /**
     * Guarda una respuesta para una pregunta
     */
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

    /**
     * Muestra una respuesta {id}
     */
    public function show($id)
    {
        $answer = Answer::findOrFail($id);
        return response($answer, Response::HTTP_OK);
    }

    /**
     * Actualiza una respuesta. Solo el texto, no se admite cambio de pregunta
     */
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

    /**
     * Elimina una respuesta
     */
    public function destroy($id)
    {
        Answer::findOrFail($id)->delete();
        return response()->json(['result' => 'Respuesta eliminada'], Response::HTTP_OK);
    }
}
