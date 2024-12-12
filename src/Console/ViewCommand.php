<?php

namespace Codimais\AppVer\Console;

use Illuminate\Console\Command;
use Codimais\AppVer\AppVer;

class ViewCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appver:view';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display the application version.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $appver = new AppVer();

        $this->line(' ');
        $this->info('AppVer');
        $this->info(">> Current version: '{$appver->get()}'");
        $this->line(' ');

        return 0;
    }
}
