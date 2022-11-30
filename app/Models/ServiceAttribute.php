<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ServiceAttribute extends Model
{
    use HasFactory;

    protected $fillable = ['service_id', 'from', 'to', 'appointment_date','appointment_time', 'images', 'gender','embassy',
        'select_service', 'employee_status'];
    public function service()
    {
        return $this->belongsTo(Service::class)->withDefault([
            'name' => 'Service Attribute  Name'
        ]);
    }


}
