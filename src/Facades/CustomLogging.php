<?php

namespace CustomLogCreator\CustomLogging\Facades;

use Illuminate\Support\Facades\Facade;

class CustomLogging extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'customlogging';
    }
}
