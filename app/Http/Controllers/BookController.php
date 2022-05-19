<?php


namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::withCount('students')->latest()->paginate(10);

        return view('backend.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = Subject::latest()->get();
        return view('backend.books.create', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {

        $requestData = $request->validated();
        if ($request->poster) {
            $name = $request->poster->hashName();
            $request->poster->move('images/books/',$name);
            $requestData['poster'] = $name;

        } else {
            $requestData['poster'] =  'default.jpg';
        }//end of if

        $book = Book::create($requestData);

        return redirect()->route('books.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subjects = Subject::latest()->get();
        $book = Book::findOrFail($id);

        return view('backend.books.edit', compact('book','subjects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function update(BookRequest $request,Book $book)
    {
        $requestData = $request->validated();

        if ($request->poster) {

            if ($book->hasPoster() && $book->poster != 'default.jpg' ) {
                Storage::disk('local')->delete('images/books/' . $book->poster);
            }

            $name = $request->poster->hashName();
            $request->poster->move(public_path('images/books/'), $name);

            $requestData['poster'] = $name;

        }//end of if 

        $book->update($requestData);

        return redirect()->route('books.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route('books.index');
    }

}
