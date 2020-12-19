<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\CheckOut;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckOutController extends Controller
{

    public function checkOut( Request $request )
    {
        //validate incoming request
        $data                    = $this->validate( $request, [
            'booking_id' => 'required|numeric|exists:bookings,id',
        ] );
        $data[ 'user_id' ]       = Auth::id();
        $data[ 'checked_out_at' ] = Carbon::now();

        try {
            CheckOut::create( $data );
            $booking = Booking::find($data['booking_id']);
            $booking->checkout = Carbon::now(); // Update Arrival timve
            $booking->save();

            $booking->room->locked = false;
            $booking->room->save();

            return $this->success( 'Checked Out Successfully' );
        } catch ( Exception $e ) {
            return $this->failed( 'Failed to Check Out!' );
        }

    }

}
