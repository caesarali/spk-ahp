<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Caesar Ali L.',
            'username' => 'caesarali',
            'email' => 'caesaralilamondo@gmail.com',
            'password' => bcrypt('anaheim99')
        ]);
        $admin->assignRole('superadmin');

        $user = User::create([
            'name' => 'User STMIK AKBA',
            'username' => 'stmikakba',
            'email' => 'stmikakba@sipilma',
            'password' => bcrypt('stmikakba')
        ]);
        $user->assignRole('user');
    }
}
