<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryCategory extends Model
{
    protected $fillable = ['name', 'slug', 'sort_order'];

    public function items()
    {
        return $this->hasMany(GalleryItem::class, 'category_id');
    }
}
