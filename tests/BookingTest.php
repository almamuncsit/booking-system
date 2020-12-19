<?php

use App\Models\Booking;
use App\Models\CheckIn;
use App\Models\CheckOut;
use App\Models\Customer;
use App\Models\Room;
use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;

class BookingTest extends TestCase
{
    public $user;

    use DatabaseMigrations;

    /**
     * Test Creating Booking
     *
     * @return void
     */
    public function testBooking()
    {
        // Test Without Authentication
        $this->json( 'POST', '/api/v1/bookings', [] );
        $this->assertResponseStatus(401);

        // Create a user and Authenticate
        $this->user = User::factory()->create();
        $this->actingAs( $this->user );

        // Test without input data
        $book = $this->json( 'POST', '/api/v1/bookings', [] );
        $book->assertResponseStatus( 422 ); // Test Status Code for Validations
        // Test Validate Message
        $book->seeJson( [
            'room_id'     => [ "The room id field is required." ],
            'customer_id' => [ "The customer id field is required." ],
        ] );

        $data = [
            'room_id'     => Room::factory()->create()->id,
            'customer_id' => Customer::factory()->create()->id,
        ];

        // Request With Valid Data
        $booking = $this->json( 'POST', '/api/v1/bookings', $data );
        $booking->seeJson( [
            'message' => 'Booked Successfully',
        ] );

        // Check Booking Created in Database on not
        $this->assertEquals(1, Booking::count());
    }

    /**
     * Test Check In of a Booking
     */
    public function testCheckIn()
    {
        // Test Without Authentication
        $this->json( 'POST', '/api/v1/check-in', [] );
        $this->assertResponseStatus(401);

        // Create a user and Authenticate
        $this->user = User::factory()->create();
        $this->actingAs( $this->user );

        // Check IN
        // Check in Without booking_id
        $this->json( 'POST', '/api/v1/check-in', [] );
        $this->assertResponseStatus(422);

        // Checkin with booking id
        $booking = Booking::factory()->create();
        $this->assertEmpty($booking->arrival); // By Default arrival will be empty
        $this->assertEmpty($booking->checkout); // By Default arrival will be empty
        $this->json( 'POST', '/api/v1/check-in', ['booking_id' => $booking->id] );
        $this->assertResponseStatus(201);

        // Check Check In Created in Database on not
        $this->assertEquals(1, CheckIn::count());

        // Query Booking form database and check arrival field
        $newBooking = Booking::find($booking->id);
        $this->assertNotEmpty($newBooking->arrival);

        // Check Room
        $this->assertEquals(1, $newBooking->room->locked);

    }

    /**
     * Test Check Out of a Booking
     */
    public function testCheckOut()
    {
        // Test Without Authentication
        $this->json( 'POST', '/api/v1/check-out', [] );
        $this->assertResponseStatus(401);

        // Create a user and Authenticate
        $this->user = User::factory()->create();
        $this->actingAs( $this->user );

        // Checkin with booking id
        $booking = Booking::factory()->create();
        $this->json( 'POST', '/api/v1/check-in', ['booking_id' => $booking->id] );
        $this->assertResponseStatus(201);

        // Check Out without booking_id
        $this->json( 'POST', '/api/v1/check-out', [] );
        $this->assertResponseStatus(422);

        // Check Out with booking_id
        $this->json( 'POST', '/api/v1/check-out', ['booking_id' => $booking->id] );
        $this->assertResponseStatus(201);

        // Check Check In Created in Database on not
        $this->assertEquals(1, CheckOut::count());

        // Query Booking form database and check arrival field
        $newBooking = Booking::find($booking->id);
        $this->assertNotEmpty($newBooking->checkout);

        // Check Room
        $this->assertEquals(0, $newBooking->room->locked);

    }
}
