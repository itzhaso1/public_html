<?php

namespace App\Http\Controllers\Website\Customer;

use App\Http\Controllers\Controller;
use App\Models\DiamondCode;
use Illuminate\Support\Facades\Storage;

class DiamondCodeController extends Controller
{
    public function image(DiamondCode $diamondCode)
    {
        abort_if($diamondCode->user_id !== auth()->id(), 403);
        abort_if(! $diamondCode->image_path, 404);
        abort_if(! Storage::disk('public')->exists($diamondCode->image_path), 404);

        return Storage::disk('public')->response($diamondCode->image_path);
    }
}

