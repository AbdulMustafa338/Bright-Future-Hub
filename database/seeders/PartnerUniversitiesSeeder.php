<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\OrganizationProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PartnerUniversitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $universities = [
            [
                'name' => 'NUST',
                'full_name' => 'National University of Sciences & Technology',
                'logo' => 'uploads/logos/nust.png',
                'email' => 'admissions@nust.edu.pk'
            ],
            [
                'name' => 'LUMS',
                'full_name' => 'Lahore University of Management Sciences',
                'logo' => 'uploads/logos/lums.png',
                'email' => 'admissions@lums.edu.pk'
            ],
            [
                'name' => 'Punjab University',
                'full_name' => 'University of the Punjab',
                'logo' => 'uploads/logos/pu.png',
                'email' => 'info@pu.edu.pk'
            ],
            [
                'name' => 'UET Lahore',
                'full_name' => 'University of Engineering and Technology',
                'logo' => 'uploads/logos/uet.png',
                'email' => 'registrar@uet.edu.pk'
            ],
            [
                'name' => 'COMSATS',
                'full_name' => 'COMSATS University Islamabad',
                'logo' => 'uploads/logos/comsats.png',
                'email' => 'admissions@comsats.edu.pk'
            ]
        ];

        foreach ($universities as $uni) {
            // Check if user exists (by email) or create
            $user = User::firstOrCreate(
                ['email' => $uni['email']],
                [
                    'name' => $uni['name'],
                    'password' => Hash::make('password'),
                    'role' => 'organization',
                    'email_verified_at' => now(),
                ]
            );

            // Create or update profile
            OrganizationProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'organization_name' => $uni['full_name'],
                    'logo' => $uni['logo'],
                    'status' => 'approved',
                    'description' => 'One of the top ranking universities in Pakistan offering various programs.'
                ]
            );
        }
    }
}
