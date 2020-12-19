<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'rooms', function ( Blueprint $table ) {
            $table->id();
            $table->string( 'room_number', 20 );
            $table->double( 'price' );
            $table->boolean( 'locked' );
            $table->integer( 'max_persons' );
            $table->string( 'root_type' );
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'rooms' );
    }
}
