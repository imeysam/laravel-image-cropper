<?php

namespace Imeysam\ImageCropper\Facades;

use Illuminate\Support\Facades\Facade;

class Cropper extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-image-cropper';
    }
}
