<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'organization_name',
        'description',
        'contact_person',
        'status',
    ];

    /**
     * Get the user that owns the organization profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the opportunities for the organization.
     */
    public function opportunities()
    {
        return $this->hasMany(Opportunity::class, 'organization_id');
    }

    /**
     * Check if organization is approved.
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }
}
