<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\OrganizationProfile;
use App\Models\StudentProfile;
use App\Models\Opportunity;
use App\Models\Application;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with robust FYP presentation data.
     */
    public function run(): void
    {
        // Common Password for all accounts for easy testing
        $commonPassword = Hash::make('12345678');

        // ==========================================
        // 1. Create Admin User
        // ==========================================
        $admin = User::create([
            'name' => 'System Admin',
            'email' => 'admin@brightfuture.com',
            'password' => $commonPassword,
            'role' => 'admin',
            'is_active' => true,
        ]);

        // ==========================================
        // 2. Create Organizations (6 Different Types)
        // ==========================================
        
        // Org 1: LUMS University
        $org1 = User::create(['name' => 'LUMS University', 'email' => 'org1@lums.edu.pk', 'password' => $commonPassword, 'role' => 'organization', 'is_active' => true]);
        $orgProfile1 = OrganizationProfile::create([
            'user_id' => $org1->id, 'organization_name' => 'LUMS University', 'description' => 'A world-class academic institution.', 'contact_person' => 'Dr. Arshad', 'location' => 'Lahore, Pakistan', 'status' => 'approved'
        ]);

        // Org 2: Systems Limited
        $org2 = User::create(['name' => 'Systems Limited', 'email' => 'org2@systemsltd.com', 'password' => $commonPassword, 'role' => 'organization', 'is_active' => true]);
        $orgProfile2 = OrganizationProfile::create([
            'user_id' => $org2->id, 'organization_name' => 'Systems Limited', 'description' => 'Global technology powerhouse providing innovative IT solutions.', 'contact_person' => 'Asif Peer', 'location' => 'Karachi, Pakistan', 'status' => 'approved'
        ]);

        // Org 3: HEC Pakistan
        $org3 = User::create(['name' => 'HEC Pakistan', 'email' => 'org3@hec.gov.pk', 'password' => $commonPassword, 'role' => 'organization', 'is_active' => true]);
        $orgProfile3 = OrganizationProfile::create([
            'user_id' => $org3->id, 'organization_name' => 'Higher Education Commission', 'description' => 'Facilitating institutions of higher learning in Pakistan.', 'contact_person' => 'Dr. Mukhtar Ahmed', 'location' => 'Islamabad, Pakistan', 'status' => 'approved'
        ]);

        // Org 4: NUST University
        $org4 = User::create(['name' => 'NUST University', 'email' => 'org4@nust.edu.pk', 'password' => $commonPassword, 'role' => 'organization', 'is_active' => true]);
        $orgProfile4 = OrganizationProfile::create([
            'user_id' => $org4->id, 'organization_name' => 'National University of Sciences & Technology', 'description' => 'A premium research-led university with a focus on STEM fields.', 'contact_person' => 'Rector NUST', 'location' => 'Islamabad, Pakistan', 'status' => 'approved'
        ]);

        // Org 5: Google Developers
        $org5 = User::create(['name' => 'Google Developers', 'email' => 'org5@google.com', 'password' => $commonPassword, 'role' => 'organization', 'is_active' => true]);
        $orgProfile5 = OrganizationProfile::create([
            'user_id' => $org5->id, 'organization_name' => 'Google Developer Groups (GDG)', 'description' => 'Empowering developers worldwide to build amazing software.', 'contact_person' => 'Sundar Pichai', 'location' => 'Remote / Global', 'status' => 'approved'
        ]);

        // Org 6: State Bank of Pakistan
        $org6 = User::create(['name' => 'State Bank of Pakistan', 'email' => 'org6@sbp.org.pk', 'password' => $commonPassword, 'role' => 'organization', 'is_active' => true]);
        $orgProfile6 = OrganizationProfile::create([
            'user_id' => $org6->id, 'organization_name' => 'State Bank of Pakistan', 'description' => 'The central bank of Pakistan regulating the monetary and credit system.', 'contact_person' => 'Jameel Ahmad', 'location' => 'Karachi, Pakistan', 'status' => 'approved'
        ]);


        // ==========================================
        // 3. Create Students
        // ==========================================
        $students = [];
        $studentData = [
            ['name' => 'Ali Khan', 'email' => 'student1@example.com', 'field' => 'Computer Science'],
            ['name' => 'Sara Ahmed', 'email' => 'student2@example.com', 'field' => 'Business Administration'],
            ['name' => 'Usman Tariq', 'email' => 'student3@example.com', 'field' => 'Software Engineering'],
            ['name' => 'Fatima Noor', 'email' => 'student4@example.com', 'field' => 'Data Science'],
            ['name' => 'Zain Malik', 'email' => 'student5@example.com', 'field' => 'Artificial Intelligence'],
        ];

        foreach ($studentData as $data) {
            $user = User::create([
                'name' => $data['name'], 'email' => $data['email'], 'password' => $commonPassword, 'role' => 'student', 'is_active' => true, 'field_of_study' => $data['field'],
            ]);
            
            StudentProfile::create([
                'user_id' => $user->id, 'field_of_study' => $data['field'], 'skills' => json_encode(['Python', 'JavaScript', 'Communication', 'Problem Solving']), 'location' => 'Pakistan', 'age' => rand(19, 25),
            ]);
            $students[] = $user;
        }

        // ==========================================
        // 4. Create Opportunities (Internships, Scholarships, Admissions)
        // ==========================================
        $opportunities = [
            // LUMS
            ['org_id' => $orgProfile1->id, 'type' => 'admission', 'title' => 'BS Computer Science Fall Admission', 'description' => 'Join the top-ranked CS program in Pakistan. Excellent faculty and labs.', 'eligibility' => 'FSc/ICS with minimum 70%.', 'location' => 'Lahore', 'fees' => 'PKR 450,000/sem'],
            ['org_id' => $orgProfile1->id, 'type' => 'scholarship', 'title' => 'National Outreach Programme (NOP)', 'description' => 'Fully funded scholarship for bright students from underprivileged backgrounds.', 'eligibility' => 'Minimum 80% in Matric/O-Levels.', 'location' => 'Lahore', 'fees' => 'Fully Funded'],
            ['org_id' => $orgProfile1->id, 'type' => 'internship', 'title' => 'Research Assistant - AI Lab', 'description' => 'Summer internship working on NLP models.', 'eligibility' => 'Junior/Senior standing in CS.', 'location' => 'Lahore', 'fees' => 'PKR 35,000/m'],

            // Systems Ltd
            ['org_id' => $orgProfile2->id, 'type' => 'internship', 'title' => 'Software Engineering Summer Internship', 'description' => 'Learn full-stack development using React and .NET Core.', 'eligibility' => 'Undergrad in tech field.', 'location' => 'Karachi', 'fees' => 'Paid'],
            ['org_id' => $orgProfile2->id, 'type' => 'internship', 'title' => 'UI/UX Design Intern', 'description' => 'Help shape the user experience for our enterprise clients.', 'eligibility' => 'Figma proficiency.', 'location' => 'Remote', 'fees' => 'PKR 30,000/m'],

            // HEC
            ['org_id' => $orgProfile3->id, 'type' => 'scholarship', 'title' => 'HEC Need Based Scholarship', 'description' => 'Financial assistance for university students.', 'eligibility' => 'Enrolled in a public sector university.', 'location' => 'All Pakistan', 'fees' => 'Tuition + Stipend'],
            ['org_id' => $orgProfile3->id, 'type' => 'scholarship', 'title' => 'Fulbright Scholarship (HEC)', 'description' => 'Fully funded Master\'s and PhD program in the US.', 'eligibility' => 'Strong academic record.', 'location' => 'United States', 'fees' => 'Fully Funded'],

            // NUST
            ['org_id' => $orgProfile4->id, 'type' => 'admission', 'title' => 'NUST Entry Test (NET) 2026', 'description' => 'Registration for engineering, computing and business programs.', 'eligibility' => 'FSc Pre-Eng/ICS.', 'location' => 'Islamabad', 'fees' => 'PKR 3,500'],
            ['org_id' => $orgProfile4->id, 'type' => 'scholarship', 'title' => 'NUST Merit Scholarship', 'description' => 'Awarded to top 10% students based on NET score.', 'eligibility' => 'Top position holders in NET.', 'location' => 'Islamabad', 'fees' => 'Full Tuition Waiver'],

            // Google Developers
            ['org_id' => $orgProfile5->id, 'type' => 'internship', 'title' => 'Google STEP Internship', 'description' => 'Student Training in Engineering Program (STEP) for first and second-year undergraduates.', 'eligibility' => '1st or 2nd year CS student.', 'location' => 'Remote / Global', 'fees' => 'Highly Paid'],
            ['org_id' => $orgProfile5->id, 'type' => 'internship', 'title' => 'Google Cloud Associate Trainee', 'description' => 'Learn cloud infrastructure and earn certifications.', 'eligibility' => 'Basic knowledge of cloud computing.', 'location' => 'Remote', 'fees' => 'Paid + Free Certifications'],

            // State Bank of Pakistan
            ['org_id' => $orgProfile6->id, 'type' => 'internship', 'title' => 'SBP Summer Internship Program', 'description' => 'Gain experience in banking, finance, and financial technology (FinTech).', 'eligibility' => 'Students of Economics, Finance, or IT.', 'location' => 'Karachi', 'fees' => 'PKR 25,000/m'],
            ['org_id' => $orgProfile6->id, 'type' => 'scholarship', 'title' => 'SBP Merit Scholarship for Dependents', 'description' => 'Scholarship for brilliant students in high-demand fields.', 'eligibility' => 'Min 80% marks.', 'location' => 'Karachi', 'fees' => 'Tuition + Books']
        ];

        $createdOpps = [];
        foreach ($opportunities as $index => $opp) {
            $createdOpps[] = Opportunity::create([
                'organization_id' => $opp['org_id'], 'title' => $opp['title'], 'description' => $opp['description'], 'eligibility' => $opp['eligibility'], 'type' => $opp['type'], 'deadline' => Carbon::now()->addDays(rand(10, 60)), 'location' => $opp['location'], 'fees' => $opp['fees'], 'status' => 'approved', 'created_at' => Carbon::now()->subDays(rand(1, 15)),
            ]);
        }

        // ==========================================
        // 5. Generate Random Applications
        // ==========================================
        $statuses = ['applied', 'viewed', 'shortlisted', 'rejected', 'accepted'];
        
        foreach ($students as $student) {
            $numberOfApps = rand(3, 6);
            $randomOpps = collect($createdOpps)->random($numberOfApps);

            foreach ($randomOpps as $opp) {
                Application::create([
                    'user_id' => $student->id, 'opportunity_id' => $opp->id, 'status' => $statuses[array_rand($statuses)], 'created_at' => Carbon::now()->subDays(rand(1, 10)),
                ]);
            }
        }
    }
}
