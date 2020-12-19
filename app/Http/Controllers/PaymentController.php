<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{

    /**
     * Show the list of customers
     *
     * @return mixed
     */
    public function index()
    {
        return Payment::paginate( 50 );
    }


    /**
     * Create new booking
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store( Request $request )
    {
        //validate incoming request
        $data = $this->validate( $request, [
            'booking_id' => 'required|numeric|exists:bookings,id',
            'amount'     => 'required|numeric',
            'date'       => 'required|date',
        ] );

        $booking               = Booking::find( $data[ 'booking_id' ] );
        $data[ 'customer_id' ] = $booking->customer_id;
        $data[ 'user_id' ]     = Auth::id();
        $data[ 'date' ]        = Carbon::now();


        try {
            Payment::create( $data );

            $paid = $booking->payments->sum( 'amount' );
            if ( $paid >= $booking->room->price ) {
                $booking->payment_status = 'paid';
            } else {
                $booking->payment_status = 'due';
            }
            $booking->save();
            
            return $this->success( 'Booked Successfully' );
        } catch ( Exception $e ) {
            return $this->failed( 'Failed to Book!' );
        }
    }


    /**
     * Delete a Booking
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy( $id )
    {
        try {
            Payment::destroy( $id );

            return $this->success( 'Booking Deleted Successfully' );
        } catch ( Exception $e ) {
            return $this->failed( 'Failed to Delete Booking!' );
        }
    }
}
