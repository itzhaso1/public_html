<?php

namespace App\Models\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use App\Models\ProductVideo;

trait UploadVideoTrait
{
    /**
     * ✅ رفع فيديو وحفظه في قاعدة البيانات
     */
    public function uploadVideo(UploadedFile $video, $folder = 'product/videos', $saveToDatabase = true)
    {
        try {
            // 🔍 تتبع الخطوات
            file_put_contents(public_path('debug_video.txt'), "🚀 بدأ رفع الفيديو\n", FILE_APPEND);

            // تحديد مجلد الوجهة
            $destinationPath = public_path("uploads/{$folder}");

            // إنشاء المجلد إذا لم يكن موجودًا
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
                file_put_contents(public_path('debug_video.txt'), "📁 تم إنشاء المجلد: {$destinationPath}\n", FILE_APPEND);
            }

            // اسم الملف العشوائي + الامتداد
            $extension = strtolower($video->getClientOriginalExtension());
            $allowedExtensions = ['mp4', 'mov', 'avi', 'webm', 'mkv'];
            if (!in_array($extension, $allowedExtensions)) {
                throw new \Exception("صيغة الفيديو غير مدعومة: {$extension}");
            }

            $fileName = uniqid('vid_') . '.' . $extension;
            file_put_contents(public_path('debug_video.txt'), "📄 اسم الملف: {$fileName}\n", FILE_APPEND);

            // نقل الفيديو إلى المسار
            $video->move($destinationPath, $fileName);
            file_put_contents(public_path('debug_video.txt'), "✅ تم رفع الفيديو إلى: {$destinationPath}/{$fileName}\n", FILE_APPEND);

            // مسار الملف النهائي
            $videoPath = "uploads/{$folder}/{$fileName}";

            // حفظ في قاعدة البيانات إذا كان مطلوبًا
            if ($saveToDatabase) {
                file_put_contents(public_path('debug_video.txt'), "💾 حفظ البيانات في قاعدة البيانات...\n", FILE_APPEND);
                return $this->saveVideoToDatabase($videoPath, $video->getClientOriginalName());
            }

            file_put_contents(public_path('debug_video.txt'), "🎯 تم رفع الفيديو فقط بدون حفظ في DB\n", FILE_APPEND);

            return $videoPath;
        } catch (\Exception $e) {
            file_put_contents(public_path('debug_video.txt'), "❌ خطأ أثناء الرفع: " . $e->getMessage() . "\n", FILE_APPEND);
            throw $e;
        }
    }

    /**
     * ✅ حفظ بيانات الفيديو في قاعدة البيانات
     */
    public function saveVideoToDatabase($videoPath, $videoName = null)
    {
        try {
            if (!$this->id) {
                throw new \Exception('❌ المنتج يجب أن يُحفَظ أولًا قبل ربط الفيديو به.');
            }

            $videoRecord = ProductVideo::create([
                'product_id' => $this->id,
                'video_path' => $videoPath,
                'video_name' => $videoName ?? basename($videoPath),
            ]);

            file_put_contents(public_path('debug_video.txt'), "💾 تم حفظ بيانات الفيديو في قاعدة البيانات بنجاح\n", FILE_APPEND);

            return $videoRecord;
        } catch (\Exception $e) {
            file_put_contents(public_path('debug_video.txt'), "❌ خطأ في حفظ الفيديو DB: " . $e->getMessage() . "\n", FILE_APPEND);
            throw $e;
        }
    }

    /**
     * ✅ رفع فيديو بدون حفظ في قاعدة البيانات
     */
    public function uploadVideoOnly(UploadedFile $video, $folder = 'product/videos')
    {
        return $this->uploadVideo($video, $folder, false);
    }
}
