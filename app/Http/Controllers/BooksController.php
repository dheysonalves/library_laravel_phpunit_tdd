<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    function store()
    {
        $book = Book::create($this->validateRequest());

        return redirect($book->path());
    }

    function update(Book $book)
    {
        $book->update($this->validateRequest());

        return redirect($book->path());
    }

    function destroy(Book $book)
    {
        $book->delete($this->validateRequest());

        return redirect('/books');
    }

    protected function validateRequest()
    {
        return request()->validate([
            'title' => 'required',
            'author' => 'required'
        ]);
    }
}
