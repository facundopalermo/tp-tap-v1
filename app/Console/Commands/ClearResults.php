<?php

namespace App\Console\Commands;

use App\Models\Attempt;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ClearResults extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attempt:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpiar intentos y resultados anteriores a una semana';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Attempt::where('created_at', '<', Carbon::now()->subDays(7))->delete();
        $log = '[' . date("Y-m-d H:i:s") . ']: ' . "Registro de resultados borrado. ";
        Storage::append("ClearResults.log", $log);
    }
}
