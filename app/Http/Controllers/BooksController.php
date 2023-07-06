<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Resources\v2\Book\BookCollection;
use App\Http\Resources\v2\Book\BookResource;
use App\Models\Book;
use App\Traits\HttpResponses;
use Illuminate\Database\Eloquent\Builder;



class BooksController extends Controller
{
    //custom HttpResponses Trait
    use HttpResponses;

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
    public function store(BookRequest $request)
    {
        //validate data
        $request->validated($request->all());

        //create the book
        $book = Book::create($request->only('title', 'description', 'category_id'));

        //get authors
        $authors = $request->authors;

        //register / attach authors to this newly created book
        $book->authors()->attach($authors);

        //return the response message
        return $this->success(new BookResource($book), 'Book successfully created');
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
            return $this->error(null, 'No books found on the specified id.', 404);
        }

        //return a new book resource
        return new BookResource($book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, string $id)
    {
        //validate data
        $request->validated($request->all());

        //get book
        $book = Book::find($id);

        //if no book is fetched return error message
        if (!$book) {
            return $this->error(null, 'No books found on the specified id.', 404);
        }

        //update the book
        $book->update($request->only('title', 'description', 'category_id'));

        //get authors
        $authors = $request->authors;

        //update / sync new authors to this book
        $book->authors()->sync($authors);

        //return the response message
        return $this->success(new BookResource(Book::find($id)), 'Book successfully updated');
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
            return $this->error(null, 'No books found on the specified id.', 404);
        }

        //delete the book
        $book->delete();

        //return the response message
        return $this->success($book, 'Book successfully deleted.');
    }

    //search books via title, description or name of the author
    public function search($searchString)
    {
        //get all books based on the search string
        $books = Book::with('authors', 'category')
            ->where('title', 'like', "%$searchString%")
            ->orWhere('description', 'like', "%$searchString%")
            ->orWhereHas('authors', function (Builder $query) use ($searchString) {
                $query->where('first_name', 'like', "%$searchString%");
                $query->orWhere('last_name', 'like', "%$searchString%");
            })
            ->get();

        //check if search has result, if no result return an error response
        if ($books->count() === 0) {
            return $this->error(null, "No books found on the specified search string: {$searchString}.", 404);
        }

        //return book collection
        return new BookCollection($books);
    }
}