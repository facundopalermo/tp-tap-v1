<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

/* NOTA: Los testeos se realizan sin el Middleware de autenticacion ya no consegui forma de pasarlo, ni mediante cookie, headers ni sesion */

class AccessKeyTest extends TestCase
{

    public function test_create_accesskey(){

        $user = User::find(3);
        $response = $this->withoutMiddleware();
        $response = $this->actingAs($user)->post('api/customers/accesskey');

        $response->assertStatus(match($response->getStatusCode()){
            200 => Response::HTTP_OK,
            201 => Response::HTTP_CREATED,
        });

        $response->assertJson(["key" => true]);

        $this->test_get_accesskey();

    }

    public function test_get_accesskey() {
        $user = User::find(3);
        $response = $this->withoutMiddleware();
        $response = $this->actingAs($user)->post('api/customers/accesskey');
    
        $response->assertStatus(match($response->getStatusCode()){
            200 => Response::HTTP_OK,
            404 => Response::HTTP_NOT_FOUND,
        });
    
        $response->assertJson(match($response->getStatusCode()){
            200 => ["key" => true],
            404 => ["message" => true],
        });
    }

}
