<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\AttemptController;
use Tests\TestCase;

class CalcResultTest extends TestCase
{
    public function test_calc_result()
    {
        $quiz = '[{"id":3},{"id":9},{"id":10}]';

        $respuesta = [
            ["question" => 3, "answer" => 8],
            ["question" => 9, "answer" => 27],
            ["question" => 10, "answer" => 29]
        ];

        $this->assertEquals(3, AttemptController::calcResult((array)json_decode($quiz), $respuesta));

    }
}
