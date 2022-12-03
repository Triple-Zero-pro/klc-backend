<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name_en', 'description_en','name_ar', 'description_ar', 'image', 'status'];

    public static function Booted()
    {
        if(Auth::guard('api')->check()){
            static::addGlobalScope('query_data', function (Builder $builder) {
                $builder->select(['id','name_'.app()->getLocale() .' as name','description_'.app()->getLocale() .' as description' ,'image','status']);
            });
        }
    }



    public function services()
    {
        return $this->hasMany(Service::class, 'category_id', 'id');
    }

}
