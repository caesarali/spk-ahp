<?php

use Illuminate\Database\Seeder;

class IndexRandomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $index = [
            ['n' => 1, 'IR' => 0],
            ['n' => 2, 'IR' => 0],
            ['n' => 3, 'IR' => 0.58],
            ['n' => 4, 'IR' => 0.9],
            ['n' => 5, 'IR' => 1.12],
            ['n' => 6, 'IR' => 1.24],
            ['n' => 7, 'IR' => 1.32],
            ['n' => 8, 'IR' => 1.41],
            ['n' => 9, 'IR' => 1.45],
            ['n' => 10, 'IR' => 1.49],
        ];

        DB::table('index_random')->insert($index);
    }
}
