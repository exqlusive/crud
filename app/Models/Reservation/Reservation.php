<?php

namespace App\Models\Reservation;

use App\Models\Location\Location;
use App\Models\User;
use App\Traits\Uuid\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed $user_id
 */
class Reservation extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'uuid',
        'location_id',
        'user_id',
        'arrival_date',
        'departure_date',
        'number_of_guests',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
