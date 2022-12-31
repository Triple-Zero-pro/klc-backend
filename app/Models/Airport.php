<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class Airport extends Model
{
    use HasFactory;

    protected $fillable = [ 'name_en','name_ar', 'status','lat', 'long'];

    public static function Booted()
    {
        if(Auth::guard('api')->check()){
            static::addGlobalScope('query_data_service', function (Builder $builder) {
                $builder->select(['id','name_'.app()->getLocale() .' as name','status','lat','long']);
            });
        }
    }



}
