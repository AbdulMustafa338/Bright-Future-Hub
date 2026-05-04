<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    protected $fillable = [
        'user_id',
        'resume_name',
        'layout_name',
        'resume_data',
    ];

    protected $casts = [
        'resume_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
