<?php

namespace Imeysam\ImageCropper;

use Imeysam\ImageCropper\Contracts\ImageCropperInterface;
use Intervention\Image\ImageManager;

class ImageCropper implements ImageCropperInterface
{
    protected ImageManager $imageManager;

    protected string $inputPath;
    protected string $outputPath;
    protected string $fallbackImage;

    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;

        $this->inputPath = config('cropper.input_path', 'uploads');
        $this->outputPath = config('cropper.output_path', 'images');
        $this->fallbackImage = config('cropper.fallback_image', 'images/default.jpg');
    }

    /**
     * {@inheritdoc}
     */
    public function crop(string $sourcePath, int $width, int $height): string
    {
        $sourceFullPath = public_path("{$this->inputPath}/{$sourcePath}");

        $filename = pathinfo($sourcePath, PATHINFO_FILENAME);
        $extension = pathinfo($sourcePath, PATHINFO_EXTENSION);
        $outputName = "{$filename}_{$width}x{$height}.{$extension}";

        $outputFullPath = public_path("{$this->outputPath}/{$outputName}");

        if (!file_exists($outputFullPath)) {
            if (!file_exists($sourceFullPath)) {
                return asset($this->fallbackImage);
            }

            $image = $this->imageManager->make($sourceFullPath)
                ->fit($width, $height, function ($constraint) {
                    $constraint->upsize();
                });

            $image->save($outputFullPath);
        }

        return asset("{$this->outputPath}/{$outputName}");
    }
}
