<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{

    /**
     * Show the list of customers
     *
     * @return mixed
     */
    public function index()
    {
        return Booking::paginate( 50 );
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
        $data                = $this->validate( $request, [
            'arrival'     => 'required|date',
            'checkout'    => 'required|date',
            'room_id'     => 'required|numeric|exists:rooms,id',
            'customer_id' => 'required|numeric|exists:customers,id'
        ] );
        $data[ 'book_time' ] = Carbon::now();
        $data[ 'user_id' ]   = Auth::id();

        try {
            Booking::create( $data );

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
            Booking::destroy( $id );

            return $this->success( 'Booking Deleted Successfully' );
        } catch ( Exception $e ) {
            return $this->failed( 'Failed to Delete Booking!' );
        }
    }
}
