<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookingDetailsResource;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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
        $page = ( request()->get( 'page' ) ) ? request()->get( 'page' ) : 1;

        $bookings = Cache::tags( [ 'booking_list' ] )->rememberForever( 'bookings_list_' . $page, function () {
            return Booking::with( 'room', 'customer' )->paginate( 50 );
        } );

        return BookingResource::collection( $bookings );
    }

    /**
     * Show Single Booking Details
     * Used Cache Here
     *
     * @param $id
     * @return mixed
     */
    public function show( $id )
    {
        return Cache::rememberForever( 'booking_' . $id, function () use ( $id ) {
            $booking = Booking::find( $id );
            if ( $booking ) {
                return new BookingDetailsResource( $booking );
            }

            return $this->failed( 'Booking no found' );
        } );
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
            'arrival'     => 'required|date',
            'checkout'    => 'required|date',
            'room_id'     => 'required|numeric|exists:rooms,id',
            'customer_id' => 'required|numeric|exists:customers,id'
        ] );

        // Check the room
        $room = Room::find( $data[ 'room_id' ] );

        if ( $room->locked ) {
            return response()->json( [ 'message' => "Room has already been booked" ], 411 );
        }

        $data[ 'book_time' ] = Carbon::now();
        $data[ 'user_id' ]   = Auth::id();

        try {
            Booking::create( $data );

            Cache::tags( 'booking_list' )->flush();

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
            // Delete Booking Cache
            Cache::forget( 'booking_' . $id );
            Cache::tags( 'booking_list' )->flush();
            // Delete the booking
            Booking::destroy( $id );


            return $this->success( 'Booking Deleted Successfully' );
        } catch ( Exception $e ) {
            return $this->failed( 'Failed to Delete Booking!' );
        }
    }
}
