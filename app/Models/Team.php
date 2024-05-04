<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $name
 * @property string $country_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Team extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function countryRelation(): HasOne
    {
        return $this->hasOne(Country::class);
    }

    public function playersRelation(): HasMany
    {
        return $this->hasMany(Player::class);
    }

}
