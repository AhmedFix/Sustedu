<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'author',
        'description',
        'book_type',
        'subject_id',
        'url',
        'poster'
    ];

    protected $appends = ['poster_path'];   

    // rel
    public function subject() 
    {
        return $this->belongsTo(Subject::class);
    }// end of Subject

    public function students()
    {
        return $this->belongsToMany(Student::class, 'book_student');

    }// end of students

    // atr
    public function getPosterPathAttribute()
    {
        if ($this->poster) {
            return asset('images/books/' . $this->poster);
        }

        return asset('images/books/default.jpg');

    }// end of getPosterPathAttribute

    // scope

    //fun
    public function hasPoster()
    {
        return $this->poster != null;

    }// end of hasImage
    
}
