<?php

namespace Imeysam\ImageCropper\Contracts;

interface ImageCropperInterface
{
    /**
     * Crop and resize the image.
     *
     * @param string $sourcePath Relative path to source image.
     * @param int $width Desired width.
     * @param int $height Desired height.
     * @return string URL to the cropped image.
     */
    public function crop(string $sourcePath, int $width, int $height): string;
}
