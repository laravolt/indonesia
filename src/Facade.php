<?php

namespace Laravolt\Indonesia;

use Illuminate\Support\Facades\Facade as BaseFacade;

class Facade extends BaseFacade
{
    protected static function getFacadeAccessor()
    {
        return 'indonesia';
    }
}
