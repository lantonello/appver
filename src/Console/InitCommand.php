<?php

namespace Codimais\AppVer\Console;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Codimais\AppVer\AppVerServiceProvider;
use Codimais\AppVer\AppVer;

class InitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appver:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishes, configures and initializes the AppVer.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $appver = new AppVer();

        // Publishing config file
        //$this->info('Publishing AppVer config...');
        //$this->call('vendor:publish', ['--provider' => AppVerServiceProvider::class]);

        // Ask for initial version
        $start_version = $this->askForStartVersion();

        $appver->create( $start_version );

        // Check if your app have git
        $is_git_repo = $this->checkForGit();

        if( $is_git_repo )
        {
            if( $this->askForGitHook() )
            {
                $appver->createGitHook();

                $this->info('Pre Commit hook created.');
            }
        }
        else
        {
            $this->info('It looks like your application is not in a git repository.');
            $this->info('Therefore, whenever you want to increase the version of your application, you must use the appver:inc command.');
        }
        

        $this->info(' ');
        $this->info('Your application version is all set!');
        $this->info('Thanks for using AppVer. Hope you enjoy it!');

        return 0;
    }

    private function checkForGit(): bool
    {
        $command = 'git rev-parse --is-inside-work-tree';

        try
        {
            exec( $command, $output, $result );

            if( $result === 0 )
                return true;

            return false;
        }
        catch( Exception $e )
        {
            // Git not found or not installed
            return false;
        }
    }

    private function askForGitHook(): bool
    {
        $this->info(' ');

        $this->question('Would you like to set a version increment before each commit?');

        $anwser = $this->choice('Auto-increment', ['Yes', 'No'], 1);

        return ($anwser === 'Yes') ? true : false;
    }

    private function askForStartVersion(): string
    {
        $this->info(' ');

        $this->question('Please type the initial version of your application (defaults to 1.0.0)');

        return $this->ask('Version', '1.0.0');
    }
}
