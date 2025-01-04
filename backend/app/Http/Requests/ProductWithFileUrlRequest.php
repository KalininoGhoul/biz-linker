<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

abstract class ProductWithFileUrlRequest extends FormRequest
{
    public ?string $downloadedImagePath = null;

    protected int $maxFileSize = 7000;

    protected function prepareForValidation(): void
    {
        if (!$this->exists('image_url')) return;

        $image = file_get_contents($this->input('image_url'));
        $imageName = Str::random(40) . hash('sha256', $this->input('name')) . '.' . pathinfo($this->input('image_url'), PATHINFO_EXTENSION);

        Storage::disk('public')->put($imageName, $image);

        $this->downloadedImagePath = $imageName;
    }

    private function saveUploadedImage(): void
    {
        $image = $this->file('image');
        Storage::disk('public')->put('', $image);

        $this->downloadedImagePath = $image->hashName();
    }

    protected function passedValidation(): void
    {
        if ($this->exists('image')) {
            $this->saveUploadedImage();
        }
    }

    protected function failedValidation(Validator $validator): void
    {
        if ($this->downloadedImagePath) Storage::disk('public')->delete($this->downloadedImagePath);
    }
}
