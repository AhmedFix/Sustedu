<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subject = Subject::create([
            'name'        => 'frist subject',
            'slug'        => 'subject',
            'teacher_id'        => 1,
            'subject_code'     => 1,
            'description' => 'subject one info'
        ]);
    }
}
