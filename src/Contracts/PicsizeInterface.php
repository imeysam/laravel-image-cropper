<?php

namespace Imeysam\Picsize\Contracts;

interface PicsizeInterface
{
    /**
     * Resize and resize the image.
     *
     * @param string $sourcePath Relative path to source image.
     * @param int $width Desired width.
     * @param int $height Desired height.
     * @return string URL to the resized image.
     */
    public function resize(?string $sourcePath, int $width, int $height): string;
}
