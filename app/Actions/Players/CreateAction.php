<?php

namespace App\Actions\Players;

use App\Exceptions\PlayersException;
use App\Models\Player;
use App\Repositories\Contracts\PlayersRepositoryInterface;
use Illuminate\Http\UploadedFile;

class CreateAction
{
    public function __construct(private readonly PlayersRepositoryInterface $playersRepository)
    {
    }

    /**
     * @throws PlayersException
     */
    public function execute(
        string $name,
        string $nationality,
        int $age,
        string $position,
        int $shirtNumber,
        UploadedFile $photo,
        int $teamId
    ): Player {
        return $this->playersRepository->create(new Player([
            'name' => $name,
            'nationality' => $nationality,
            'age' => $age,
            'position' => $position,
            'shirt_number' => $shirtNumber,
            'photo' => $this->saveFile($name, $photo),
            'team_id' => $teamId,
        ]));
    }

    /**
     * @throws PlayersException
     */
    public function saveFile(string $name, UploadedFile $photo): string
    {
        $cleanStr = preg_replace('/[^A-Za-z0-9]/', '', $name);
        $photoName = strtolower(trim($cleanStr)) . '.' . $photo->extension();

        if (!$photo->storeAs('public/players', $photoName)) {
            throw new PlayersException('Error al subir el archivo');
        }

        return url("/storage/players/$photoName");
    }
}
