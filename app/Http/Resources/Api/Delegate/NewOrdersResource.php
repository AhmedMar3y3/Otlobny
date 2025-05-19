<?php

namespace App\Http\Resources\Api\Delegate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewOrdersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // TODO: ask about the date and the show details in the design
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'map_desc' => $this->map_desc,
        ];
    }
}
