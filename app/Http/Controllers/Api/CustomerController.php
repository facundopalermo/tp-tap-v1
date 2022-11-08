<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Attempt;
use App\Models\Question;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        //
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

    public function setGlasses (Request $request) {

        $request->validate([
            'glasses' => 'boolean|required'
        ]);

        $user = auth()->user();
        $user->glasses = $request->glasses;
        $user->save();

        if($user->glasses == true) {

            if(!$appointment = Appointment::where('user_id', $user->id)->where('state', 'valid')->where('date', '>', date('Y-m-d'))->first()){
                $date = fake()->dateTimeBetween('now', '+1 years')->format('Y-m-d');
                $appointment = Appointment::create([
                    'user_id' => $user->id,
                    'date' => $date,
                    'state' => 'valid'
                ]);
            }
            
        }

        return response()->json([
            'glasses' => $user->glasses,
            'appointment' => $user->glasses?$appointment:'No requiere'
        ], Response::HTTP_OK);
    }

    public function newQuiz() {

        $user = auth()->user();

        if(($attempt = Attempt::select('id')->where('user_id', $user->id)->where('accesskey', NULL)->get()) && $attempt->count() == 1){

            return response()->json(['result' => ['message:' => 'Intento en blanco disponible', 'attempt' => $attempt]], Response::HTTP_OK);

        }elseif (Attempt::where('user_id', $user->id)->get()->count() < 3) {

            $questions = Question::with(['answers'=> function ($q) {
                $q->inRandomOrder();
            }])->inRandomOrder()->limit(10)->get();
    
            $attempt = Attempt::create([
                'user_id' => $user->id,
                'quiz' => $questions
            ]);
    
            return response()->json(['result' => ['message:' => 'ok', 'attempt' => $attempt->id]], Response::HTTP_OK);

        }

        return response()->json(['result' => ['message:' => 'Cantidad de intentos superados']], Response::HTTP_NOT_ACCEPTABLE);
    }

}
