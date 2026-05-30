<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerStory extends Model
{
    protected $fillable = [
        'author',
        'instagram_handle',
        'quote',
        'text',
        'rating',
        'media_path',
        'media_type',
        'status'
    ];
}
