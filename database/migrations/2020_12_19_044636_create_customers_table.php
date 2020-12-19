<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'customers', function ( Blueprint $table ) {
            $table->id();
            $table->string( 'first_name', 80 );
            $table->string( 'last_name', 80 );
            $table->string( 'email', 150 );
            $table->string( 'phone', 15 );
            $table->timestamp( 'registered_at' );
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
        Schema::dropIfExists( 'customers' );
    }
}
