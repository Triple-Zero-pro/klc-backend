<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCredit extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'payment_method','credit_number', 'credit_name', 'expired_date', 'cvv'];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Customer Credit'
        ]);
    }

}
