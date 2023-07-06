<?php

namespace App\Http\Resources\v2\Book;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'category_name' => $this->category->name,
            'category_id' => $this->category->id,
            'created_at' => $this->created_at->format('m-d-Y H:i'),
            'updated_at' => $this->updated_at->format('m-d-Y H:i'),
            'authors' =>  $this->authors->map(function ($author) {
                return [
                    'author_id' => $author->id,
                    'author_name' => "{$author->first_name} {$author->last_name}",
                    'email' => $author->email,
                ];
            })
        ];
    }
}