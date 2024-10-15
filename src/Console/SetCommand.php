<?php

namespace Codimais\AppVer\Console;

use Illuminate\Console\Command;
use Codimais\AppVer\AppVer;

class SetCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appver:set
                            {version : The version to be set up}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets up the application version.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $ver = $this->argument('version');
        $appver = new AppVer();

        $appver->create( $ver );

        $appver->save();

        $this->line(' ');
        $this->info('AppVer');
        $this->info(">> Version set to '{$appver->get()}'");
        $this->line(' ');

        return 0;
    }
}
