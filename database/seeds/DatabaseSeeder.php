<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesSeeder::class);
        $this->call(CriteriaSeeder::class);
        $this->call(RatingScaleSeeder::class);
        $this->call(IndexRandomSeeder::class);
    }
}
