<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       

        $course = Course::create([
            'teacher_id'        => 1,
            'course_numeric'     => 1,
            'course_name'        => 'frist course',
            'course_description' => 'course one'
        ]);


    }
}
