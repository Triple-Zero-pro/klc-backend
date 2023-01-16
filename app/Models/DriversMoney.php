<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriversMoney extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'drivers_monies';

    protected $fillable = ['driver_id','amount','type','notes'];

    public function driver(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }
}
