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
            $table->string( 'room_number' );
            $table->dateTime( 'arrival' );
            $table->dateTime( 'checkout' );
            $table->unsignedBigInteger( 'customer_id' );
            $table->string( 'book_type' );
            $table->dateTime( 'book_time' );
            $table->unsignedBigInteger( 'user_id' );

            $table->foreign( 'customer_id' )->references( 'id' )->on( 'customers' );
            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' );
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
