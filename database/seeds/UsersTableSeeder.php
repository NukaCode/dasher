<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

    public function run()
    {
        // Uncomment the below to wipe the table clean before populating
        DB::table('users')->truncate();

        $users = [
            [
                'uniqueId'      => '2bHAJwWCX2',
                'username'      => 'riddles',
                'password'      => Hash::make('test'),
                'firstName'     => 'Brandon',
                'lastName'      => 'Hyde',
                'status_id'     => '1',
                'email'         => 'riddles@dev-toolbox.com',
                'gravatarEmail' => 'riddles@dev-toolbox.com',
                'created_at'    => date('Y-m-d H:i:s')
            ],
            [
                'uniqueId'      => 'bmeJBz10K2',
                'username'      => 'Stygian',
                'password'      => Hash::make('test'),
                'firstName'     => 'Travis',
                'lastName'      => 'Blasingame',
                'status_id'     => '1',
                'email'         => 'stygian.warlock.v2@gmail.com',
                'gravatarEmail' => 'stygian.warlock.v2@gmail.com',
                'created_at'    => date('Y-m-d H:i:s')
            ],
        ];

        // Uncomment the below to run the seeder
        DB::table('users')->insert($users);
    }
}