<?php

namespace ViralsBackpack\BackPackAPI\Facades;

use Illuminate\Support\Facades\Facade;

class BackPackAPI extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'BackPackAPI';
    }
}
