<?php

namespace App\Console\Commands;

use App\Actions\BulkLoadAction;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class BulkLoadCommand extends Command
{
    protected $signature = 'app:bulk-load-command';

    protected $description = 'Import teams and players data from a CVS file';

    public function handle(BulkLoadAction $bulkLoadAction): int
    {
        try {
            $this->warn('Iniciando proceso de cargue...!');
            $bulkLoadAction->execute(storage_path('app/teams_and_players_data_template.csv'));
            $this->info('Finaliza cargue exitosamente!');
        } catch (\Throwable $throwable) {
            logger($throwable->getMessage(), $throwable->getTrace());
            $this->warn($throwable->getMessage());

            return SymfonyCommand::FAILURE;
        }

        return SymfonyCommand::SUCCESS;
    }
}
