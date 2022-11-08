<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function getStatistics() {

        return response("es admin", Response::HTTP_OK);
    }
}
