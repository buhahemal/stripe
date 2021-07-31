<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'profileimg' => 'placeholder-image.jpg',
            'birthdate' => date('Y-m-d',strtotime("-1 days")),
            'currentaddress' => $this->faker->address(),
            'permenentaddress' => $this->faker->address()
        ];
    }

}
