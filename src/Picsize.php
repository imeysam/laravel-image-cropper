<?php

namespace Imeysam\Picsize;

use Imeysam\Picsize\Contracts\PicsizeInterface;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Local\LocalFilesystemAdapter;

class Picsize implements PicsizeInterface
{
    protected ImageManager $imageManager;

    protected string $disk;
    protected string $inputPath;
    protected string $outputPath;
    protected string $fallbackImage;

    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;

        $this->disk = config('picsize.disk', 'public');
        $this->inputPath = trim(config('picsize.input_path', 'uploads'), '/');
        $this->outputPath = trim(config('picsize.output_path', 'images'), '/');
        $this->fallbackImage = config('picsize.fallback_image', 'images/default.jpg');
    }

    /**
     * {@inheritdoc}
     */
    public function resize(?string $sourcePath, int $width, int $height): string
    {
        if(empty($sourcePath))
        {
            $sourcePath = $this->fallbackImage;
        }

        $sourcePath = ltrim($sourcePath, '/');
        $inputFullPath = "{$this->inputPath}/{$sourcePath}";

        $disk = Storage::disk($this->disk);

        // Use the fallback image if the source file could not found
        if (!$disk->exists($inputFullPath)) {
            $sourcePath = $this->fallbackImage;
            $inputFullPath = $this->fallbackImage;
        }

        $dirname = pathinfo($sourcePath, PATHINFO_DIRNAME);

        $filename = "";
        if(!empty($dirname) && $dirname !== '.')
        {
            $filename .= ($dirname . DIRECTORY_SEPARATOR);
        }
        $filename .= pathinfo($sourcePath, PATHINFO_FILENAME);
        $extension = pathinfo($sourcePath, PATHINFO_EXTENSION);
        $outputName = "{$filename}_{$width}x{$height}.{$extension}";

        $outputFullPath = "{$this->outputPath}/{$outputName}";

        // If the resized image exists
        if ($disk->exists($outputFullPath)) {
            return $disk->url($outputFullPath);
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
                chown($fullDirectoryPath, "www-data");
            }
        }

        // Store the resized image on the disk
        $disk->put($outputFullPath, (string) $image->encode());

        return $disk->url($outputFullPath);
    }
}
