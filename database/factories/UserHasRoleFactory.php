<?php

namespace Database\Factories;

use App\Models\UserHasRole;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserHasRoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserHasRole::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'userid' => rand(1,10),
            'roleid' => rand(1,7),
        ];
    }
}
