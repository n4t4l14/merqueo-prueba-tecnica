<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int    $id
 * @property string $name
 * @property string $nationality
 * @property int    $age
 * @property string $position
 * @property int    $shirt_number
 * @property string $photo
 * @property int    $team_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Player extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $fillable = [
        'name',
        'nationality',
        'age',
        'position',
        'shirt_number',
        'photo',
        'team_id',
    ];

    public function teamRelated(): HasOne
    {
        return $this->hasOne(Team::class, 'id', 'team_id');
    }
}
