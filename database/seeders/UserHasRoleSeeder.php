<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserHasRole;
use Illuminate\Database\Seeder;

class UserHasRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::all()->each(function ($user) {
            $user->roles()->sync([rand(1,7)]);
        });
    }
}
