<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AccessKey;
use App\Models\Attempt;
use Symfony\Component\HttpFoundation\Response;

class AccessKeyController extends Controller
{
    /**
     * Retorna, si existe, una accesskey vigente creada
     */
    public function index()
    {
        $user = auth()->user();
        $key = AccessKey::recent()->where('user_id', $user->id)->orderBy('id','desc')->first();

        if($key != null) {
            return response()->json(['key' => $key->key], Response::HTTP_OK);
        }else{
            return response()->json(['messege' => 'No hay clave vigente creada.'], Response::HTTP_NOT_FOUND);
        }
    }
    
    /**
     * Genera una accesskey aleatoria de 20 caracteres
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $key = null;

        // Si existe clave vigente, la retorna
        if(($key = AccessKey::recent()->where('user_id', $user->id)->first()) && $key->count() > 0){

            if(Attempt::where('accesskey', $key->key)->get()->count() == 0){
                return response()->json(['key' => $key->key], Response::HTTP_OK);
            }

        }

        // Si no existe clave vigente, la genera y retorna
        $key = AccessKey::create([
            'user_id' => $user->id,
            'key' => fake()->regexify('[A-Za-z0-9]{20}')
        ]);

        return response()->json(['key' => $key->key], Response::HTTP_CREATED);

    }

}
