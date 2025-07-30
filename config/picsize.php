<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | This option controls which filesystem disk will be used for both
    | reading the original images and saving the resized images.
    | You can set it to any disk defined in config/filesystems.php.
    |
    | Example: 'public', 'local', 's3'
    |
    */

    'disk' => 'public',

    /*
    |--------------------------------------------------------------------------
    | Default Input Directory
    |--------------------------------------------------------------------------
    |
    | Path to the folder where original images are stored.
    | This path is relative to the root of the selected disk.
    |
    | Example: if you use the "public" disk, your images might be in:
    | storage/app/public/uploads
    |
    */

    'input_path' => 'uploads',

    /*
    |--------------------------------------------------------------------------
    | Default Output Directory
    |--------------------------------------------------------------------------
    |
    | Path to the folder where resized images will be saved.
    | This path is relative to the root of the selected disk.
    |
    | Example: if you use the "public" disk, resized images will be saved in:
    | storage/app/public/images
    |
    */

    'output_path' => 'images',

    /*
    |--------------------------------------------------------------------------
    | Default Fallback Image
    |--------------------------------------------------------------------------
    |
    | If the requested source image does not exist,
    | this fallback image URL or relative path will be used instead.
    | This path should be accessible publicly (e.g., in the public folder).
    |
    */

    'fallback_image' => 'images/default.jpg',

];
