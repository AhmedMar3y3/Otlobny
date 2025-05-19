<?php

namespace App\Traits;

use App\Helpers\ImageUploadHelper;
use ReflectionClass;

trait HasImage
{

    public function setImageAttribute($value)
    {
        if ($value) {
            $directory = strtolower((new ReflectionClass($this))->getShortName());
            $this->attributes['image'] = ImageUploadHelper::uploadImage($value, $directory);
        }
    }

    public function getImageAttribute($value)
    {
        return $value ? asset($value) : null;
    }
}