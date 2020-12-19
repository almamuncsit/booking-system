<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'room_id'        => Room::factory()->create()->id,
            'customer_id'    => Customer::factory()->create()->id,
            'user_id'        => User::factory()->create()->id,
            'book_time'      => Carbon::now(),
            'payment_status' => 'pending'
        ];
    }
}
