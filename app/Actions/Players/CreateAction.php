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
    public function execute(Player $player, UploadedFile $photo): Player
    {
        $player->photo = $this->saveFile($player, $photo);

        return $this->playersRepository->create($player);
    }

    /**
     * @throws PlayersException
     */
    public function saveFile(Player $player, UploadedFile $photo): string
    {
        $photoName = sprintf(
            'player_%d_team_%d.%s',
            $player->shirt_number,
            $player->team_id,
            $photo->extension()
        );

        if (!$photo->storeAs('players', $photoName, ['disk' => 'public'])) {
            throw new PlayersException('Error al subir el archivo');
        }

        return url("storage/players/$photoName");
    }
}
