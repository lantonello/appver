<?php

namespace Codimais\AppVer;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Codimais\Laraversion\Skeleton\SkeletonClass
 */
class AppVerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'appver';
    }
}
