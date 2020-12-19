<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthenticationTest extends TestCase
{
    public $user;

    use DatabaseMigrations;

    /**
     * Check Booking list API Authentication
     *
     * @return void
     */
    public function testBookingListAuthentication()
    {
        // Test Without Authentication
        $this->get('api/v1/bookings?page=1');
        $this->assertResponseStatus(401);

        // Create a user and Authenticate
        $this->user = User::factory()->create();
        $this->actingAs( $this->user );

        // Test After Authentication
        $this->get('api/v1/bookings?page=1');
        $this->assertResponseStatus(200);
    }


    /**
     * Check Room list API Authentication
     *
     * @return void
     */
    public function testRoomListAuthentication()
    {
        // Test Without Authentication
        $this->get('api/v1/rooms?page=1');
        $this->assertResponseStatus(401);

        // Create a user and Authenticate
        $this->user = User::factory()->create();
        $this->actingAs( $this->user );

        // Test After Authentication
        $this->get('api/v1/rooms?page=1');
        $this->assertResponseStatus(200);
    }

    /**
     * Check Room list API Authentication
     *
     * @return void
     */
    public function testCustomerListAuthentication()
    {
        // Test Without Authentication
        $this->get('api/v1/customers?page=1');
        $this->assertResponseStatus(401);

        // Create a user and Authenticate
        $this->user = User::factory()->create();
        $this->actingAs( $this->user );

        // Test After Authentication
        $this->get('api/v1/customers?page=1');
        $this->assertResponseStatus(200);
    }
}
