<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Store a new user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register( Request $request )
    {
        //validate incoming request
        $this->validate( $request, [
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ] );

        try {

            $user           = new User;
            $user->name     = $request->input( 'name' );
            $user->email    = $request->input( 'email' );
            $plainPassword  = $request->input( 'password' );
            $user->password = app( 'hash' )->make( $plainPassword );

            $user->save();

            //return successful response
            return response()->json( [ 'user' => $user, 'message' => 'User Registered Successfully' ], 201 );
        } catch ( \Exception $e ) {
            //return error message
            return response()->json( [ 'message' => 'User Registration Failed!' ], 409 );
        }

    }


    public function login( Request $request )
    {
        //validate incoming request
        $this->validate( $request, [
            'email'    => 'required|email|exists:users',
            'password' => 'required',
        ] );

        $credentials = request( [ 'email', 'password' ] );

        if ( !$token = auth()->attempt( $credentials ) ) {
            return response()->json( [ 'error' => 'Unauthorized' ], 401 );
        }

        return $this->respondWithToken( $token );
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken( $token )
    {
        return response()->json( [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 600
        ] );
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function authUser()
    {
        return response()->json( auth()->user() );
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json( [ 'message' => 'Successfully logged out' ] );
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken( auth()->refresh() );
    }


}
