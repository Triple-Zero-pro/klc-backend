<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Onboard extends Model
{
    use HasFactory;

    protected $fillable = ['title_en', 'description_en','title_ar', 'description_ar', 'image', 'status'];

    public static function Booted()
    {
        static::addGlobalScope('query_data_onboard', function (Builder $builder) {
            $builder->select(['id','title_'.app()->getLocale() .' as title','description_'.app()->getLocale() .' as description' ,'image','status']);
        });
    }


}
