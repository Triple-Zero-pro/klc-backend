<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Service extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'image', 'name_en', 'description_en', 'terms_conditions_en','name_ar', 'description_ar', 'terms_conditions_ar', 'price', 'status'];

    public static function Booted()
    {
        static::addGlobalScope('query_data_service', function (Builder $builder) {
            $builder->select(['id','name_'.app()->getLocale() .' as name','description_'.app()->getLocale() .' as description','terms_conditions_'.app()->getLocale() .' as terms_conditions' ,'image','price','status']);
        });
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function serviceAttributes()
    {
        return $this->hasMany(ServiceAttribute::class, 'service_id', 'id');
    }

}
