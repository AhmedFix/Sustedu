<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'university_id',
        'course_id',
        'gender',
        'phone',
        'phone2',
        'dateofbirth',
        'current_address',
        'permanent_address',
    ];

    //rel
    public function user()
    {
        return $this->belongsTo(User::class);
    } // end of User

    // rel
    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_student');

    }// end of books

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }// end of Subjects

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    } // end of Course

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    } // end of Attendances

    //atr

    //scope

    //fun

}// end of model
