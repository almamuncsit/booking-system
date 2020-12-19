<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get( '/', function () use ( $router ) {
    return $router->app->version();
} );


$router->group( [ 'prefix' => 'api' ], function () use ( $router ) {

    $router->get( '/test', function () {
        \Illuminate\Support\Facades\Cache::put('name', 'Mamun');

        return \Illuminate\Support\Facades\Cache::get('name');
    } );

    $router->post( 'register',          'AuthController@register' );
    $router->post( 'login',             'AuthController@login' );

    $router->group( [ 'middleware' => 'auth' ], function () use ( $router ) {
        $router->get( 'auth-user',          'AuthController@authUser' );

        // Routes for customers
        $router->get( 'customers',          'CustomerController@index' );
        $router->post( 'customers',         'CustomerController@store' );
        $router->delete( 'customers/{id}',  'CustomerController@destroy' );

        // Routes for rooms
        $router->get( 'rooms',              'RoomController@index' );
        $router->post( 'rooms',             'RoomController@store' );
        $router->delete( 'rooms/{id}',      'RoomController@destroy' );
        $router->get( 'available-rooms',    'RoomController@availableRooms' );

        // Routes for Booking
        $router->get( 'bookings',           'BookingController@index' );
        $router->get( 'bookings/{id}',      'BookingController@show' );
        $router->post( 'bookings',          'BookingController@store' );
        $router->delete( 'bookings/{id}',   'BookingController@destroy' );

        $router->get( 'payments',          'PaymentController@index' );
        $router->post( 'payments',          'PaymentController@store' );
        $router->delete( 'payments/{id}',   'PaymentController@destroy' );
    } );

} );


