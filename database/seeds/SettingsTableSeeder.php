<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    public function run()
    {
        // Uncomment the below to wipe the table clean before populating
        DB::table('settings')->truncate();

        $settings = [
            ['name' => 'userDir', 'value' => shell_exec('cd ~; pwd')],
            ['name' => 'homesteadFlag', 'value' => 0],
            ['name' => 'homesteadLocation', 'value' => null],
            ['name' => 'homesteadIp', 'value' => '192.168.10.10'],
            ['name' => 'nginxFlag', 'value' => 0],
            ['name' => 'nginxConfigLocation', 'value' => null],
        ];

        // Uncomment the below to run the seeder
        DB::table('preferences_users')->insert($settings);
    }
}
