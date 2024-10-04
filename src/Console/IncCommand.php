<?php

namespace Codimais\AppVer\Console;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Codimais\AppVer\AppVerServiceProvider;
use Codimais\AppVer\AppVer;

class IncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appver:inc
                            {--major : Indicates the major version increment}
                            {--minor : Indicates the minor version increment}
                            {--patch : Indicates the patch version increment}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Increases the application version.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $major = $this->option('major');
        $minor = $this->option('minor');
        $patch = $this->option('patch');

        $appver = new AppVer();

        $old_version = $appver->get();

        if( $major )
            $appver->incrementMajor();

        if( $minor )
            $appver->incrementMinor();

        if( $patch )
            $appver->incrementPatch();

        $appver->save();

        $this->info("Version changed from '{$old_version}' to '{$appver->get()}'");
    }
}
