<?php

namespace App\Models;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "description",
        "category_id",
    ];

    //many to many relationship with author model
    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }

    //inverse one to many relationship with category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}