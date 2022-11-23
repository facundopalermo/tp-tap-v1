<?php

namespace Tests\Feature;

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\Authenticate;
use App\Models\User;
use Illuminate\Foundation\Testing\Concerns\InteractsWithAuthentication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

/* NOTA: Los testeos se realizan sin el Middleware de autenticacion ya no consegui forma de pasarlo, ni mediante cookie, headers ni sesion */

class AuthTest extends TestCase
{
    use InteractsWithAuthentication;

    public function test_login_incorrect_password() {

        $response = $this->post('api/login', [
            'email' => "test@test.com",
            'password' => "incorrect-password",
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertJson(["message" => true]);
        $this->assertGuest();
    }

    public function test_login_correct_password() {

        $user = User::find(3);

        $response = $this->post('api/login', [
            'email' => "test@test.com",
            'password' => "1234",
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(["token" => true]);
        $this->assertAuthenticatedAs($user);
    }

    public function test_get_profile() {

        $user = User::find(3);
        $response = $this->withoutMiddleware()->actingAs($user)->get('api/user-profile');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(["userData" => true]);

    }

    public function test_test_not_is_admin() {
        
        $user = User::find(3);
        $response = $this->withoutMiddleware(Authenticate::class);
        $response = $this->withMiddleware(AdminMiddleware::class)->actingAs($user)->get('api/statistics');

        $response->assertStatus(Response::HTTP_FORBIDDEN);

    }

    public function test_test_now_is_admin() {
        
        $user = User::find(3);
        $user->isAdmin = true;

        $response = $this->withoutMiddleware(Authenticate::class);
        $response = $this->withMiddleware(AdminMiddleware::class)->actingAs($user)->get('api/statistics');

        $response->assertStatus(Response::HTTP_OK);

    }
}
