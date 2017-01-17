<?php

namespace Diegoalvarezb\Versioner;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class GenerateVersion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'versioner:git:release {type=alpha}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $releaseType = $this->argument('type');

        $process = new Process('git tag -l "v*.*.*"');
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $processResult = trim($process->getOutput());

        if (empty($processResult)) {
            $lastVersion = "v0.0.0";
        } else {
            $tagList = explode(PHP_EOL, trim($processResult));

            $lastVersion = $tagList[count($tagList) - 1];
        }

        $versionParts = explode('.', substr($lastVersion, 1));

        switch ($releaseType) {
            case 'alpha':
                $versionParts[2]++;
                break;
            case 'beta':
                $versionParts[1]++;
                break;
            case 'release':
                $versionParts[0]++;
                break;
            default:
                echo "mal";
                return;
        }

        $newVersion = "v" . implode('.', $versionParts);

        $process = new Process("git tag -a '$newVersion' -m '$releaseType release $newVersion'");
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $process = new Process("git push --tags");
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }
}
