<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [ 'first_name', 'last_name', 'email', 'phone', 'registered_at' ];

    public $timestamps = false;

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
