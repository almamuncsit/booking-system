<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckIn extends Model
{
    use HasFactory;

    public    $timestamps = false;
    protected $table      = 'checkins';
    protected $fillable   = [ 'booking_id', 'user_id', 'checked_in_at' ];
}
