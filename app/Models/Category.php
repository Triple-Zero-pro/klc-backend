<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = ['name', 'description', 'image', 'status'];


    public $translatable = ['name', 'description'];

    public function services()
    {
        return $this->hasMany(Service::class, 'category_id', 'id');
    }

}
