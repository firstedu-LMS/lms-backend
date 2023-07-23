<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CareerResource extends JsonResource
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
            'vacancy' => $this->vacancy,
            'age' => $this->age,
            'job_description' => $this->job_description,
            'job_requirement' => $this->job_requirement,
            'position' => $this->position,
            'salary' => $this->salary,
            'deadline' => $this->deadline,
            'salary_period' => $this->salary_period,
            'employment_status' => $this->employment_status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
