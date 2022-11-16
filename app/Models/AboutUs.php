<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;

    protected $fillable = ['id','logo','phone','linkedin','facebook','twitter','location','address_ar','address_en','aboutUs_ar','aboutUs_en','terms_condition_ar','terms_condition_en'];

    public static function Booted()
    {
        static::addGlobalScope('query_data_about_us', function (Builder $builder) {
            $builder->select([
                'logo','phone','linkedin','facebook','twitter','location',
                'address_'.app()->getLocale() .' as address',
                'aboutUs_'.app()->getLocale() .' as aboutUs',
                'id','address_'.app()->getLocale() .' as address',
                'terms_condition_'.app()->getLocale() .' as terms_condition',
            ]);
        });
    }


}
