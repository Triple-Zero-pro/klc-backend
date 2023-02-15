<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class Service extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'image', 'name_en', 'description_en', 'terms_conditions_en', 'name_ar', 'description_ar', 'terms_conditions_ar', 'price', 'status'];

    public static function Booted()
    {
        if (Auth::guard('api')->check()) {
            static::addGlobalScope('query_data_service', function (Builder $builder) {
                $builder->select(['id', 'name_' . app()->getLocale() . ' as name', 'description_' . app()->getLocale() . ' as description', 'terms_conditions_' . app()->getLocale() . ' as terms_conditions', 'image', 'category_id', 'price', 'status'])->with('serviceAttributes');
            });
        }
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://www.incathlab.com/images/products/default_product.png';
        }
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
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
