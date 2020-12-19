<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'bookings', function ( Blueprint $table ) {
            $table->id();
            $table->dateTime( 'arrival' );
            $table->dateTime( 'checkout' );
            $table->unsignedBigInteger( 'room_id' );
            $table->unsignedBigInteger( 'customer_id' );
            $table->unsignedBigInteger( 'user_id' );
            $table->dateTime( 'book_time' );
            $table->string( 'payment_status' )->default( 'pending' )->comment( 'pending, paid, due' );

            $table->foreign( 'customer_id' )->references( 'id' )->on( 'customers' );
            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' );
            $table->foreign( 'room_id' )->references( 'id' )->on( 'rooms' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'bookings' );
    }
}
