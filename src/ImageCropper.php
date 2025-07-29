<?php

namespace Imeysam\ImageCropper;

use Imeysam\ImageCropper\Contracts\ImageCropperInterface;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Local\LocalFilesystemAdapter;

class ImageCropper implements ImageCropperInterface
{
    protected ImageManager $imageManager;

    protected string $disk;
    protected string $inputPath;
    protected string $outputPath;
    protected string $fallbackImage;

    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;

        $this->disk = config('cropper.disk', 'public');
        $this->inputPath = trim(config('cropper.input_path', 'uploads'), '/');
        $this->outputPath = trim(config('cropper.output_path', 'images'), '/');
        $this->fallbackImage = config('cropper.fallback_image', 'images/default.jpg');
    }

    /**
     * {@inheritdoc}
     */
    public function crop(?string $sourcePath, int $width, int $height): string
    {
        if(empty($sourcePath))
        {
            $sourcePath = $this->fallbackImage;
        }
        $sourcePath = ltrim($sourcePath, '/');

        $dirname = pathinfo($sourcePath, PATHINFO_DIRNAME);
        $filename = $dirname . DIRECTORY_SEPARATOR . pathinfo($sourcePath, PATHINFO_FILENAME);
        $extension = pathinfo($sourcePath, PATHINFO_EXTENSION);
        $outputName = "{$filename}_{$width}x{$height}.{$extension}";

        $outputFullPath = "{$this->outputPath}/{$outputName}";
        $inputFullPath = "{$this->inputPath}/{$sourcePath}";

        $disk = Storage::disk($this->disk);

        // If the cropped image exists
        if ($disk->exists($outputFullPath)) {
            return $disk->url($outputFullPath);
        }

        // Return fallback image if the source file could not be found
        if (!$disk->exists($inputFullPath)) {
            $inputFullPath = $this->fallbackImage;
            // return asset($this->fallbackImage);
        }

        // Read the file content
        $sourceStream = $disk->get($inputFullPath);

        // Generate the image
        $image = $this->imageManager->make($sourceStream)
            ->fit($width, $height, function ($constraint) {
                $constraint->upsize();
            });

        // If the selected disk is local
        if ($disk->getAdapter() instanceof LocalFilesystemAdapter) {
            $rootPath = $disk->path('');
            $fullDirectoryPath = dirname($rootPath . '/' . $outputFullPath);

            if (!file_exists($fullDirectoryPath)) {
                mkdir($fullDirectoryPath, 0755, true);
                chmod($fullDirectoryPath, 0755);
            }
        }

        // Store the cropped image on the disk
        $disk->put($outputFullPath, (string) $image->encode());

        return $disk->url($outputFullPath);
    }
}
