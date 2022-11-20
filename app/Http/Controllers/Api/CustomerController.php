<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Clase controlador de acciones de usuario
 */
class CustomerController extends Controller
{

    /**
     * Setea si el usuario usa o no lentes
     */
    public function setGlasses (Request $request) {

        $request->validate([
            'glasses' => 'boolean|required'
        ]);

        $user = auth()->user();
        $user->glasses = $request->glasses;
        $user->save();

        //si el usuario requiere lentes, crea un turno nuevo para concurrir presencialmente
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

        //si el usuario requiere lentes, retorna el turno generado, caso contrario "No requiere"
        return response()->json([
            'glasses' => $user->glasses,
            'appointment' => $user->glasses?$appointment:'No requiere'
        ], Response::HTTP_OK);
    }

}
