<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrganizationProfile;
use App\Models\User;
use App\Models\Opportunity;

class PakistaniOpportunitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define all organizations and their users
        $users = [
            // Existing
            [
                'name' => 'LUMS Admin',
                'email' => 'admin@lums.edu.pk',
                'password' => bcrypt('password'),
                'role' => 'organization',
                'org_name' => 'Lahore University of Management Sciences',
            ],
            [
                'name' => 'NUST Admin',
                'email' => 'admissions@nust.edu.pk',
                'password' => bcrypt('password'),
                'role' => 'organization',
                'org_name' => 'NUST',
            ],
            [
                'name' => 'Systems Ltd HR',
                'email' => 'hr@systemsltd.com',
                'password' => bcrypt('password'),
                'role' => 'organization',
                'org_name' => 'Systems Limited',
            ],
            // NEW ADDITIONS
            [
                'name' => 'FAST Admissions',
                'email' => 'admissions@nu.edu.pk',
                'password' => bcrypt('password'),
                'role' => 'organization',
                'org_name' => 'FAST NUCES',
            ],
            [
                'name' => 'HEC Official',
                'email' => 'info@hec.gov.pk',
                'password' => bcrypt('password'),
                'role' => 'organization',
                'org_name' => 'HEC Pakistan',
            ],
            [
                'name' => 'HBL Careers',
                'email' => 'careers@hbl.com',
                'password' => bcrypt('password'),
                'role' => 'organization',
                'org_name' => 'HBL',
            ],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => $userData['password'],
                    'role' => $userData['role'],
                ]
            );

            // Create Organization Profile if not exists
            $orgProfile = OrganizationProfile::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'organization_name' => $userData['org_name'],
                    'description' => 'Leading institution/company in Pakistan.',
                    'contact_person' => $userData['name'],
                    'status' => 'approved',
                ]
            );

            // Create Opportunities based on Org Name
            // We use firstOrCreate for opportunities to avoid duplicating them if seeder runs twice
            if ($userData['org_name'] === 'Lahore University of Management Sciences') {
                Opportunity::firstOrCreate(
                    ['title' => 'National Outreach Programme (NOP) Scholarship', 'organization_id' => $orgProfile->id],
                    [
                        'description' => 'Fully funded scholarship for talented students from underprivileged backgrounds across Pakistan.',
                        'eligibility' => 'Matric/FSc with 80% marks, financial need.',
                        'type' => 'scholarship',
                        'deadline' => now()->addMonth(),
                        'location' => 'Lahore',
                        'fees' => 'Fully Funded',
                        'application_link' => 'https://nop.lums.edu.pk',
                        'status' => 'approved',
                    ]
                );
            } elseif ($userData['org_name'] === 'NUST') {
                Opportunity::firstOrCreate(
                    ['title' => 'Fall 2026 Undergraduate Admissions', 'organization_id' => $orgProfile->id],
                    [
                        'description' => 'Admissions open for Engineering, CS, and Social Sciences programs.',
                        'eligibility' => 'Minimum 60% in HSSC/A-Levels. NET entry test required.',
                        'type' => 'admission',
                        'deadline' => now()->addWeeks(3),
                        'location' => 'Islamabad',
                        'fees' => 'Processing Fee: 5000 PKR',
                        'application_link' => 'https://ugadmissions.nust.edu.pk',
                        'status' => 'approved',
                    ]
                );
            } elseif ($userData['org_name'] === 'Systems Limited') {
                Opportunity::firstOrCreate(
                    ['title' => 'MTO - Software Engineering', 'organization_id' => $orgProfile->id],
                    [
                        'description' => 'Trainee program for fresh graduates in Java, .NET, and QA.',
                        'eligibility' => 'BSCS/SE, Fresh Graduate to 1 year experience.',
                        'type' => 'internship',
                        'deadline' => now()->addDays(15),
                        'location' => 'Lahore / Karachi',
                        'fees' => 'Paid: 45k - 60k PKR',
                        'application_link' => 'https://systemsltd.com/careers',
                        'status' => 'approved',
                    ]
                );
            }
            // NEW OPPORTUNITIES
            elseif ($userData['org_name'] === 'FAST NUCES') {
                Opportunity::firstOrCreate(
                    ['title' => 'BS Computer Science Admissions', 'organization_id' => $orgProfile->id],
                    [
                        'description' => 'Admissions open for BS(CS), BS(SE), and BS(AI) across all 5 campuses.',
                        'eligibility' => '60% in FSc/A-Levels. NU Admission Test required.',
                        'type' => 'admission',
                        'deadline' => now()->addMonth(2),
                        'location' => 'Lahore, Islamabad, Karachi',
                        'fees' => 'Approx 300k PKR / Semester',
                        'application_link' => 'http://nu.edu.pk/admissions',
                        'status' => 'approved',
                    ]
                );
            } elseif ($userData['org_name'] === 'HEC Pakistan') {
                Opportunity::firstOrCreate(
                    ['title' => 'HEC Indigenous PhD Fellowship', 'organization_id' => $orgProfile->id],
                    [
                        'description' => 'Scholarships for PhD studies in HEC recognized universities.',
                        'eligibility' => 'MS/MPhil with 3.0 CGPA. GAT Subject Test.',
                        'type' => 'scholarship',
                        'deadline' => now()->addWeeks(2),
                        'location' => 'Pakistan (All Cities)',
                        'fees' => 'Fully Funded + Stipend',
                        'application_link' => 'https://hec.gov.pk',
                        'status' => 'approved',
                    ]
                );
            } elseif ($userData['org_name'] === 'HBL') {
                Opportunity::firstOrCreate(
                    ['title' => 'The League - Internship Program', 'organization_id' => $orgProfile->id],
                    [
                        'description' => '6-week summer internship program for undergraduate students.',
                        'eligibility' => '3rd/4th year students with min 3.0 CGPA.',
                        'type' => 'internship',
                        'deadline' => now()->addMonth(3),
                        'location' => 'Karachi (HQ) / Major Cities',
                        'fees' => 'Paid Internship',
                        'application_link' => 'https://hblpeople.com',
                        'status' => 'approved',
                    ]
                );
            }
        }
    }
}
