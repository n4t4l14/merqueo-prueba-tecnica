<?php

namespace App\Models;

use App\Constants\TeamStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $id
 * @property int        $championship_code
 * @property int        $current_round
 * @property int        $team_id
 * @property int        $red_cards
 * @property int        $yellow_cards
 * @property int        $goals
 * @property int        $won_games
 * @property int        $lost_games
 * @property TeamStatus $team_status
 */
class ChampionshipResult extends Model
{
    use HasFactory;

    protected $casts = [
        'team_status' => TeamStatus::class,
    ];

    protected $fillable = [
        'championship_id',
        'team_id',
        'red_cards',
        'yellow_cards',
        'goals',
        'won_games',
        'lost_games',
    ];
}
