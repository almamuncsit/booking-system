<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Room::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'room_number' => $this->faker->numberBetween(100, 200),
            'price' => $this->faker->numberBetween(1000, 1000),
            'locked' => $this->faker->boolean,
            'max_persons' => $this->faker->numberBetween(1, 4),
            'root_type' => $this->faker->randomKey(['premium', 'normal', 'vip'])
        ];
    }
}
