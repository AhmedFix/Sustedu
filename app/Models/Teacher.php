<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'gender',
        'phone',
        'dateofbirth',
        'current_address',
        'permanent_address',
    ];

    // rel
    public function user()
    {
        return $this->belongsTo(User::class);
    }// end of User

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }// end of Subjects

    public function courses()
    {
        return $this->hasMany(Course::class);
    }// end of Courses

    public function students() 
    {
        return $this->courses()->withCount('students');
    } // end of Students
    
    //atr

    //scope

    //fun

}// end of Model

