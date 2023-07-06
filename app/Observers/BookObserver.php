<?php

namespace App\Observers;

use App\Models\Book;
use Illuminate\Support\Facades\Log;

class BookObserver
{
    /**
     * Handle the Book "created" event.
     */
    public function created(Book $book): void
    {
        //log the data
        Log::info("Book: {$book->title} created.", ['book' => $book]);
    }

    /**
     * Handle the Book "updated" event.
     */
    public function updated(Book $book): void
    {
        //log the data
        Log::info("Book: {$book->title} updated.", ['book' => $book]);
    }

    /**
     * Handle the Book "deleted" event.
     */
    public function deleted(Book $book): void
    {
        //log the data
        Log::info("Book: {$book->title} deleted.", ['book' => $book]);
    }

    /**
     * Handle the Book "restored" event.
     */
    public function restored(Book $book): void
    {
        //
    }

    /**
     * Handle the Book "force deleted" event.
     */
    public function forceDeleted(Book $book): void
    {
        //
    }
}