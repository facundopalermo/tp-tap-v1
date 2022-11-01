<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
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
}
