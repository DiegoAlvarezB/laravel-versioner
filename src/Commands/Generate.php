<?php

namespace Diegoalvarezb\Versioner\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class Generate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'versioner:git:new';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new version tag in Git';

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
        $this->line("Generate a new version tag in Git");
        $this->line("---------------------------------");
        $this->line("");

        $releaseType = $this->choice(
            'What kind of release do you want to generate?',
            ['release', 'beta', 'alpha'],
            2
        );

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

        $this->line("Current version: " . $currentVersion);

        // get new version
        $newVersion = $this->upgradeVersion($currentVersion, $releaseType);

        $this->line("New version: $newVersion");

        // create new tag
        $process = new Process("git tag -a '$newVersion' -m '$releaseType release $newVersion'");
        $process->run();
        if (!$process->isSuccessful()) {
            $this->error('Error creating new git tag');
        }

        $this->info("The tag has been generated");

        // push new tag
        $process = new Process("git push --tags");
        $process->run();
        if (!$process->isSuccessful()) {
            $this->error('Error pushing git tag to remote');
        }

        $this->info("The tag has been pushed");
        $this->info("\n");
    }

    /**
     * Generate a new version of the release type recieved by console argument.
     *
     * @param  string $currentVersion
     * @param  string $releaseType
     * @return string
     */
    protected function upgradeVersion($currentVersion, $releaseType)
    {
        $versionParts = explode('.', substr($currentVersion, 1));

        switch ($releaseType) {
            case 'alpha':
                $versionParts[2]++;
                break;
            case 'beta':
                $versionParts[1]++;
                $versionParts[2] = 0;
                break;
            case 'release':
                $versionParts[0]++;
                $versionParts[1] = 0;
                $versionParts[2] = 0;
                break;
            default:
                $this->error("Invalid argument");
        }

        $newVersion = "v" . implode('.', $versionParts);

        return $newVersion;
    }
}
