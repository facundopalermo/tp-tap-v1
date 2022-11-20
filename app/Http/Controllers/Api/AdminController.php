<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attempt;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
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
}
