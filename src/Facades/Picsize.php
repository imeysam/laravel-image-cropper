<?php

namespace Imeysam\Picsize\Facades;

use Illuminate\Support\Facades\Facade;

class Picsize extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-picsize';
    }
}
