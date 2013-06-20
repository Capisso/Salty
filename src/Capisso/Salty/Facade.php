<?php

namespace Capisso\Salty;

use Illuminate\Support\Facades\Facade as IlluminateFacade;

class Facade extends IlluminateFacade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'salty';
    }

    /**
     * Serve a collection or number of collections.
     *
     * @return string
     */
    public static function show()
    {

    }

}