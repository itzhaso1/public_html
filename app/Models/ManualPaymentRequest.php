<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManualPaymentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'product_id',
        'user_id',
        'player_id',
        'contact_phone',
        'contact_email',
        'amount',
        'currency',
        'receipt_path',
        'status',
        'approved_at',
        'admin_note',
        'ip',
        'user_agent',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

