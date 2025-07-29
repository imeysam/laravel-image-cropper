<?php

namespace Imeysam\ImageCropper\Providers;

use Illuminate\Support\ServiceProvider;
use Imeysam\ImageCropper\ImageCropper;
use Imeysam\ImageCropper\Contracts\ImageCropperInterface;
use Intervention\Image\ImageManager;

class CropperServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/cropper.php', 'cropper');

        $this->app->singleton(ImageCropperInterface::class, function ($app) {
            return new ImageCropper(new ImageManager());
        });

        $this->app->alias(ImageCropperInterface::class, 'laravel-image-cropper');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/cropper.php' => config_path('cropper.php'),
        ], 'config');
    }
}
