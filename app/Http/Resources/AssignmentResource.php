<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "course" => $this->course->name,
            "batch" => $this->batch->name,
            "test_date" => $this->test_date,
            "test_time" => $this->test_time,
            "agenda" => $this->agenda,
            "file" => $this->file->file,
            "created_at" => $this->created_at
        ];
    }
}
