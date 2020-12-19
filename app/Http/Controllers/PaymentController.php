<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentResource;
use App\Models\Booking;
use App\Models\Payment;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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
        $payments = Payment::with( 'customer' )->paginate( 50 );

        return PaymentResource::collection( $payments );
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

            // Update booking payment status
            $paid = $booking->payments->sum( 'amount' );
            if ( $paid >= $booking->room->price ) {
                $booking->payment_status = 'paid';
            } else {
                $booking->payment_status = 'due';
            }
            $booking->save();

            // Delete Booking Cache
            Cache::forget( 'booking_' . $booking->id );

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
            $payment = Payment::find( $id );
            // Delete Booking Cache
            Cache::forget( 'booking_' . $payment->booking_id );
            $payment->delete();

            return $this->success( 'Booking Deleted Successfully' );
        } catch ( Exception $e ) {
            return $this->failed( 'Failed to Delete Booking!' );
        }
    }
}
