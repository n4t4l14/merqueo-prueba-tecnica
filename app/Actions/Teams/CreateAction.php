<?php

namespace App\Actions\Teams;

use App\Exceptions\TeamsException;
use App\Models\Team;
use App\Repositories\Contracts\TeamsRepositoryInterface;
use Illuminate\Http\UploadedFile;

class CreateAction
{
    public function __construct(private readonly TeamsRepositoryInterface $teamsRepository)
    {
    }

    /**
     * @throws TeamsException
     */
    public function execute(string $name, UploadedFile $flag): Team
    {
        return $this->teamsRepository->create(new Team([
            'name' => $name,
            'flag' => $this->saveFile($name, $flag),
        ]));
    }

    /**
     * @throws TeamsException
     */
    private function saveFile(string $name, UploadedFile $flag): string
    {
        $cleanStr = preg_replace('/[^A-Za-z0-9 ]/', '', $name);
        $cleanStr = str_replace(' ', '_', $cleanStr);

        $flagName = strtolower(trim($cleanStr)) . '.' . $flag->extension();

        if (!$flag->storeAs('countries', $flagName, ['disk' => 'public'])) {
            throw new TeamsException('Error al subir el archivo');
        }

        return url("storage/countries/$flagName");
    }
}
