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

            return response()->json( [ 'user' => $customer, 'message' => 'Customer Added Successfully' ], 201 );
        } catch ( Exception $e ) {
            return $this->failed( 'Failed to add customer!' );
        }
    }


    //    /**
    //     * Update a Customer
    //     *
    //     * @param Request $request
    //     * @param         $id
    //     * @return array
    //     * @throws ValidationException
    //     */
    //    public function update( Request $request, $id )
    //    {
    //        //validate incoming request
    //        $this->validate( $request, [
    //            'first_name' => 'required|string',
    //            'last_name'  => 'required|string',
    //            'email'      => 'required|email',
    //            'phone'      => 'required',
    //        ] );
    //
    //        $data = $request->all();
    //
    //        try {
    //            $customer             = Customer::findOrFail( $id );
    //            $customer->first_name = $data[ 'first_name' ];
    //            $customer->last_name  = $data[ 'last_name' ];
    //            $customer->email      = $data[ 'email' ];
    //            $customer->phone      = $data[ 'first_name' ];
    //            $customer->save();
    //
    //            return response()->json( [ 'user' => $customer, 'message' => 'Customer Updated Successfully' ], 201 );
    //        } catch ( Exception $e ) {
    //            return $this->failed( 'Failed to add customer!' );
    //        }
    //    }


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
