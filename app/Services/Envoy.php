<?php

namespace App\Services;

use Symfony\Component\Process\Process;

class Envoy
{

    public function run($task, $live = false)
    {
        $result = [];

        $process = new Process('~/.composer/vendor/bin/envoy run '. $task);
        $process->setTimeout(3600);
        $process->setIdleTimeout(300);
        $process->setWorkingDirectory(base_path());
        $process->run(
            function ($type, $buffer) use ($live, &$result) {
                $buffer = str_replace('[127.0.0.1]: ', '', $buffer);

                if ($live) {
                    echo $buffer . '</br />';
                }

                $result[] = $buffer;
            }
        );

        return $result;
    }
}