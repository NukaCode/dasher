<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    public function run()
    {
        // Uncomment the below to wipe the table clean before populating
        DB::table('settings')->truncate();

        $settings = [
            [
                'name'    => 'userDir',
                'enabled' => null,
                'value'   => trim(shell_exec('cd ~; pwd'))
            ],
            [
                'name'    => 'homesteadIp',
                'enabled' => null,
                'value'   => '192.168.10.10'
            ],
            [
                'name'    => 'homestead',
                'enabled' => 0,
                'value'   => trim(str_replace('/Vagrantfile', '', shell_exec('locate "Homestead/Vagrantfile";')))
            ],
            [
                'name' => 'nginx',
                'enabled' => 0,
                'value' => 0
            ],
            [
                'name' => 'phpstorm',
                'enabled' => 0,
                'value' => trim(shell_exec('locate "PhpStorm.app/Contents/MacOS/phpstorm"'))
            ],
            [
                'name' => 'sublime',
                'enabled' => 0,
                'value' => trim(shell_exec('locate "Sublime Text.app/Contents/SharedSupport/bin/subl"'))
            ],
            [
                'name' => 'atom',
                'enabled' => 0,
                'value' => trim(shell_exec('locate "Atom.app/Contents/Resources/app/atom.sh"'))
            ],
        ];

        // Uncomment the below to run the seeder
        DB::table('settings')->insert($settings);
    }
}
