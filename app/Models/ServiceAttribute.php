<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ServiceAttribute extends Model
{
    use HasFactory;

    protected $fillable = ['service_id', 'title_ar', 'title_en', 'input_name', 'input_type'];

    public static function Booted()
    {
        static::addGlobalScope('query_data_service_attributes', function (Builder $builder) {
            $builder->select(['id','service_id','title_' . app()->getLocale() . ' as title', 'input_name', 'input_type']);
        });
    }

    public function service()
    {
        return $this->belongsTo(Service::class)->withDefault([
            'name' => 'Service Attribute  Name'
        ]);
    }


}
