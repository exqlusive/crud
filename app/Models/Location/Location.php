<?php

namespace App\Models\Location;

use App\Models\Reservation\Reservation;
use App\Models\User;
use App\Traits\Uuid\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Str;

/**
 * @property string $uuid
 * @property string $name
 * @property string $slug
 */
class Location extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'uuid',
        'name',
        'slug',
    ];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($location) {
            $slug = Str::slug($location->name);
            $originalSlug = $slug;
            $counter = 1;

            while (static::where('slug', $slug)->exists()) {
                $slug = "{$originalSlug}-{$counter}";
                $counter++;
            }

            $location->slug = $slug;
        });
    }

    public function getRouteKey(): string
    {
        return $this->slug;
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function users(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, Reservation::class);
    }
}
