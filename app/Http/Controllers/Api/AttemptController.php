<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AccessKey;
use App\Models\Answer;
use App\Models\Attempt;
use App\Models\DrivingLicense;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use PharIo\Manifest\License;
use Symfony\Component\HttpFoundation\Response;

/**
 * Clase controlador de Intentos
 */
class AttemptController extends Controller
{

    public function index(){
        $user = auth()->user();
        $attempt = Attempt::select('id', 'result', 'created_at')->where('user_id', $user->id)->get();

        return response()->json(['result' => ['attempt' => $attempt]], Response::HTTP_OK);
    }

    /**
     * Genera una nuevo examen
     */
    public function newAttempt() {

        $user = auth()->user();

        if($user->glasses === null) {
            return response()->json(['message' => 'post glasses es requerido'], Response::HTTP_NOT_ACCEPTABLE);
        }

        //Si existe un intento sin usar, responde con el id del intento
        if(($attempt = Attempt::select('id')->where('user_id', $user->id)->where('accesskey', NULL)->get()) && $attempt->count() == 1){

            return response()->json(['result' => ['message' => 'Intento en blanco disponible', 'attempt' => $attempt]], Response::HTTP_OK);

        // Si no existe intento en blanco y no se supera el maximo de 3, se genera un cuestionario y se retorna el id
        }elseif ($attempt = self::newQuiz()) {

            return response()->json(['result' => ['message' => 'created', 'attempt' => $attempt->id]], Response::HTTP_CREATED);

        }

        // si no hay intento en blanco y se supera los 3 intentos, lo informa
        return response()->json(['result' => ['message' => 'Cantidad de intentos superados']], Response::HTTP_NOT_ACCEPTABLE);
    }

    public static function newQuiz() {

        $user = auth()->user();

        //Si existe un intento sin usar, responde con el id del intento
        if (Attempt::where('user_id', $user->id)->get()->count() < 3) {

            $questions = Question::with(['answers'=> function ($q) {
                $q->inRandomOrder();
            }])->inRandomOrder()->limit(10)->get();

            $attempt = Attempt::create([
                'user_id' => $user->id,
                'quiz' => $questions
            ]);
    
            return $attempt;
        }

        return null;
    }

    /**
     * obtener intento con las preguntas
     */
    public function getAttempt(Request $request, Attempt $attempt) {

        $user = auth()->user();

        //verifica que el intento exista y sea del usuario
        if($attempt == null || $attempt->user_id != $user->id) {
            return response('No hay resultados para la solicitud', Response::HTTP_NOT_FOUND);
        }

        //verifica que el intento no este contestado o en proceso de...
        if($attempt->answered != null || $attempt->accesskey != null) {
            return response()->json(['message' => 'Este examen ya no puede ser realizado.'], Response::HTTP_IM_USED);
        }

        $request->validate([
            'accesskey' => 'required|string|min:20|max:20'
        ]);

        //verifica que la accesskey exista, este vigente (1 hora) y sea del usuario
        $accesskey = AccessKey::recent()->where('key', $request->accesskey)->where('user_id', $user->id)->first();

        if($accesskey == null) {

            return response()->json(['message' => 'El accesskey suministrado no es valido'], Response::HTTP_BAD_REQUEST);

        }else{
            
            //verifica que la clave accesskey no haya sido utilizada
            if((Attempt::where('accesskey', $accesskey->key)->first()) != null) {
                return response()->json(['message' => 'accesskey ya utilizado.'], Response::HTTP_IM_USED);
            }

            //guarda la key en el intento. ya no podrá ser usada
            $attempt->accesskey = $accesskey->key;
            $attempt->save();

            return response()->json(['result' => ['attempt:' => $attempt->id, 'quiz' => json_decode($attempt->quiz)]], Response::HTTP_OK);
        }
    }

    /**
     * Responder cuestionario
     */
    public function answerQuiz(int $id, Request $request) {

        $request->validate([
            'accesskey' => 'required|string|min:20|max:20',
            'responses' => 'array|required|size:10',
            'responses.*.question' => 'required|integer',
            'responses.*.answer' => 'required|integer',
        ]);

        /* verifica que el intento id exista, o 404 */
        $attempt = Attempt::findorfail($id);

        if($attempt->user_id != auth()->user()->id) {
            return response()->json(['message' => 'Acceso no autorizado'], Response::HTTP_FORBIDDEN);
        }

        if($attempt->accesskey != $request->accesskey) {
            return response()->json(['message' => 'AccessKey invalido'], Response::HTTP_BAD_REQUEST);
        }

        /* si existe, pero ya contiene respuestas, ya fue evaluado */
        if($attempt->answered != null || $attempt->result != null) {
            return response()->json(['message' => 'Cuestionario ya evaluado'], Response::HTTP_BAD_REQUEST);
        }

        /* calcula las respuestas */
        $nota = self::calcResult((array) json_decode($attempt->quiz), $request->responses);

        /* prepara response */
        $result = array();
        $result['hits'] = $nota;

        /* evalua la nota */
        if($nota > 7){
            
            $result['result'] = 'Aprobado';

            
            $license = DrivingLicense::where('user_id', auth()->user()->id)->first();
            $license->key = $attempt->accesskey;
            $license->nota = $nota;
            $license->save();
            $license->generate(); /* Retorna null si aun falta hacer el test de vista */
            $result['license'] = $license;

        }else{

            $result['result'] = 'Reprobado';

            if ($newAttempt = self::newQuiz()) {
                $result['new_attempt'] = $newAttempt->id;
            }else{
                $result['new_attempt'] = 'Cantidad de intentos superados';
            }
        }

        /* guarda y retorna resultado */
        $attempt->answered = json_encode($request->responses);
        $attempt->result = $result['result'];
        $attempt->save();
       
        return response()->json($result, Response::HTTP_OK);
    }

    /**
     * Funcion que se encarga de evaluar el quiz y las respuestas enviadas por el cliente contra las respuestas validas.
     */
    public static function calcResult(array $quiz, array $responses): int {

        $points = 0;

        foreach ($quiz as $question) {
            
            foreach ($responses as $response) {
                
                if($question->id == $response['question']){
                    $points += (Answer::findorfail($response['answer']))->isCorrect? 1 : 0;
                    break;
                }
            }
        }

        return $points;
    }
}