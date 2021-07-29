<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rolesDetail = [
            ['rolename' => 'PHP Developer','created_at' => time(),'updated_at' => time()],
            ['rolename' => 'Laravel Developer','created_at' => time(),'updated_at' => time()],
            ['rolename' => 'AWS Solution Architect','created_at' => time(),'updated_at' => time()],
            ['rolename' => 'AWS Devops','created_at' => time(),'updated_at' => time()],
            ['rolename' => 'Backend Engineer','created_at' => time(),'updated_at' => time()],
            ['rolename' => 'Front-End Developer','created_at' => time(),'updated_at' => time()],
            ['rolename' => 'Back-End Developer','created_at' => time(),'updated_at' => time()],
        ];
        Role::insert($rolesDetail);
    }
}
