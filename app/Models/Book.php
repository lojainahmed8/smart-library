<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'author',
        'description',
        'isbn',
        'publication_date',
        'available_copies',
        'cover_image',
        'is_available'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
