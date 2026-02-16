<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Type extends Model implements TranslatableContract {
    use HasFactory, Translatable;
    protected $table = 'types';
    public $translatedAttributes = ['name'];
    protected $with = ['translations'];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_type');
    }
    public function scopeActive($query){
        return $query->where('status','active');
    }
}
