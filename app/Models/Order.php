<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'service_id', 'from', 'to', 'appointment_date','appointment_time', 'image_front', 'image_back',
                            'image_ticket','image_passport', 'payment_method', 'payment_status', 'status', 'total','verified','lat','long','cancel_reason','airport_id',
                            ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Guest Customer'
        ]);
    }
    public function service(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Service::class)->withDefault([
            'name' => 'Service Customer'
        ]);
    }
    public function airport(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Airport::class)->withDefault([
            'name' => 'Airport Name'
        ]);
    }

}
