<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'superadmin', 'display_name' => 'Superadmin'],
            ['name' => 'admin', 'display_name' => 'Administrator'],
            ['name' => 'user', 'display_name' => 'User'],
        ]);
    }
}
