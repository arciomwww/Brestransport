<?php

namespace App\Http\Resources\API\BusStop;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
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
            'title' => $this->title,
            'next' => $this->next,
            'position' => [
                'lat' => $this->lat,
                'lng' => $this->lng,
            ]
        ];
    }
}
