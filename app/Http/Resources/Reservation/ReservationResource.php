<?php

namespace App\Http\Resources\Reservation;

use App\Http\Resources\Location\LocationResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $user_id
 * @property mixed $location_id
 * @property mixed $arrival_date
 * @property mixed $departure_date
 * @property mixed $number_of_guests
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'location_id' => $this->location_id,
            'arrival_date' => $this->arrival_date,
            'departure_date' => $this->departure_date,
            'number_of_guests' => $this->number_of_guests,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'location' => new LocationResource($this->whenLoaded('location')),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
