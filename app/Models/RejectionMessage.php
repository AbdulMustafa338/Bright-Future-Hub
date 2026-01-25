<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RejectionMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'opportunity_id',
        'message',
    ];

    /**
     * Get the opportunity that owns the rejection message.
     */
    public function opportunity()
    {
        return $this->belongsTo(Opportunity::class);
    }
}
