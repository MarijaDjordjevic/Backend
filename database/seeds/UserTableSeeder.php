<?php

use App\Model\User;
use Illuminate\Database\Seeder;

/**
 * Class UserTableSeeder
 */
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Peter Parker';
        $user->email = 'peter_parker@mail.com';
        $user->password = bcrypt('peter123');
        $user->save();

        $user = new User();
        $user->name = 'Susan Smith';
        $user->email = 'susan_smith@mail.com';
        $user->password = bcrypt('susan123');
        $user->save();
    }
}
