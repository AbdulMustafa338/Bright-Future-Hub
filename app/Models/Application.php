<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Application Model - Represents a student's application to an opportunity
 * 
 * When a student applies to an opportunity, an application record is created.
 * Organizations can then review it and update its status:
 * - pending: Just submitted, waiting for review
 * - viewed: Organization has seen it
 * - shortlisted: Student is being considered
 * - accepted: Student got it!
 * - rejected: Application was declined
 */
class Application extends Model
{
    use HasFactory;

    // Fields that can be filled when creating/updating
    protected $fillable = [
        'user_id',         // Which student applied
        'opportunity_id',  // Which opportunity they applied to
        'status',          // Current status of the application
    ];

    /**
     * Get the student who submitted this application
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the opportunity this application is for
     */
    public function opportunity()
    {
        return $this->belongsTo(Opportunity::class);
    }
}
