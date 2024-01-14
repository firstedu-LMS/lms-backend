<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstructorLessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'  => $this->id,
            'name'=> $this->name,
            'course' => $this->whenLoaded('course',function(){
                return new CourseResource($this->course);
            }),
            'week' => $this->whenLoaded('week'),
            'created_at' => $this->created_at->format("d-m-y"),
        ];
    }
}
