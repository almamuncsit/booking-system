<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{

    /**
     * Show the list of customers
     *
     * @return mixed
     */
    public function index()
    {
        return Customer::paginate( 50 );
    }


    /**
     * Add new Customer
     *
     * @param Request $request
     * @return array
     * @throws ValidationException
     */
    public function store( Request $request )
    {
        //validate incoming request
        $this->validate( $request, [
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'email'      => 'required|email',
            'phone'      => 'required',
        ] );

        $data                    = $request->all();
        $data[ 'registered_at' ] = Carbon::now();

        try {
            $customer = Customer::create( $data );

            return response()->json( [ 'customer' => $customer, 'message' => 'Customer Added Successfully' ], 201 );
        } catch ( Exception $e ) {
            return $this->failed( 'Failed to add customer!' );
        }
    }

    /**
     * Delete a customer
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy( $id )
    {
        try {
            Customer::destroy( $id );

            return $this->success( 'Customer Deleted Successfully' );
        } catch ( Exception $e ) {
            return $this->failed( 'Failed to Delete Customer!' );
        }
    }

}
