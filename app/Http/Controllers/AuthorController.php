<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Http\Resources\v2\Author\AuthorCollection;
use App\Http\Resources\v2\Author\AuthorResource;
use App\Models\Author;
use App\Traits\HttpResponses;

class AuthorController extends Controller
{
    //custom HttpResponses Trait
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::with('books')
            ->get();

        //if no authors available
        if ($authors->count() === 0) {
            $this->success(null, 'Currently no authors available.');
        }

        //return author collection
        return new AuthorCollection($authors);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(AuthorRequest $request)
    {
        //validate data
        $request->validated($request->all());

        //create author
        $author = Author::create($request->only('first_name', 'last_name', 'email'));

        //return the response message
        return $this->success(new AuthorResource($author), 'Author successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //find the author by id
        $author = Author::find($id);

        //if no auhtor is fetched return error message
        if (!$author) {
            return $this->error(null, 'No author found on the specified id.', 404);
        }

        //return a new author resource
        return new AuthorResource($author);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(AuthorRequest $request, string $id)
    {
        //validate data
        $request->validated($request->all());

        //get author
        $author = Author::find($id);

        //if no book is fetched return error message
        if (!$author) {
            return $this->error(null, 'No author found on the specified id.', 404);
        }

        //update the book
        $author->update($request->only('first_name', 'last_name', 'email'));

        //return the response message
        return $this->success(new AuthorResource(Author::find($id)), 'Author successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //get author
        $author = Author::find($id);

        //if no author is fetched return error message
        if (!$author) {
            return $this->error(null, 'No author found on the specified id.', 404);
        }

        //delete the book
        $author->delete();

        //return the response message
        return $this->success($author, 'Author successfully deleted.');
    }

    //search authors
    public function search($searchString)
    {
        //get all authors based on the search string
        $authors = Author::with('books')
            ->where('first_name', 'like', "%$searchString%")
            ->orWhere('last_name', 'like', "%$searchString%")
            ->orWhere('email', 'like', "%$searchString%")
            ->get();

        //check if search has result, if no result return an error response
        if ($authors->count() === 0) {
            return $this->error(null, "No auhtors found on the specified search string: {$searchString}.", 404);
        }

        //return author collection
        return new AuthorCollection($authors);
    }
}