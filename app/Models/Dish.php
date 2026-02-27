<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    protected $fillable = ['name', 'category_id', 'image'];
}
