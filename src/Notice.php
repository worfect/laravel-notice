<?php


namespace Worfect\Notice;

use Illuminate\Support\Facades\Facade;

class Notice extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'notice';
    }
}
