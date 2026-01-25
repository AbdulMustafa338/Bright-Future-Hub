<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * User Model - Represents all users in the system
 * 
 * This model handles three types of users:
 * - Students: Can browse and apply to opportunities
 * - Organizations: Can post opportunities and review applications
 * - Admins: Can approve/reject opportunities and manage users
 * 
 * Each user has a role field that determines their permissions.
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Fields that can be filled when creating/updating a user
     * 
     * These are the user's basic information:
     * - name, email, password: Standard login credentials
     * - role: student, organization, or admin
     * - is_active: Whether the account is enabled
     * - field_of_study, education_level, interests: Student-specific info
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'field_of_study',
        'education_level',
        'interests',
    ];

    /**
     * Fields that should be hidden in API responses
     * 
     * Password and remember_token are sensitive and should never
     * be exposed when returning user data.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Automatic type conversions for certain fields
     * 
     * - email_verified_at: Converts to Carbon date object
     * - password: Automatically hashed when saved
     * - is_active: Converts to true/false boolean
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    /**
     * Get the student's profile (if user is a student)
     * 
     * Students have an additional profile with extra information.
     * Returns null if user is not a student.
     */
    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class);
    }

    /**
     * Get the organization's profile (if user is an organization)
     * 
     * Organizations have a profile with company details.
     * Returns null if user is not an organization.
     */
    public function organizationProfile()
    {
        return $this->hasOne(OrganizationProfile::class);
    }

    /**
     * Get all applications submitted by this user
     * 
     * Only relevant for students - returns all opportunities
     * they've applied to.
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Quick check if this user is an admin
     * 
     * Usage: if ($user->isAdmin()) { ... }
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Quick check if this user is an organization
     * 
     * Usage: if ($user->isOrganization()) { ... }
     */
    public function isOrganization()
    {
        return $this->role === 'organization';
    }

    /**
     * Quick check if this user is a student
     * 
     * Usage: if ($user->isStudent()) { ... }
     */
    public function isStudent()
    {
        return $this->role === 'student';
    }
}
