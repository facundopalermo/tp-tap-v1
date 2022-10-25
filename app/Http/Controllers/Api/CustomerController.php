<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{
    public function setGlasses (Request $request) {

        $request->validate([
            'glasses' => 'boolean|required'
        ]);

        $user = auth()->user();
        $user->glasses = $request->glasses;
        $user->save();

        return response('Guardado con exito', Response::HTTP_OK);
    }
}
