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
        // Admin Accounts
        User::updateOrCreate(
            ['email' => 'admin@education.com'],
            [
                'name' => 'إدارة المنصة',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '07701234567',
                'is_approved' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@xpro.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '07701234568',
                'is_approved' => true,
            ]
        );

        // Teacher Accounts
        User::updateOrCreate(
            ['email' => 'teacher@education.com'],
            [
                'name' => 'الأستاذ أحمد العراقي',
                'password' => Hash::make('password'),
                'role' => 'teacher',
                'phone' => '07702345678',
                'is_approved' => true,
                'commission_percentage' => 20.00,
            ]
        );

        User::updateOrCreate(
            ['email' => 'teacher@xpro.com'],
            [
                'name' => 'المعلم النموذجي',
                'password' => Hash::make('password'),
                'role' => 'teacher',
                'phone' => '07702345679',
                'is_approved' => true,
                'commission_percentage' => 20.00,
            ]
        );

        // Student Accounts
        User::updateOrCreate(
            ['email' => 'student@education.com'],
            [
                'name' => 'الطالب المتميز',
                'password' => Hash::make('password'),
                'role' => 'student',
                'phone' => '07703456789',
                'is_approved' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'student@xpro.com'],
            [
                'name' => 'الطالب التجريبي',
                'password' => Hash::make('password'),
                'role' => 'student',
                'phone' => '07703456790',
                'is_approved' => true,
            ]
        );
    }
}
