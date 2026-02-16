<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;

trait UploadMedia
{
    /**
     * ✅ رفع ميديا (صور أو ملفات) داخل مجلد public/uploads/<ModelName>/
     */
    public function uploadMedia(
        UploadedFile $file,
        string $collection = 'default',
        string $disk = 'public',
        ?int $resizeWidth = null,
        ?int $resizeHeight = null
    ) {
        $modelName = class_basename($this);
        $folderPath = public_path("uploads/{$modelName}");

        // إنشاء المجلد إذا لم يكن موجودًا
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        $fileName = md5(uniqid()) . '.' . $file->getClientOriginalExtension();
        $filePath = "{$folderPath}/{$fileName}";

        // ✅ التعامل مع الصور فقط
        if (in_array(strtolower($file->getClientOriginalExtension()), ['jpg', 'jpeg', 'png', 'webp'])) {
            $image = Image::make($file);

            if ($resizeWidth && $resizeHeight) {
                $image->resize($resizeWidth, $resizeHeight, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            $image->save($filePath, 85);
        } else {
            // ملفات غير الصور
            $file->move($folderPath, $fileName);
        }

        // ✅ إنشاء سجل في قاعدة البيانات (media)
        return $this->media()->create([
            'collection_name' => $collection,
            'file_name'       => $fileName,
            'disk'            => 'public',
        ]);
    }

    /**
     * ✅ حذف آخر ملف من مجموعة ميديا محددة
     */
    public function deleteMedia(string $collection = 'default')
    {
        $media = $this->media()->where('collection_name', $collection)->latest()->first();

        if ($media) {
            $modelName = class_basename($this);
            $filePath = public_path("uploads/{$modelName}/{$media->file_name}");

            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $media->delete();
        }
    }

    /**
     * ✅ تحديث صورة (يحذف القديمة ثم يرفع الجديدة)
     */
    public function updateMedia(
        UploadedFile $file,
        string $collection = 'default',
        string $disk = 'public',
        ?int $resizeWidth = null,
        ?int $resizeHeight = null
    ) {
        $this->deleteMedia($collection);
        return $this->uploadMedia($file, $collection, $disk, $resizeWidth, $resizeHeight);
    }

    /**
     * ✅ جلب رابط الصورة
     */
    public function getMediaUrl(string $collection = 'default'): ?string
    {
        $media = $this->media()->where('collection_name', $collection)->latest()->first();

        if ($media) {
            $modelName = class_basename($this);
            return asset("uploads/{$modelName}/{$media->file_name}");
        }

        return null;
    }
}
