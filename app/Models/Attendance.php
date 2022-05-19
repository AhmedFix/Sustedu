<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'course_id',
        'teacher_id',
        'student_id',
        'attendence_date',
        'attendence_status'
    ];

    //rel
    public function student() {
        return $this->belongsTo(Student::class);
    }// end of Student

    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }// end of Teacher

    public function course() {
        return $this->belongsTo(Grade::class);
    }// end of course
    
    //atr

    //scope

    //fun
    
}// end of Model 