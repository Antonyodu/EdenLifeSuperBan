<?php

namespace SuperBan;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SuperBanSkeleton\SkeletonClass
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
