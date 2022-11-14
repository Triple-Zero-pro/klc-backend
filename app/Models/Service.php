<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;


class Service extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'image', 'description', 'terms_conditions', 'price', 'status'];

    use HasTranslations;

    public $translatable = ['name','description','terms_conditions'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

}
