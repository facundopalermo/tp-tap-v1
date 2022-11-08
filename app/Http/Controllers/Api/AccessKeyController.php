<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AccessKey;
use App\Models\Attempt;
use Symfony\Component\HttpFoundation\Response;

class AccessKeyController extends Controller
{
    public function index()
    {
        //
    }
    
    public function store(Request $request)
    {
        $user = auth()->user();
        $key = null;

        if(($key = AccessKey::recent()->where('user_id', $user->id)->first()) && $key->count() > 0){

            //return response()->json(['key' => $key], Response::HTTP_OK);

            if(Attempt::where('accesskey', $key->key)->get()->count() == 0){
                return response()->json(['key' => $key->key], Response::HTTP_OK);
            }

        }

        $key = AccessKey::create([
            'user_id' => $user->id,
            'key' => fake()->regexify('[A-Za-z0-9]{20}')
        ]);

        return response()->json(['key' => $key->key], Response::HTTP_CREATED);

    }

    public function show($id)
    {
        //
    }

}
