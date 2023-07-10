<?php

namespace App\Http\Resources\v2\Author;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'created_at' => $this->created_at->format('m-d-Y H:i'),
            'updated_at' => $this->updated_at->format('m-d-Y H:i'),
            'books' =>  $this->books->count() !== 0 ?
                $this->books->map(function ($book) {
                    return [
                        'id' => $book->id,
                        'title' => $book->title,
                        'description' => $book->description,
                        'category_id' => $book->category_id,
                        'category_name' => $book->category->name
                    ];
                }) : null,
        ];
    }
}