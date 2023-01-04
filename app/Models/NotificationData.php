<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationData extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = ['sender_id','receiver_token','title','description','image','action','type','platform'];
}
