<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\CheckIn;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckInController extends Controller
{

    public function checkIn( Request $request )
    {
        //validate incoming request
        $data                    = $this->validate( $request, [
            'booking_id' => 'required|numeric|exists:bookings,id',
        ] );
        $data[ 'user_id' ]       = Auth::id();
        $data[ 'checked_in_at' ] = Carbon::now();

        try {
            CheckIn::create( $data );
            $booking = Booking::find($data['booking_id']);
            $booking->arrival = Carbon::now(); // Update Arrival timve
            $booking->save();

            $booking->room->locked = true;
            $booking->room->save();

            return $this->success( 'Checked In Successfully' );
        } catch ( Exception $e ) {
            return $this->failed( 'Failed to Check In!' );
        }

    }
}
