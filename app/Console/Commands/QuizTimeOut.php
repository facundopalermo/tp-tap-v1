<?php

namespace App\Console\Commands;

use App\Models\Attempt;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class QuizTimeOut extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quiz:tout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Coloca en Ausente aquellos examenes que no se respondieron en una hora';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Attempt::where('created_at', '<', Carbon::now()->subMinutes(60))->where('answered', NULL)->whereNotNull('accesskey')->update(['result' => 'Ausente']);
        $log = '[' . date("Y-m-d H:i:s") . ']: ' . "Intentos sin intentar, como ausentes. ";
        Storage::append("QuizTimeOut.log", $log);
    }
}
