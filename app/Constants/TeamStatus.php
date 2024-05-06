<?php

namespace App\Constants;

enum TeamStatus: string
{
    case CONTINUE = 'continue_next_round';
    case ELIMINATED = 'eliminated';
    case WINNER = 'winner';

    public static function toArray(): array
    {
        return [
            self::WINNER->value,
            self::CONTINUE->value,
            self::ELIMINATED->value,
        ];
    }

    public function getMessage(): string
    {
        return match ($this) {
            self::WINNER => 'Ganador',
            self::CONTINUE => 'Continua en la siguiente ronda',
            self::ELIMINATED => 'Eliminado',
        };
    }
}
