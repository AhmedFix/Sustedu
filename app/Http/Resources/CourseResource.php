<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->course_name,
            'description' => $this->course_description,
            'subjects_count' => $this->subjects->count(),
            'subjects' => $this->subjects,

        ];

    }//end of to array

}//end of resource
