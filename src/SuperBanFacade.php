<?php

namespace EdenLife\SuperBan;

use Illuminate\Support\Facades\Facade;

/**
 * @see \EdenLife\SuperBan\Skeleton\SkeletonClass
 */
class SuperBanFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'superban';
    }
}
