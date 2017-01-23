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
            ['MAJOR', 'MINOR', 'PATCH'],
            2
        );

        // get version tag list
        $process = new Process('git tag -l "v*.*.*" | tail -1');
        $process->run();
        if (!$process->isSuccessful()) {
            $this->error("Error retrieving git tag list");

            $this->info("\n");
            exit;
        }

        $currentVersion = trim($process->getOutput());

        // get latest version
        if (empty($currentVersion)) {
            $currentVersion = 'v0.0.0';
        }

        $this->line("Current version: " . $currentVersion);

        // get new version
        $newVersion = $this->upgradeVersion($currentVersion, $releaseType);

        $this->line("New version: $newVersion");

        // create new tag
        $process = new Process("git tag -a '$newVersion' master -m '$releaseType release $newVersion'");
        $process->run();
        if (!$process->isSuccessful()) {
            $this->error("Error creating new git tag");

            $this->info("\n");
            exit;
        }

        $this->info("The tag has been generated");

        // push new tag
        $process = new Process("git push origin $newVersion");
        $process->run();
        if (!$process->isSuccessful()) {
            $this->error("Error pushing tag to remote");

            $this->line("");
            $this->line("You have to push manually");
            $this->line("> git push origin $newVersion");

            $this->info("\n");
            exit;
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
            case 'PATCH':
                $versionParts[2]++;
                break;
            case 'MINOR':
                $versionParts[1]++;
                $versionParts[2] = 0;
                break;
            case 'MAJOR':
                $versionParts[0]++;
                $versionParts[1] = 0;
                $versionParts[2] = 0;
                break;
            default:
                $this->error("Invalid release type");

                $this->info("\n");
                exit;
        }

        $newVersion = "v" . implode('.', $versionParts);

        return $newVersion;
    }
}
