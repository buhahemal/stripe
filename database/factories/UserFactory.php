<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'profileimg' => 'https://www.searchpng.com/wp-content/uploads/2019/02/Men-Profile-Image-715x657.png',
            'birthdate' => time(),
            'currentaddress' => $this->faker->address(),
            'permenentaddress' => $this->faker->address()
        ];
    }

}
