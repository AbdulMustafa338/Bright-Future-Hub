<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrganizationProfile;
use App\Models\User;
use App\Models\Opportunity;
use Carbon\Carbon;

class AdmissionsScholarshipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define organizations to ensure they exist
        $organizations = [
            [
                'name' => 'NUST Administration',
                'email' => 'admissions@nust.edu.pk',
                'org_name' => 'National University of Sciences & Technology (NUST)',
                'description' => 'A premier engineering and technology university in Pakistan.',
                'contact' => '051-90851001'
            ],
            [
                'name' => 'HEC Pakistan',
                'email' => 'info@hec.gov.pk',
                'org_name' => 'Higher Education Commission (HEC)',
                'description' => 'The primary regulator of higher education in Pakistan.',
                'contact' => '051-111-119-432'
            ],
            [
                'name' => 'LUMS Admissions',
                'email' => 'admissions@lums.edu.pk',
                'org_name' => 'Lahore University of Management Sciences (LUMS)',
                'description' => 'A world-class academic institution with a proud history of achievement.',
                'contact' => '042-35608000'
            ],
            [
                'name' => 'FAST NUCES',
                'email' => 'admissions@nu.edu.pk',
                'org_name' => 'FAST National University',
                'description' => 'A leading university in computer science and engineering.',
                'contact' => '051-111-128-128'
            ],
            [
                'name' => 'The Citizens Foundation',
                'email' => 'info@tcf.org.pk',
                'org_name' => 'The Citizens Foundation (TCF)',
                'description' => 'One of Pakistan\'s leading non-profit organizations in the field of education.',
                'contact' => '0800-00823'
            ],
            [
                'name' => 'British Council Pakistan',
                'email' => 'info@britishcouncil.org.pk',
                'org_name' => 'British Council',
                'description' => 'The UK’s international organisation for cultural relations and educational opportunities.',
                'contact' => '0800-22000'
            ]
        ];

        $orgProfiles = [];
        foreach ($organizations as $orgData) {
            // Create user if not exists
            $user = User::firstOrCreate(
                ['email' => $orgData['email']],
                [
                    'name' => $orgData['name'],
                    'password' => bcrypt('password'), // password
                    'role' => 'organization',
                    'email_verified_at' => now(),
                ]
            );

            // Create Organization Profile
            $orgProfile = OrganizationProfile::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'organization_name' => $orgData['org_name'],
                    'description' => $orgData['description'],
                    'contact_person' => $orgData['name'],
                    'status' => 'approved'
                ]
            );

            $orgProfiles[$orgData['name']] = $orgProfile;
        }

        $nust = $orgProfiles['NUST Administration'];
        $hec = $orgProfiles['HEC Pakistan'];
        $lums = $orgProfiles['LUMS Admissions'];
        $fast = $orgProfiles['FAST NUCES'];
        $tcf = $orgProfiles['The Citizens Foundation'];
        $bc = $orgProfiles['British Council Pakistan'];

        $opportunities = [
            // Admissions
            [
                'organization_id' => $nust->id,
                'title' => 'NUST Undergraduate Admission Fall 2026',
                'description' => 'Applications are invited for undergraduate programs in Engineering, Computer Science, and Business Administration at NUST Islamabad and other campuses. NET-1, NET-2, and NET-3 series are now open.',
                'type' => 'admission',
                'location' => 'Islamabad, Pakistan',
                'deadline' => Carbon::now()->addMonths(2),
                'eligibility' => 'Minimum 60% marks in FSc/A-Levels. Valid NET score required.',
                'fees' => 'Refer to NUST website',
                'application_link' => 'https://ugadmissions.nust.edu.pk',
                'status' => 'approved'
            ],
            [
                'organization_id' => $fast->id,
                'title' => 'FAST-NUCES Admission 2026',
                'description' => 'Admissions are open for BS in Computer Science, Artificial Intelligence, Data Science, and Software Engineering at FAST-NUCES (All Campuses).',
                'type' => 'admission',
                'location' => 'Lahore, Islamabad, Karachi, Peshawar, Chiniot',
                'deadline' => Carbon::now()->addMonths(3),
                'eligibility' => 'Minimum 50% marks in matric and 50% in Inter. Entry Test is mandatory.',
                'fees' => 'Approx. 200,000 PKR per semester',
                'application_link' => 'http://nu.edu.pk/Admissions/Schedule',
                'status' => 'approved'
            ],
            [
                'organization_id' => $lums->id,
                'title' => 'LUMS MS Programme Admission',
                'description' => 'Admission open for MS in Computer Science, Electrical Engineering, and Mathematics. Full and partial scholarships available for meritorious students.',
                'type' => 'admission',
                'location' => 'Lahore, Pakistan',
                'deadline' => Carbon::now()->addMonths(1)->addDays(15),
                'eligibility' => '16 years of education with 2.5 CGPA. LGAT/GRE required.',
                'fees' => 'Varies by program',
                'application_link' => 'https://admission.lums.edu.pk',
                'status' => 'approved'
            ],
            [
                'organization_id' => $nust->id,
                'title' => 'NUST MS/PhD Admission Spring 2026',
                'description' => 'Join NUST for postgraduate studies in cutting-edge research fields. Funding opportunities available for PhD scholars.',
                'type' => 'admission',
                'location' => 'Islamabad, Pakistan',
                'deadline' => Carbon::now()->addMonths(1),
                'eligibility' => '16/18 years of education. GAT General/Subject required.',
                'fees' => 'See website',
                'application_link' => 'https://pgadmission.nust.edu.pk',
                'status' => 'approved'
            ],

            // Scholarships
            [
                'organization_id' => $hec->id,
                'title' => 'HEC Need-Based Scholarship 2026',
                'description' => 'Financial assistance for deserving students studying in HEC recognized public sector universities. Check your university financial aid office for details.',
                'type' => 'scholarship',
                'location' => 'Pakistan (All Public Universities)',
                'deadline' => Carbon::now()->addMonths(4),
                'eligibility' => 'Enrolled in undergraduate program, financial need demonstration.',
                'fees' => 'Full Tuition + Stipend',
                'application_link' => 'https://hec.gov.pk/scholarships',
                'status' => 'approved'
            ],
            [
                'organization_id' => $lums->id,
                'title' => 'LUMS National Outreach Programme (NOP)',
                'description' => '100% scholarship for talented students from underprivileged backgrounds across Pakistan. Includes tuition, boarding, and living allowance.',
                'type' => 'scholarship',
                'location' => 'Lahore, Pakistan',
                'deadline' => Carbon::now()->addMonths(2),
                'eligibility' => 'Matric/O-Level students with 80% marks and financial need.',
                'fees' => 'Fully Funded',
                'application_link' => 'https://nop.lums.edu.pk',
                'status' => 'approved'
            ],
            [
                'organization_id' => $bc->id,
                'title' => 'British Council Women in STEM Scholarship',
                'description' => 'Scholarships for women with a background in STEM to pursue a master\'s degree in the UK.',
                'type' => 'scholarship',
                'location' => 'United Kingdom',
                'deadline' => Carbon::now()->addMonths(3),
                'eligibility' => 'Female, Pakistani citizen, undergraduate degree in STEM.',
                'fees' => 'Fully Funded',
                'application_link' => 'https://www.britishcouncil.pk/study-uk/scholarships',
                'status' => 'approved'
            ],
            [
                'organization_id' => $hec->id,
                'title' => 'Ehsaas Undergraduate Scholarship Phase III',
                'description' => 'Largest undergraduate scholarship program in Pakistan for students from low-income families.',
                'type' => 'scholarship',
                'location' => 'Pakistan',
                'deadline' => Carbon::now()->addMonths(5),
                'eligibility' => 'Family income less than 45,000 PKR/month.',
                'fees' => 'Tuition + Stipend',
                'application_link' => 'https://ehsaas.hec.gov.pk',
                'status' => 'approved'
            ],
            [
                'organization_id' => $tcf->id,
                'title' => 'TCF Alumni Scholarship',
                'description' => 'Scholarship support for TCF alumni getting admission in top-tier universities.',
                'type' => 'scholarship',
                'location' => 'Karachi/Lahore',
                'deadline' => Carbon::now()->addMonths(1),
                'eligibility' => 'TCF Alumni with admission offer.',
                'fees' => 'Partial/Full Support',
                'application_link' => 'https://tcf.org.pk',
                'status' => 'approved'
            ],
            [
                'organization_id' => $hec->id,
                'title' => 'Commonwealth General Scholarship',
                'description' => 'For Masters and PhD studies in the UK. Managed by HEC in Pakistan.',
                'type' => 'scholarship',
                'location' => 'United Kingdom',
                'deadline' => Carbon::now()->addMonths(6),
                'eligibility' => 'Pakistani citizen, valid HAT test score.',
                'fees' => 'Fully Funded',
                'application_link' => 'https://hec.gov.pk',
                'status' => 'approved'
            ]
        ];

        foreach ($opportunities as $opp) {
            Opportunity::create($opp);
        }
    }
}
