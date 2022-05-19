<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $book = Book::create([
            'name'        => 'book 1',
            'subject_id'        => 1,
            'description'     => 'this is some info',
            'author'        => 'author 1',
            'book_type'        => 'reference',
            'url'        => 'test',
            'poster' => 'default.jpg'
        ]);
    }
}
