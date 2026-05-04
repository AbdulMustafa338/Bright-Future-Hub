<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerRoadmap extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'role_title',
        'roadmap_data',
    ];

    protected $casts = [
        'roadmap_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
