<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ExecutableFinder;

class ComposerDumpCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:composer-dump';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Run 'composer dump' command";

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $executableFinder = new ExecutableFinder();
        $composerPath = $executableFinder->find(
            'composer',
            base_path('/composer.phar'),
            extraDirs: [
                '/usr/bin/',
            ]
        );

        $process = new Process([$composerPath, 'dump']);
        $process->run(function ($type, $buffer): void {
            if (Process::ERR === $type) {
                echo 'ERR > ' . $buffer;
            } else {
                echo 'OUT > ' . $buffer;
            }
        });

        $process->stop(3, SIGINT);
    }
}
