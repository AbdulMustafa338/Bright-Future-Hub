<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrganizationProfile;
use App\Models\User;
use App\Models\Opportunity;

class AdditionalPakistanPostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizations = [
            [
                'name' => 'Engro Admin',
                'email' => 'careers@engro.com',
                'password' => bcrypt('password'),
                'role' => 'organization',
                'org_name' => 'Engro Corporation',
                'opportunities' => [
                    [
                        'title' => 'Engro Envision Example',
                        'description' => 'Graduate Trainee Engineer program for Chemical, Mechanical, and Electrical engineers.',
                        'eligibility' => 'Fresh Graduates (BE/BS) with min 3.0 CGPA.',
                        'type' => 'internship',
                        'location' => 'Karachi / Daharki',
                        'fees' => 'Paid: 50k PKR',
                    ],
                    [
                        'title' => 'Supply Chain Analyst',
                        'description' => 'Looking for a supply chain analyst to manage logistics and procurement.',
                        'eligibility' => 'BBA/MBA in Supply Chain.',
                        'type' => 'internship',
                        'location' => 'Karachi',
                        'fees' => 'Paid: 45k PKR',
                    ]
                ]
            ],
            [
                'name' => 'Jazz HR',
                'email' => 'careers@jazz.com.pk',
                'password' => bcrypt('password'),
                'role' => 'organization',
                'org_name' => 'Jazz (PMCL)',
                'opportunities' => [
                    [
                        'title' => 'Jazz Summer Internship',
                        'description' => '6-week project-based internship for university students.',
                        'eligibility' => '3rd/4th year undergraduate students.',
                        'type' => 'internship',
                        'location' => 'Islamabad',
                        'fees' => 'Paid: 20k PKR',
                    ],
                    [
                        'title' => 'Data Science Specialist',
                        'description' => 'Mid-level position for data scientists with experience in Python and ML.',
                        'eligibility' => 'BS CS/Data Science + 2 years experience.',
                        'type' => 'internship', // User asked for posts, usually internships/jobs. Keeping types consistent with existing enum if strict.
                        'location' => 'Islamabad',
                        'fees' => 'Paid: Experience Based',
                    ]
                ]
            ],
            [
                'name' => 'Telenor Careers',
                'email' => 'careers@telenor.com.pk',
                'password' => bcrypt('password'),
                'role' => 'organization',
                'org_name' => 'Telenor Pakistan',
                'opportunities' => [
                    [
                        'title' => 'Telenor Customer Care Representative',
                        'description' => 'Handle customer queries and provide solutions.',
                        'eligibility' => 'Intermediate/Bachelors.',
                        'type' => 'internship', // adjusting to available types
                        'location' => 'Lahore',
                        'fees' => 'Paid: 35k PKR',
                    ],
                    [
                        'title' => 'Digital Marketing Intern',
                        'description' => 'Assist in managing social media campaigns.',
                        'eligibility' => 'BBA Marketing students.',
                        'type' => 'internship',
                        'location' => 'Islamabad',
                        'fees' => 'Paid: 15k PKR',
                    ]
                ]
            ],
            [
                'name' => 'PTCL Admin',
                'email' => 'hr@ptcl.net.pk',
                'password' => bcrypt('password'),
                'role' => 'organization',
                'org_name' => 'PTCL Group',
                'opportunities' => [
                    [
                        'title' => 'PTCL Summit Programme',
                        'description' => 'Management Trainee Officer program for future leaders.',
                        'eligibility' => 'Masters/Bachelors from top universities.',
                        'type' => 'internship',
                        'location' => 'Islamabad (HQ)',
                        'fees' => 'Paid: 60k PKR',
                    ],
                    [
                        'title' => 'Network Engineer Intern',
                        'description' => 'Support network operations and maintenance.',
                        'eligibility' => 'BS Telecom/Electrical Engineering.',
                        'type' => 'internship',
                        'location' => 'Rawalpindi',
                        'fees' => 'Paid: 25k PKR',
                    ]
                ]
            ],
            [
                'name' => 'Descon HR',
                'email' => 'careers@descon.com',
                'password' => bcrypt('password'),
                'role' => 'organization',
                'org_name' => 'Descon Engineering',
                'opportunities' => [
                    [
                        'title' => 'Graduate Trainee Engineer',
                        'description' => 'Civil and Mechanical engineering graduates required for mega projects.',
                        'eligibility' => 'BE Civil/Mechanical.',
                        'type' => 'internship',
                        'location' => 'Lahore / Project Sites',
                        'fees' => 'Paid: 40k PKR',
                    ]
                ]
            ],
            [
                'name' => 'UBL Careers',
                'email' => 'careers@ubl.com.pk',
                'password' => bcrypt('password'),
                'role' => 'organization',
                'org_name' => 'UBL',
                'opportunities' => [
                    [
                        'title' => 'UBL Tech Talent Hunt',
                        'description' => 'Recruiting top tech talent for digital banking division.',
                        'eligibility' => 'BS CS/SE.',
                        'type' => 'internship',
                        'location' => 'Karachi',
                        'fees' => 'Free',
                    ],
                    [
                        'title' => 'Retail Banking Officer',
                        'description' => 'Front office role for branch banking.',
                        'eligibility' => 'Graduates.',
                        'type' => 'internship',
                        'location' => 'Multiple Cities',
                        'fees' => 'Paid: Market Competitive',
                    ]
                ]
            ],
            [
                'name' => 'MCB Admin',
                'email' => 'info@mcb.com.pk',
                'password' => bcrypt('password'),
                'role' => 'organization',
                'org_name' => 'MCB Bank',
                'opportunities' => [
                    [
                        'title' => 'MCB Management Trainee',
                        'description' => 'Comprehensive training program for fresh grads in banking sector.',
                        'eligibility' => 'MBA/BBA.',
                        'type' => 'internship',
                        'location' => 'Lahore',
                        'fees' => 'Paid: 55k PKR',
                    ]
                ]
            ],
            [
                'name' => 'AKUH HR',
                'email' => 'hr@aku.edu',
                'password' => bcrypt('password'),
                'role' => 'organization',
                'org_name' => 'Aga Khan University Hospital',
                'opportunities' => [
                    [
                        'title' => 'Nursing Internship',
                        'description' => 'Clinical practice internship for final year nursing students.',
                        'eligibility' => 'BSc Nursing.',
                        'type' => 'internship',
                        'location' => 'Karachi',
                        'fees' => 'Paid Stipend',
                    ],
                    [
                        'title' => 'Medical Technologist',
                        'description' => 'Lab technologist position.',
                        'eligibility' => 'BS Medical Technology.',
                        'type' => 'internship',
                        'location' => 'Karachi',
                        'fees' => 'Paid',
                    ]
                ]
            ],
            [
                'name' => 'SKMCH Admin',
                'email' => 'careers@skm.org.pk',
                'password' => bcrypt('password'),
                'role' => 'organization',
                'org_name' => 'Shaukat Khanum Hospital',
                'opportunities' => [
                    [
                        'title' => 'Summer Volunteer Program',
                        'description' => 'Community service program for students.',
                        'eligibility' => 'High School / A-Level Students.',
                        'type' => 'internship',
                        'location' => 'Lahore / Peshawar',
                        'fees' => 'Volunteer / Unpaid',
                    ]
                ]
            ],
            [
                'name' => 'TCF HR',
                'email' => 'jobs@tcf.org.pk',
                'password' => bcrypt('password'),
                'role' => 'organization',
                'org_name' => 'The Citizens Foundation',
                'opportunities' => [
                    [
                        'title' => 'TCF Summer Camp Mentor',
                        'description' => 'Teach and mentor students in TCF summer camps.',
                        'eligibility' => 'University Students.',
                        'type' => 'internship',
                        'location' => 'Multiple Cities',
                        'fees' => 'Volunteer',
                    ]
                ]
            ],
            [
                'name' => 'Foodpanda HR',
                'email' => 'careers@foodpanda.pk',
                'password' => bcrypt('password'),
                'role' => 'organization',
                'org_name' => 'Foodpanda Pakistan',
                'opportunities' => [
                    [
                        'title' => 'Business Development Intern',
                        'description' => 'Assist in onboarding new vendors.',
                        'eligibility' => 'Fresh Graduates.',
                        'type' => 'internship',
                        'location' => 'Lahore',
                        'fees' => 'Paid: 25k PKR',
                    ],
                    [
                        'title' => 'Operations Associate',
                        'description' => 'Manage rider fleet operations.',
                        'eligibility' => 'Bachelors degree.',
                        'type' => 'internship',
                        'location' => 'Karachi',
                        'fees' => 'Paid: 40k PKR',
                    ]
                ]
            ],
            [
                'name' => 'K-Electric Admin',
                'email' => 'careers@ke.com.pk',
                'password' => bcrypt('password'),
                'role' => 'organization',
                'org_name' => 'K-Electric',
                'opportunities' => [
                    [
                        'title' => 'Emerging Leaders Program',
                        'description' => 'Trainee program for engineering and management graduates.',
                        'eligibility' => 'BE Electrical / MBA.',
                        'type' => 'internship',
                        'location' => 'Karachi',
                        'fees' => 'Paid: 55k PKR',
                    ]
                ]
            ],
            [
                'name' => 'OGDCL HR',
                'email' => 'recruitment@ogdcl.com',
                'password' => bcrypt('password'),
                'role' => 'organization',
                'org_name' => 'OGDCL',
                'opportunities' => [
                    [
                        'title' => 'Internship Program 2026',
                        'description' => 'One year internship for engineering graduates.',
                        'eligibility' => 'PEC Registered Engineers.',
                        'type' => 'internship',
                        'location' => 'Islamabad / Fields',
                        'fees' => 'Paid: 40k PKR',
                    ]
                ]
            ],
        ];

        foreach ($organizations as $orgData) {
            $user = User::firstOrCreate(
                ['email' => $orgData['email']],
                [
                    'name' => $orgData['name'],
                    'password' => $orgData['password'],
                    'role' => $orgData['role'],
                ]
            );

            // Create Organization Profile if not exists
            $orgProfile = OrganizationProfile::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'organization_name' => $orgData['org_name'],
                    'description' => $orgData['org_name'] . ' is a leading organization in Pakistan.',
                    'contact_person' => $orgData['name'],
                    'status' => 'approved',
                ]
            );

            foreach ($orgData['opportunities'] as $opportunityData) {
                Opportunity::firstOrCreate(
                    [
                        'title' => $opportunityData['title'],
                        'organization_id' => $orgProfile->id
                    ],
                    [
                        'description' => $opportunityData['description'],
                        'eligibility' => $opportunityData['eligibility'],
                        'type' => $opportunityData['type'],
                        'deadline' => now()->addWeeks(rand(4, 12)),
                        'location' => $opportunityData['location'],
                        'fees' => $opportunityData['fees'],
                        'status' => 'approved',
                    ]
                );
            }
        }
    }
}
