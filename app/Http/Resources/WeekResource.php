<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeekResource extends JsonResource
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
            'course_id' => $this->course_id,
            'batch_id' => $this->batch_id,
            'course' => $this->whenLoaded('course'),
            'batch' => $this->whenLoaded('batch'),
            'week_number' => $this->week_number,
            'locked' => $this->locked ?? false,
        ];
    }
}
