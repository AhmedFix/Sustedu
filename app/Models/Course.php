<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_name',
        'course_numeric',
        'teacher_id',
        'course_description'
    ];

    // rel
    public function students()
    {
        return $this->hasMany(Student::class,'course_id');
    }// end of Student

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }// end of Subjects

    public function teacher() 
    {
        return $this->belongsTo(Teacher::class);
    }// end of Teacher
    
    //atr

    //scope

    //fun

}// end of Model