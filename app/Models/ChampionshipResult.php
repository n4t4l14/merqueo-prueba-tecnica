<?php

namespace App\Models;

use App\Constants\TeamStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{HasOne};

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
 * @property Team       $team
 */
class ChampionshipResult extends Model
{
    use HasFactory;

    protected $casts = [
        'team_status' => TeamStatus::class,
    ];

    protected $fillable = [
        'championship_code',
        'current_round',
        'team_id',
        'red_cards',
        'yellow_cards',
        'goals',
        'won_games',
        'lost_games',
    ];

    public function team(): HasOne
    {
        return $this->hasOne(Team::class, 'id', 'team_id');
    }
}
