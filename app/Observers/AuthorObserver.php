<?php

namespace App\Observers;

use App\Models\Author;
use Illuminate\Support\Facades\Log;

class AuthorObserver
{
    /**
     * Handle the Author "created" event.
     */
    public function created(Author $author): void
    {
        //log the data
        Log::info("Author: {$author->first_name} created.", ['author' => $author]);
    }

    /**
     * Handle the Author "updated" event.
     */
    public function updated(Author $author): void
    {
        //log the data
        Log::info("Author: {$author->first_name} updated.", ['author' => $author]);
    }

    /**
     * Handle the Author "deleted" event.
     */
    public function deleted(Author $author): void
    {
        //log the data
        Log::info("Author: {$author->first_name} deleted.", ['author' => $author]);
    }

    /**
     * Handle the Author "restored" event.
     */
    public function restored(Author $author): void
    {
        //
    }

    /**
     * Handle the Author "force deleted" event.
     */
    public function forceDeleted(Author $author): void
    {
        //
    }
}