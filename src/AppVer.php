<?php

namespace Codimais\AppVer;

use Exception;
use z4kn4fein\SemVer\Version;
use z4kn4fein\SemVer\Inc;

class AppVer
{
    protected Version $version;

    const VERSION_FILE = '.appver';
    const HOOK_FILE = '.git/hooks/pre-commit';

    public function __construct()
    {
        $this->getVersionFromFile();
    }

    public function get(): string
    {
        if( is_null($this->version) )
        {
            throw new Exception("Version not set! Did you run the 'appver:init' command before?");
        }

        return $this->version->withoutSuffixes();
    }

    /**
     * Increment Major
     */
    public function incrementMajor( bool $write_file = false ): string
    {
        $this->increment( Inc::MAJOR, $write_file );

        return $this->version->withoutSuffixes();
    }

    /**
     * Increment minor
     */
    public function incrementMinor( bool $write_file = false ): string
    {
        $this->increment( Inc::MINOR, $write_file );

        return $this->version->withoutSuffixes();
    }

    /**
     * Increment patch
     */
    public function incrementPatch( bool $write_file = false ): string
    {
        $this->increment( Inc::PATCH, $write_file );

        return $this->version->withoutSuffixes();
    }

    /**
     * Writes version to file
     */
    public function save()
    {
        if( is_null($this->version) )
        {
            throw new Exception("Version not set! Did you run the 'appver:init' command before?");
        }

        $this->saveToFile();
    }

    /**
     * Creates the version file
     */
    public function create( $start_version )
    {
        $this->version = Version::parse( $start_version );

        $this->saveToFile();
    }

    /**
     * Creates the githook file
     */
    public function createGitHook(): bool
    {
        return $this->writeGitHookFile();
    }

    // Protected Methods
    protected function increment( $part, bool $save = false )
    {
        if( is_null($this->version) )
        {
            throw new Exception("Version not set! Did you run the 'appver:init' command before?");
        }

        // Get config
        $config = config('appver');

        if( ($config['max_patch'] > 0) || ($config['max_minor'] > 0) )
        {
            $major = $this->version->getMajor();
            $minor = $this->version->getMinor();
            $patch = $this->version->getPatch();
            
            if( $part === Inc::PATCH )
            {
                $patch++;

                if( $patch >= $config['max_patch'] )
                {
                    $patch = 0;
                    $minor++;
                }
            }

            if( $part === Inc::MINOR )
            {
                $minor++;

                if( $minor >= $config['max_minor'] )
                {
                    $minor = 0;
                    $major++;
                }
            }

            $new_version = Version::create( $major, $minor, $patch );
        }
        else
        {
            $new_version   = $this->version->inc( $part );
        }

        //
        $this->version = $new_version;

        if( $save )
            $this->saveToFile();
    }

    /**
     * Saves version to default version file
     */
    protected function saveToFile()
    {
        // Get root path
        $filepath = base_path( self::VERSION_FILE );

        try
        {
            $fhandle = fopen( $filepath, "w" );
            fwrite( $fhandle, $this->version->withoutSuffixes() );
            fclose($fhandle);

            return true;
        }
        catch( Exception $e )
        {
            return false;
        }
    }

    /**
     * Load version from default version file
     */
    protected function getVersionFromFile()
    {
        // Get root path
        $filepath = base_path( self::VERSION_FILE );

        if( ! file_exists( $filepath ) )
            return;

        $this->version = Version::parse( file_get_contents($filepath) );
    }

    /**
     * Writes the git hook pre-commit file
     */
    protected function writeGitHookFile(): bool
    {
        $filepath = base_path( self::HOOK_FILE );

        try
        {
            $fhandle = fopen( $filepath, "w" );
            fwrite( $fhandle, '#!/bin/bash' . PHP_EOL );
            fwrite( $fhandle, 'php artisan appver:inc' . PHP_EOL );
            fwrite( $fhandle, 'git add ' . self::VERSION_FILE );
            fclose($fhandle);

            chmod( $filepath, 0755 );

            return true;
        }
        catch( Exception $e )
        {
            return false;
        }
    }
}
