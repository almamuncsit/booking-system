<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
        return Room::paginate( 50 );
    }


    /**
     * Return All Available Rooms
     * Available room means unlocked rooms
     *
     * @return mixed
     */
    public function availableRooms()
    {
        return Room::where( 'locked', false )->get();
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
            'room_number' => 'required|string',
            'price'       => 'required',
            'locked'      => 'required|boolean',
            'max_persons' => 'required|numeric',
            'root_type'   => 'required|string',
        ] );

        $data = $request->all();

        try {
            Room::create( $data );

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

            return $this->success( 'Room Deleted Successfully' );
        } catch ( Exception $e ) {
            return $this->failed( 'Failed to Delete Room!' );
        }
    }

}
