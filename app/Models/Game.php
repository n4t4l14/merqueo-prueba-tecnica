<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int    $id
 * @property int    $championship_code
 * @property int    $round
 * @property int    $order
 * @property int    $team_id_a
 * @property int    $team_id_b
 * @property int    $red_card_a
 * @property int    $red_card_b
 * @property int    $yellow_card_a
 * @property int    $yellow_card_b
 * @property int    $goals_a
 * @property int    $goals_b
 * @property int    $winning_team_id
 * @property int    $losing_team_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Game extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $fillable = [
        'championship_code',
        'round',
        'order',
        'team_id_a',
        'team_id_b',
        'red_card_a',
        'red_card_b',
        'yellow_card_a',
        'yellow_card_b',
        'goals_a',
        'goals_b',
        'winning_team_id',
        'losing_team_id',
    ];

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }
}
