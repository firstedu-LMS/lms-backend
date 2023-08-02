<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstructorResource extends JsonResource
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
            'instructor_id' => $this->instrucror_id,
            'cv_id' => $this->cv_id,
            'phone' => $this->phone,
            'address' => $this->address,
            'cv' => $this->whenLoaded('cv'),
            'created_at' => $this->created_at->format('j-m-Y'),
            'updated_at' => $this->updated_at->format('j-m-Y'),
        ];
    }
}
