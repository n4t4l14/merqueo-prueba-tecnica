<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{HasMany, HasOne};

/**
 * @property int                $id
 * @property string             $name
 * @property string             $flag
 * @property Carbon             $created_at
 * @property Carbon             $updated_at
 * @property ChampionshipResult $championshipResult
 */
class Team extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $fillable = [
        'name',
        'flag',
    ];

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    public function championshipResult(): HasOne
    {
        return $this->hasOne(ChampionshipResult::class);
    }
}
