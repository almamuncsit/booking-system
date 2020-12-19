<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'checkins', function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'booking_id' );
            $table->unsignedBigInteger( 'user_id' );
            $table->dateTime( 'checked_in_at' );

            $table->foreign( 'booking_id' )->references( 'id' )->on( 'bookings' );
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
        Schema::dropIfExists( 'checkins' );
    }
}
