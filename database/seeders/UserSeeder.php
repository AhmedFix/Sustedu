<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        $admin = User::create([
            'name'          => 'Admin',
            'email'         => 'admin@app.com',
            'password'      => bcrypt('123321'),
            'created_at'    => date("Y-m-d H:i:s")
        ]);
        $admin->attachRole('admin');

        $teacher = User::create([
            'name'          => 'Teacher',
            'email'         => 'teacher@app.com',
            'password'      => bcrypt('123321'),
            'created_at'    => date("Y-m-d H:i:s")
        ]);
        $teacher->attachRole('teacher');

        $student = User::create([
            'name'          => 'Student',
            'email'         => 'student@app.com',
            'password'      => bcrypt('123321'),
            'created_at'    => date("Y-m-d H:i:s")
        ]);
        $student->attachRole('student');


        DB::table('teachers')->insert([
            [
                'user_id'           => $teacher->id,
                'gender'            => 'male',
                'phone'             => '0123456789',
                'dateofbirth'       => '1983-01-10',
                'current_address'   => 'kh-ElRiyadh',
                'permanent_address' => 'kh-ElRiyadh',
                'created_at'        => date("Y-m-d H:i:s")
            ]
        ]);


        DB::table('students')->insert([
            [
                'user_id'           => $student->id,
                'course_id'          => 1,
                'university_id'       => 20161103452,
                'gender'            => 'male',
                'phone'             => '0123456789',
                'phone2'             => '0123456789',
                'dateofbirth'       => '1997-01-01',
                'current_address'   => 'kh-jabra',
                'permanent_address' => 'kh-jabra',
                'created_at'        => date("Y-m-d H:i:s")
            ]
        ]);
    }
}
