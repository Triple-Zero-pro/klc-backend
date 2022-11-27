<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'service_id', 'from', 'to', 'appointment_date',
                            'image_passport', 'payment_method',
                            'payment_status', 'status','verified','cancel_reason','total',
                            ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Guest Customer'
        ]);
    }
    public function service()
    {
        return $this->belongsTo(Service::class)->withDefault([
            'name' => 'Service Customer'
        ]);
    }

}
