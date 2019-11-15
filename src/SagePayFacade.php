<?php

namespace DivideBuy\Payment;

use Illuminate\Support\Facades\Facade;

class SagePayFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'sage-pay';
    }
}
