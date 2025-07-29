# Laravel Image Cropper

[![Latest Version on Packagist](https://img.shields.io/packagist/v/imeysam/laravel-image-cropper.svg?style=flat-square)](https://packagist.org/packages/imeysam/laravel-image-cropper)
[![Total Downloads](https://img.shields.io/packagist/dt/imeysam/laravel-image-cropper.svg?style=flat-square)](https://packagist.org/packages/imeysam/laravel-image-cropper)
[![License](https://img.shields.io/github/license/imeysam/laravel-image-cropper.svg?style=flat-square)](LICENSE)

---

## ✂️ Simple & Flexible Laravel Image Cropper

**Laravel Image Cropper** is a simple, flexible and SOLID-friendly Laravel package that helps you crop and resize images on the fly, then store and reuse the resized versions — all with one line of code.

It’s designed for Laravel projects that need **on-demand thumbnails**, **resized images**, or **optimized storage**, without reinventing the wheel every time.

---

## 📋 Features

✅ Simple Facade: `Cropper::crop($path, $width, $height)`  
✅ Disk-based storage (local, public, S3, FTP, etc.)  
✅ Automatic fallback image if source is missing  
✅ Respects Laravel’s Filesystem & URL helpers  
✅ Auto-creates output folders with proper permissions (local disks)  
✅ Compatible with **Laravel 9.x – 12.x**

---

## ⚙️ Requirements

- **PHP** >= 8.1
- **Laravel** >= 9.x  
- [Intervention Image](http://image.intervention.io/) (included)

---

## 🚀 Installation

Install the package via Composer:

```bash
composer require imeysam/laravel-image-cropper
```

## 🔧 1️⃣ Add & Customize Config

By default, the package uses these settings:
- `disk` → `public`
- `input_path` → `uploads`
- `output_path` → `images`
- `fallback_image` → `images/default.jpg`

To customize these, **publish the config file**.  
You can do this in two ways:

**Option 1 — Using the Provider name (recommended)**  
```bash
php artisan vendor:publish --provider="Imeysam\ImageCropper\Providers\CropperServiceProvider"
```

**Option 1 — Using the tag `config`**  
```bash
php artisan vendor:publish --tag=config
```  


> `config/cropper.php`

```php
return [
    'disk' => 'public',

    'input_path' => 'uploads',

    'output_path' => 'images',

    'fallback_image' => 'images/default.jpg',
];

```

## ✨ Usage

Once installed and configured, using the cropper is super simple.

You can call the `crop` method using the Facade, or inject the service into your classes.

---

### 📌 Basic Using

```php
use Cropper;

class ImageController extends Controller
{
    public function show()
    {
        // Crop to 400x300 and get the full URL
        $url = Cropper::crop('photos/test.jpg', 400, 300);
        ...
    }
}
```

### 🧩 Using Dependency Injection

```php
use Imeysam\ImageCropper\ImageCropper;

class ImageController extends Controller
{
    public function show(ImageCropper $cropper)
    {
        // Crop to 400x300 and get the full URL
        $url = $cropper->crop('photos/test.jpg', 600, 300);
        ...
    }
}
```


## ⚖️ License ##
- This package is created for Laravel >= 9.x and is released under the **MIT License** and, based on [Intervention Image](https://github.com/intervention/image).
