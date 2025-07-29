<?php

namespace IMeysam\ImageCropper\Providers;

use Illuminate\Support\ServiceProvider;
use IMeysam\ImageCropper\ImageCropper;
use IMeysam\ImageCropper\Contracts\ImageCropperInterface;
use Intervention\Image\ImageManager;

class CropperServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/cropper.php', 'cropper');

        $this->app->singleton(ImageCropperInterface::class, function ($app) {
            return new ImageCropper(new ImageManager());
        });

        $this->app->alias(ImageCropperInterface::class, 'image-cropper');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/cropper.php' => config_path('cropper.php'),
        ], 'config');
    }
}
