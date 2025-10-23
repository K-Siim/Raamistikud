<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'author',
        'published',
    ];   

   protected $appends = [
    'created_at_formatted',
    'updated_at_formatted',
];
    

    protected function createdAtFormatted(): Attribute
    {
       return Attribute::make(
            get: fn() => $this->created_at?->diffForHumans()
        );
    }

    protected function updatedAtFormatted(): Attribute
    {
       return Attribute::make(
            get: fn() => $this->created_at?->diffForHumans()
        );
    }

}
