<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
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
            'name' => $this->name,
            'locked' => $this->locked ?? false,
            'description' => $this->description,
            'video_id' => $this->video_id,
            'week_id' => $this->week_id,
            'course_id' => $this->course_id,
            'batch_id' => $this->batch_id,
            'week' => $this->week,
            'course' => $this->course,
            'video' => $this->video,
            'batch' => $this->batch
        ];
    }
}