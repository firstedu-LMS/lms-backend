<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
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
            'email' => $this->email,
            'career' => $this->career,
            'cv_id' => $this->cv_id,
            'cv' => $this->whenLoaded('cv',function(){
                return new CvFormResource($this->cv);
            }),
            'created_at' => $this->created_at->format('j-m-Y'),
            'updated_at' => $this->updated_at->format('j-m-Y'),
        ];
    }
}
