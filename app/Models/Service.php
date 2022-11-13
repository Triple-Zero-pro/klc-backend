<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['category_id','name','image','description','terms_conditions','price','status'];

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

}
