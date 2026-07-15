<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin Account
        User::updateOrCreate(
            ['email' => 'admin@xpro.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '01112345678',
                'is_approved' => true,
            ]
        );

        // Teacher Account
        User::updateOrCreate(
            ['email' => 'teacher@xpro.com'],
            [
                'name' => 'المعلم النموذجي',
                'password' => Hash::make('password'),
                'role' => 'teacher',
                'phone' => '01012345678',
                'is_approved' => true,
                'commission_percentage' => 20.00,
            ]
        );

        // Student Account
        User::updateOrCreate(
            ['email' => 'student@xpro.com'],
            [
                'name' => 'الطالب التجريبي',
                'password' => Hash::make('password'),
                'role' => 'student',
                'phone' => '01212345678',
                'is_approved' => true,
            ]
        );
    }
}
