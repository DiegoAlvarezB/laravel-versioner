<?php

namespace Diegoalvarezb\Versioner\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class Show extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'versioner:git:show';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show current version tag in Git';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line("\n");
        $this->line("Show current version tag in Git");
        $this->line("-------------------------------");
        $this->line("");

        // get version tag list
        $process = new Process('git tag -l "v*.*.*"');
        $process->run();
        if (!$process->isSuccessful()) {
            $this->error('Error retrieving git tag list');
        }

        $processResult = trim($process->getOutput());

        // get latest version
        if (empty($processResult)) {
            $currentVersion = "v0.0.0";
        } else {
            $tagList = explode(PHP_EOL, trim($processResult));

            $currentVersion = $tagList[count($tagList) - 1];
        }

        $this->info("Current version: " . $currentVersion);
        $this->info("\n");
    }
}
