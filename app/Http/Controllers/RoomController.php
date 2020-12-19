<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class RoomController extends Controller
{

    /**
     * Show the list of customers
     *
     * @return mixed
     */
    public function index()
    {
        $page = ( request()->get( 'page' ) ) ? request()->get( 'page' ) : 1;

        $rooms = Cache::tags( [ 'room_list' ] )->rememberForever( 'room_list_' . $page, function () {
            return Room::paginate( 50 );
        } );

        return $rooms;
    }


    /**
     * Return All Available Rooms
     * Available room means unlocked rooms
     *
     * @return mixed
     */
    public function availableRooms()
    {
        $value = Cache::rememberForever( 'available_rooms', function () {
            return Room::where( 'locked', false )->get();
        } );

        return $value;
    }


    /**
     * Add new Room
     *
     * @param Request $request
     * @return array
     * @throws ValidationException
     */
    public function store( Request $request )
    {
        //validate incoming request
        $this->validate( $request, [
            'room_number' => 'required|string|unique:rooms',
            'price'       => 'required',
            'locked'      => 'required|boolean',
            'max_persons' => 'required|numeric',
            'root_type'   => 'required|string',
        ] );

        $data = $request->all();

        try {
            Room::create( $data );

            // Remove Available Rooms Cache
            Cache::forget( 'available_rooms' );
            Cache::tags( 'room_list' )->flush();

            return $this->success( 'Room Added Successfully' );
        } catch ( Exception $e ) {
            return $this->failed( 'Failed to add customer!' );
        }
    }

    /**
     * Delete a Room
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy( $id )
    {
        try {
            Room::destroy( $id );
            // Remove Available Rooms Cache
            Cache::forget( 'available_rooms' );
            Cache::tags( 'room_list' )->flush();

            return $this->success( 'Room Deleted Successfully' );
        } catch ( Exception $e ) {
            return $this->failed( 'Failed to Delete Room!' );
        }
    }

}
