<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /*
     * Return Success Message
     */
    public function success( $message, $status = 201 )
    {
        return response()->json( [ 'message' => $message ], $status );
    }

    /*
     * Return Success Message
     */
    public function failed( $message, $status = 409 )
    {
        return response()->json( [ 'message' => $message ], $status );
    }
}
