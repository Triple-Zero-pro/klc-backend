<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ServiceAttribute extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'from', 'to', 'appointment_date','appointment_time', 'image_front', 'image_back','image_ticket',
        'image_passport', 'image_visa', 'image_office', 'gender','embassy', 'select_service', 'employee_status','contact_details',
        'nationality', 'type_ticket', 'employee_name', 'number_passport','country_passport', 'phone_number',
        'going_date','going_time','return_date','return_time','birth_date'];
    public function service()
    {
        return $this->belongsTo(Service::class)->withDefault([
            'name' => 'Service Attribute  Name'
        ]);
    }


}
