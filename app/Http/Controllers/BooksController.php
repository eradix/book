<?php

namespace App\Http\Controllers;

use App\Http\Resources\v2\Book\BookCollection;
use App\Http\Resources\v2\Book\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get all books
        $books = Book::with(['authors', 'category'])->get();

        //return book collection
        return new BookCollection($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate data
        $bookData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'authors' => 'required | array'
        ]);

        //create the book
        $book = Book::create($bookData);

        //get authors
        $authors = $bookData['authors'];

        //register / attach authors to this newly created book
        $book->authors()->attach($authors);

        //return the response message
        return response()->json([
            'message' => 'Book successfully created',
            'data'  => new BookResource($book)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //find the book by id
        $book = Book::find($id);

        //if no book is fetched return error message
        if (!$book) {
            return response()->json([
                'message' => 'Error! No books found!',
            ], 404);
        }

        //return a new book resource
        return new BookResource($book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //validate data
        $bookData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'authors' => 'required | array'
        ]);

        //get book
        $book = Book::find($id);

        //if no book is fetched return error message
        if (!$book) {
            return response()->json([
                'message' => 'Error! No books found!',
            ], 404);
        }

        //update the book
        $book->update($bookData);

        //get authors
        $authors = $bookData['authors'];

        //update / sync new authors to this book
        $book->authors()->sync($authors);

        //return the response message
        return response()->json([
            'message' => 'Book successfully updated',
            'data'  => new BookResource(Book::find($id))
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //get book
        $book = Book::find($id);

        //if no book is fetched return error message
        if (!$book) {
            return response()->json([
                'message' => 'Error! No books found!',
            ], 404);
        }

        $book->delete();

        //return the response message
        return response()->json([
            'message' => 'Book successfully deleted',
        ]);
    }
}