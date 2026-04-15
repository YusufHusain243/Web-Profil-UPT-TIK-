<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarouselSlide extends Model
{
    protected $fillable = [
        'order',
        'badge',
        'heading',
        'description',
        'cta1_text',
        'cta2_text',
        'image_path',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function scopeActive($query): void
    {
        $query->where('is_active', true)->orderBy('order');
    }
}
