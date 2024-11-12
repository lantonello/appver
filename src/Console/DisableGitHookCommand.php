<?php

namespace Codimais\AppVer\Console;

use Illuminate\Console\Command;
use Codimais\AppVer\AppVer;

class DisableGitHookCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appver:dishook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disable the githook pre-commit instructions.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $appver = new AppVer();

        $appver->removeGitHook();

        $this->line(' ');
        $this->info('AppVer');
        $this->info(">> GitHook instruction removed");
        $this->line(' ');

        return 0;
    }
}
