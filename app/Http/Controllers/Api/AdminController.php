<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attempt;
use App\Models\DrivingLicense;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    /**
     * método para obtener las estadísticas.
     */
    public function getStatistics(Request $request) {

        $request->validate(['date' => 'date_format:Y-m-d']);

        $date = $request->date == null ? date('Y-m-d') : $request->date;

        $cantidad = Attempt::whereDate('created_at', $date)->get()->count();
        $aprobados = Attempt::whereDate('created_at', $date)->where('result', 'Aprobado')->get()->count();
        $reprobados = Attempt::whereDate('created_at', $date)->where('result', 'Reprobado')->get()->count();
        $ausentes = Attempt::whereDate('created_at', $date)->where('result', 'Ausente')->get()->count();

        return response()->json([
            'cantidad' => $cantidad,
            'aprobados' => $aprobados,
            'reprobados' => $reprobados,
            'ausentes' => $ausentes,
        ], Response::HTTP_OK);

    }

    /**
     * Método que permite a un administrador setear en true el DrivingLicense->visiontest y otorgar la licencia.
     */
    public function giveLicense(Request $request){

        $request->validate(['customer_id' => 'required|integer']);

        $customer = User::with('drivinglicense')->findorfail($request->customer_id);

        if(!$customer->drivinglicense){
            return response()->json(['message' => 'el cliente aun inició el trámite'], Response::HTTP_NOT_ACCEPTABLE);
        }

        if($customer->drivinglicense->nota == null){
            return response()->json(['message' => 'el cliente aun no aprobó el examen'], Response::HTTP_NOT_ACCEPTABLE);
        }

        if(!$customer->drivinglicense->license){
            $customer->drivinglicense->visiontest=true;
            if(!$customer->drivinglicense->generate()){
                return response()->json(['message' => 'el cliente no completó todos los pasos'], Response::HTTP_NOT_ACCEPTABLE);
            }
        }
        return response()->json(['license' => $customer->drivinglicense], Response::HTTP_OK);
    }
}
