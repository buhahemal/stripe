<?php

namespace Database\Seeders;

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
        UserHasRole::factory()->times(10)->create();
    }
}
