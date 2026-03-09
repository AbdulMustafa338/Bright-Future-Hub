<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\StudentProfile;

class SampleStudentSeeder extends Seeder
{
    public function run()
    {
        $students = [
            ['name' => 'Ahmed Ali', 'email' => 'ahmed.ali@example.pk', 'field' => 'Computer Science', 'level' => 'Bachelors', 'interests' => 'AI, Web Development'],
            ['name' => 'Fatima Shah', 'email' => 'fatima.shah@example.pk', 'field' => 'Medicine', 'level' => 'Bachelors', 'interests' => 'Surgery, Research'],
            ['name' => 'Muhammad Hamza', 'email' => 'hamza.pk@example.pk', 'field' => 'Electrical Engineering', 'level' => 'Masters', 'interests' => 'Robotics, Power Systems'],
            ['name' => 'Zainab Khan', 'email' => 'zainab.k@example.pk', 'field' => 'Business Administration', 'level' => 'Bachelors', 'interests' => 'Finance, Startups'],
            ['name' => 'Bilal Ahmed', 'email' => 'bilal.a@example.pk', 'field' => 'Data Science', 'level' => 'Bachelors', 'interests' => 'Machine Learning, Big Data'],
            ['name' => 'Sana Malik', 'email' => 'sana.malik@example.pk', 'field' => 'Architecture', 'level' => 'Bachelors', 'interests' => 'Interior Design, Urban Planning'],
            ['name' => 'Zaid Sheikh', 'email' => 'zaid.s@example.pk', 'field' => 'Mechanical Engineering', 'level' => 'Bachelors', 'interests' => 'Automotive, Manufacturing'],
            ['name' => 'Ayesha Siddiqui', 'email' => 'ayesha.s@example.pk', 'field' => 'Software Engineering', 'level' => 'Masters', 'interests' => 'Cybersecurity, Cloud Computing'],
            ['name' => 'Usman Farooq', 'email' => 'usman.f@example.pk', 'field' => 'Marketing', 'level' => 'Bachelors', 'interests' => 'Digital Marketing, SEO'],
            ['name' => 'Maryam Javed', 'email' => 'maryam.j@example.pk', 'field' => 'Civil Engineering', 'level' => 'Bachelors', 'interests' => 'Bridge Construction, Hydrology'],
        ];

        foreach ($students as $s) {
            $user = User::updateOrCreate(
                ['email' => $s['email']],
                [
                    'name' => $s['name'],
                    'password' => \Hash::make('password'),
                    'role' => 'student',
                    'field_of_study' => $s['field'],
                    'education_level' => $s['level'],
                    'interests' => $s['interests'],
                    'is_active' => true
                ]
            );
            
            $user->created_at = now()->subDays(rand(1, 28));
            $user->save();

            \App\Models\StudentProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'field_of_study' => $s['field'],
                    'education_level' => $s['level'],
                    'interests' => $s['interests']
                ]
            );
        }
    }
}
