<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Events\NewOrderEvent;

class Orders extends Model
{
    use HasFactory;
    protected $table = '[KENTRIES].[Orders]';

      protected static function booted()
    {
        static::created(function ($order) {
            broadcast(new NewOrderEvent($order));
        });
    }
}
