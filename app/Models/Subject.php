<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'subject_code',
        'teacher_id',
        'description'
    ];
    
    // rel
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function books()
    {
        return $this->hasMany(Book::class);
        
    }// end of books
    
    //atr

    //scope

    //fun

}
