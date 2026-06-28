<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Primary Admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@xpro.com'],
            [
                'name' => 'Admin User',
                'password' => \Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Additional Admins
        // (Removed factory calls to avoid Faker dependency in production)


        // Stages
        $stages = [
            ['name' => 'المرحلة الابتدائية', 'description' => 'تأسيس قوي لمستقبل مشرق'],
            ['name' => 'المرحلة الإعدادية', 'description' => 'تمكين مهارات التفكير والتحليل'],
            ['name' => 'المرحلة الثانوية', 'description' => 'طريقك نحو القمة والجامعة'],
            ['name' => 'التعليم الجامعي', 'description' => 'تخصص أكاديمي معمق'],
            ['name' => 'سوق العمل', 'description' => 'مهارات احترافية للنجاح الوظيفي'],
        ];

        foreach ($stages as $stageData) {
            $stage = \App\Models\Stage::updateOrCreate(['name' => $stageData['name']], $stageData);
            
            if ($stage->name === 'المرحلة الابتدائية') {
                $grades = ['الصف الأول', 'الصف الثاني', 'الصف الثالث', 'الصف الرابع', 'الصف الخامس', 'الصف السادس'];
                foreach ($grades as $gradeName) {
                    $grade = $stage->grades()->updateOrCreate(['name' => $gradeName]);
                    
                    $subjects = ['اللغة العربية', 'اللغة الإنجليزية', 'الرياضيات'];
                    foreach ($subjects as $subjectName) {
                        $subject = $grade->subjects()->updateOrCreate(['name' => $subjectName]);
                        
                        // Create a dummy course for the first teacher for one subject
                        if ($subjectName === 'اللغة العربية' && $gradeName === 'الصف الأول') {
                            $course = \App\Models\Course::updateOrCreate(
                                ['title' => 'دورة اللغة العربية التأسيسية'],
                                [
                                    'teacher_id' => $admin->id, // The admin user we created
                                    'subject_id' => $subject->id,
                                    'description' => 'شرح كامل ومبسط لقواعد اللغة العربية لطلاب الصف الأول الابتدائي.',
                                    'price' => 150.00,
                                    'duration' => 'فصل دراسي',
                                ]
                            );
                            
                            $course->lessons()->updateOrCreate(['title' => 'الدرس الأول: الحروف الهجائية'], [
                                'description' => 'مقدمة في الحروف الهجائية ونطقها الصحيح.',
                                'video_url' => 'https://example.com/video1',
                                'is_free' => true,
                                'order' => 1
                            ]);

                            $course->lessons()->updateOrCreate(['title' => 'الدرس الثاني: الحركات القصيرة'], [
                                'description' => 'شرح الفتحة والضمة والكسرة.',
                                'video_url' => 'https://example.com/video2',
                                'order' => 2
                            ]);
                        }
                    }

                }
            }
        }

    }

}
