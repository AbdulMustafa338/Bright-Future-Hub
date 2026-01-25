<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\OrganizationProfile;
use App\Models\StudentProfile;
use App\Models\Opportunity;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@brightfuture.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create Organization Users
        $org1 = User::create([
            'name' => 'Tech University',
            'email' => 'org@techuni.com',
            'password' => Hash::make('password'),
            'role' => 'organization',
            'is_active' => true,
        ]);

        $org2 = User::create([
            'name' => 'Global Scholarships Foundation',
            'email' => 'org@globalscholar.com',
            'password' => Hash::make('password'),
            'role' => 'organization',
            'is_active' => true,
        ]);

        // Create Organization Profiles
        $orgProfile1 = OrganizationProfile::create([
            'user_id' => $org1->id,
            'organization_name' => 'Tech University',
            'description' => 'Leading technology university offering world-class education and research opportunities.',
            'contact_person' => 'Dr. John Smith',
            'status' => 'approved',
        ]);

        $orgProfile2 = OrganizationProfile::create([
            'user_id' => $org2->id,
            'organization_name' => 'Global Scholarships Foundation',
            'description' => 'Non-profit organization providing scholarships to deserving students worldwide.',
            'contact_person' => 'Sarah Johnson',
            'status' => 'approved',
        ]);

        // Create Student Users
        $student1 = User::create([
            'name' => 'Alice Johnson',
            'email' => 'alice@student.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'is_active' => true,
        ]);

        $student2 = User::create([
            'name' => 'Bob Williams',
            'email' => 'bob@student.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'is_active' => true,
        ]);

        // Create Student Profiles
        StudentProfile::create(['user_id' => $student1->id]);
        StudentProfile::create(['user_id' => $student2->id]);

        // Create Opportunities
        Opportunity::create([
            'organization_id' => $orgProfile1->id,
            'title' => 'Summer Internship in Software Development',
            'description' => 'Join our team for a 3-month paid internship working on cutting-edge web applications. You will work alongside experienced developers and gain hands-on experience with modern technologies.',
            'eligibility' => 'Undergraduate students in Computer Science or related fields. Must have knowledge of JavaScript and React.',
            'type' => 'internship',
            'deadline' => now()->addMonths(2),
            'location' => 'San Francisco, CA (Hybrid)',
            'fees' => '$3000/month stipend',
            'application_link' => 'https://techuni.com/apply/internship',
            'status' => 'approved',
        ]);

        Opportunity::create([
            'organization_id' => $orgProfile2->id,
            'title' => 'Merit-Based Scholarship for International Students',
            'description' => 'Full tuition scholarship for outstanding international students pursuing undergraduate degrees. Covers tuition, accommodation, and living expenses for 4 years.',
            'eligibility' => 'High school graduates with GPA 3.8 or higher. Must demonstrate financial need.',
            'type' => 'scholarship',
            'deadline' => now()->addMonths(3),
            'location' => 'Worldwide',
            'fees' => 'Full tuition + $15,000/year living allowance',
            'application_link' => 'https://globalscholar.com/apply',
            'status' => 'approved',
        ]);

        Opportunity::create([
            'organization_id' => $orgProfile1->id,
            'title' => 'Master\'s Program in Artificial Intelligence',
            'description' => 'Two-year Master\'s program focusing on AI, machine learning, and deep learning. Research opportunities with leading faculty members.',
            'eligibility' => 'Bachelor\'s degree in Computer Science, Mathematics, or related field. GRE scores required.',
            'type' => 'admission',
            'deadline' => now()->addMonths(4),
            'location' => 'Boston, MA',
            'fees' => '$45,000/year (scholarships available)',
            'application_link' => 'https://techuni.com/masters/ai',
            'status' => 'approved',
        ]);

        Opportunity::create([
            'organization_id' => $orgProfile1->id,
            'title' => 'Junior Software Engineer Position',
            'description' => 'Full-time position for recent graduates. Work on innovative projects in cloud computing and distributed systems.',
            'eligibility' => 'Bachelor\'s degree in Computer Science. 0-2 years of experience.',
            'type' => 'job',
            'deadline' => now()->addMonth(),
            'location' => 'Remote',
            'fees' => '$75,000 - $95,000/year',
            'application_link' => 'https://techuni.com/careers',
            'status' => 'approved',
        ]);

        // Create a pending opportunity
        Opportunity::create([
            'organization_id' => $orgProfile2->id,
            'title' => 'Research Grant for PhD Students',
            'description' => 'Funding for doctoral research in social sciences and humanities.',
            'eligibility' => 'Enrolled PhD students with approved research proposal.',
            'type' => 'scholarship',
            'deadline' => now()->addMonths(5),
            'location' => 'Worldwide',
            'fees' => '$25,000 research grant',
            'application_link' => 'https://globalscholar.com/research',
            'status' => 'pending',
        ]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin: admin@brightfuture.com / password');
        $this->command->info('Organization: org@techuni.com / password');
        $this->command->info('Student: alice@student.com / password');
    }
}
