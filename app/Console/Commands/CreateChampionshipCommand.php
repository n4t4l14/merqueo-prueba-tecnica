<?php

namespace App\Console\Commands;

use App\Actions\Championships\CreateChampionshipAction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateChampionshipCommand extends Command
{
    protected $signature = 'app:create-championship-command';

    protected $description = 'Command description';

    public function __construct(private readonly CreateChampionshipAction $action)
    {
        parent::__construct();
    }

    public function handle()
    {
        DB::statement('TRUNCATE TABLE games');
        DB::statement('TRUNCATE TABLE championship_results');

        $this->info('Creando campeonato');
        $this->action->execute();
        $this->info('Campeonato creado exitosamente!');
    }
}
