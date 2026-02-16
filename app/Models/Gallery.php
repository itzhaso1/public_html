<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    protected $fillable = [
        'file_name',
        'disk',
        'collection_name',
        'mime_type',
        'size',
    ];

    public function galleriable()
    {
        return $this->morphTo();
    }

    // دالة ترجّع رابط الصورة
    public function getUrlAttribute()
    {
        return asset("uploads/product/gallery/{$this->file_name}");
    }
}
