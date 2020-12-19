<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    use HasFactory;

    public    $timestamps = false;
    protected $fillable   = [ 'arrival', 'checkout', 'room_id', 'customer_id', 'user_id', 'book_time', 'payment_status' ];

    /**
     * A Booking can have multiple payments
     *
     * @return HasMany
     */
    public function payments()
    {
        return $this->hasMany( Payment::class );
    }

    /*
     * Room of booking
     */
    public function room()
    {
        return $this->belongsTo( Room::class );
    }
}
