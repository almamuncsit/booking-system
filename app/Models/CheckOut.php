<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckOut extends Model
{
    use HasFactory;

    public    $timestamps = false;
    protected $table      = 'checkouts';
    protected $fillable   = [ 'booking_id', 'user_id', 'checked_out_at' ];
}
