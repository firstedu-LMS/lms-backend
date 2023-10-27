<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubmissionResource extends JsonResource
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
            "student_name" => $this->student->user->name,
            "student_id" => $this->student->student_id,
            "course_name" => $this->assignment->course->name,
            "batch_name" => $this->assignment->batch->name,
            "assignment_title" => $this->assignment->title,
            'created_at' => $this->created_at->format('j-m-Y'),
            "submission_file" => $this->whenLoaded('submission_file', function () {
                return $this->submission_file->file;
            }),
            "course_id" => $this->assignment->course_id,
            "batch_id" => $this->assignment->batch_id,
        ];
    }
}