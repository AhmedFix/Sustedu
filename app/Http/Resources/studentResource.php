<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'university_id' => $this->student->university_id,
            'name' => $this->name,
            'email' => $this->email,
            'profile_picture' => $this->profile_picture_path,
            'gender'  => $this->student->gender,
            'phone'  => $this->student->phone,
            'birthDay'  => $this->student->dateofbirth,
            'address'  => $this->student->current_address,
            'current_course' => [
                'id'  => $this->student->course->id,
                'course_name'  => $this->student->course->course_name,
            ],
        ];

    }//end of to array

}//end of resource
