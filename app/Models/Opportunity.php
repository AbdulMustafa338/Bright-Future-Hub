<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Opportunity Model - Represents internships, scholarships, and competitions
 * 
 * Organizations create opportunities that students can apply to.
 * Each opportunity goes through an approval process:
 * 1. Organization creates it (status: pending)
 * 2. Admin reviews and approves/rejects it
 * 3. If approved, students can see and apply to it
 */
class Opportunity extends Model
{
    use HasFactory;

    // Fields that can be filled when creating/updating an opportunity
    protected $fillable = [
        'organization_id',  // Which organization posted this
        'title',            // Opportunity title
        'description',      // Full details about the opportunity
        'eligibility',      // Who can apply (requirements)
        'type',             // internship, scholarship, or competition
        'image',            // Opportunity image
        'deadline',         // Last date to apply
        'location',         // Where it's located
        'fees',             // Any fees involved
        'application_link', // External link to apply (if any)
        'status',           // pending, approved, or rejected
    ];

    // Automatically convert deadline to a date object
    protected $casts = [
        'deadline' => 'date',
    ];

    /**
     * Get the organization that posted this opportunity
     * 
     * Every opportunity belongs to one organization.
     */
    public function organization()
    {
        return $this->belongsTo(OrganizationProfile::class, 'organization_id');
    }

    /**
     * Get all applications submitted for this opportunity
     * 
     * Shows all students who have applied.
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Filter to only show approved opportunities
     * 
     * Usage: Opportunity::approved()->get()
     * This is useful for showing opportunities to students.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Filter to only show opportunities that haven't expired
     * 
     * Usage: Opportunity::active()->get()
     * Checks if deadline is still in the future.
     */
    public function scopeActive($query)
    {
        return $query->where('deadline', '>=', Carbon::today());
    }

    /**
     * Filter by opportunity type
     * 
     * Usage: Opportunity::ofType('internship')->get()
     * Types: internship, scholarship, competition
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Check if this opportunity's deadline has passed
     * 
     * Usage: if ($opportunity->isExpired()) { ... }
     */
    public function isExpired()
    {
        return $this->deadline < Carbon::today();
    }

    /**
     * Check if this opportunity has been approved by admin
     * 
     * Usage: if ($opportunity->isApproved()) { ... }
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }
}
