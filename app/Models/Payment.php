<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public    $timestamps = false;
    protected $fillable   = [ 'booking_id', 'user_id','customer_id', 'amount', 'date' ];

    public function booking()
    {
        return $this->belongsTo( Booking::class );
    }
}
