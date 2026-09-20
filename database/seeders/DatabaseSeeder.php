<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Stage;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\SubscriptionCode;
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
        $this->call([
            UserSeeder::class,
            SpecializationSeeder::class,
        ]);

        $admin = User::where('role', 'admin')->first();
        $teacher = User::where('role', 'teacher')->first() ?? $admin;

        // 1. المرحلة المتوسطة (الصف الثالث فقط: رياضيات، فيزياء، كيمياء، إنكليزي)
        $middleStage = Stage::updateOrCreate(
            ['name' => 'المرحلة المتوسطة'],
            [
                'description' => 'بناء الأسس العلمية والمهارات المتقدمة',
                'image' => '/images/stages/1772939164.png',
            ]
        );

        $grade3Middle = $middleStage->grades()->updateOrCreate(['name' => 'الصف الثالث المتوسط']);
        $middleSubjects = ['رياضيات', 'فيزياء', 'كيمياء', 'إنكليزي'];

        foreach ($middleSubjects as $subjectName) {
            $subject = $grade3Middle->subjects()->updateOrCreate(['name' => $subjectName]);
            
            // إنشاء كورس ودروس تجريبية للمادة
            $course = Course::updateOrCreate(
                [
                    'teacher_id' => $teacher->id,
                    'subject_id' => $subject->id,
                ],
                [
                    'title' => 'شرح منهج ' . $subjectName . ' - الثالث المتوسط',
                    'description' => 'دورة شاملة ومبسطة لكافة فصول مادة ' . $subjectName . ' الوزارية.',
                    'price' => 25000,
                    'duration' => 'عام دراسي',
                ]
            );

            $course->lessons()->updateOrCreate(
                ['title' => 'المحاضرة 1: مدخل وتأسيس مادة ' . $subjectName],
                [
                    'description' => 'شرح المفاهيم الأساسية والمصطلحات الهامة في مادة ' . $subjectName,
                    'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    'is_free' => true,
                    'order' => 1,
                ]
            );

            $course->lessons()->updateOrCreate(
                ['title' => 'المحاضرة 2: الفصل الأول - الجزء الأول'],
                [
                    'description' => 'شرح تفصيلي للموضوع الأول مع حل الأمثلة الوزارية',
                    'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    'is_free' => false,
                    'order' => 2,
                ]
            );

            $course->lessons()->updateOrCreate(
                ['title' => 'المحاضرة 3: حل الأسئلة والتمارين الوزارية'],
                [
                    'description' => 'مراجعة شاملة وحل الاختبارات النموذجية',
                    'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    'is_free' => false,
                    'order' => 3,
                ]
            );

            // توليد رمز اشتراك تجريبي نشط خاص بهذه المادة
            SubscriptionCode::firstOrCreate(
                ['code' => 'SUB-' . strtoupper(substr(md5($subjectName . $grade3Middle->id), 0, 4)) . '-2026'],
                [
                    'subject_id' => $subject->id,
                    'grade_id' => $grade3Middle->id,
                    'teacher_id' => $teacher->id,
                    'status' => 'active',
                    'created_by' => $admin->id,
                    'notes' => 'رمز تجريبي لمادة ' . $subjectName . ' للصف الثالث المتوسط',
                ]
            );
        }

        // 2. المرحلة الإعدادية (رياضيات، فيزياء، كيمياء، إنكليزي، أحياء، اللغة العربية)
        $prepStage = Stage::updateOrCreate(
            ['name' => 'المرحلة الإعدادية'],
            [
                'description' => 'التحضير للمستقبل الأكاديمي والجامعي والتفوق بالامتحانات الوزارية',
                'image' => '/images/stages/1772939153.png',
            ]
        );

        $prepGrades = ['الصف الرابع الإعدادي', 'الصف الخامس الإعدادي', 'الصف السادس الإعدادي'];
        $prepSubjects = ['رياضيات', 'فيزياء', 'كيمياء', 'إنكليزي', 'أحياء', 'اللغة العربية'];

        foreach ($prepGrades as $gradeName) {
            $grade = $prepStage->grades()->updateOrCreate(['name' => $gradeName]);
            foreach ($prepSubjects as $subjectName) {
                $subject = $grade->subjects()->updateOrCreate(['name' => $subjectName]);

                // ننشئ كورس لصفوف الإعدادية وخاصة السادس الإعدادي
                if ($gradeName === 'الصف السادس الإعدادي') {
                    $course = Course::updateOrCreate(
                        [
                            'teacher_id' => $teacher->id,
                            'subject_id' => $subject->id,
                        ],
                        [
                            'title' => 'شرح منهج ' . $subjectName . ' - السادس الإعدادي (وزاري)',
                            'description' => 'دورة مكثفة مع الأسئلة الوزارية للمتفوقين في مادة ' . $subjectName,
                            'price' => 35000,
                            'duration' => 'عام دراسي',
                        ]
                    );

                    $course->lessons()->updateOrCreate(
                        ['title' => 'المحاضرة 1: مقدمة وشرح الفصل الأول في ' . $subjectName],
                        [
                            'description' => 'الدروس التأسيسية للمنهج الوزاري',
                            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                            'is_free' => true,
                            'order' => 1,
                        ]
                    );

                    $course->lessons()->updateOrCreate(
                        ['title' => 'المحاضرة 2: ملخص القوانين والتمارين في ' . $subjectName],
                        [
                            'description' => 'حل التدريبات والملاحظات الهامة',
                            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                            'is_free' => false,
                            'order' => 2,
                        ]
                    );
                }
            }
        }

        // 3. المرحلة الابتدائية
        $primaryStage = Stage::updateOrCreate(
            ['name' => 'المرحلة الابتدائية'],
            [
                'description' => 'تأسيس قوي لمستقبل مشرق',
                'image' => '/images/stages/1772938475.webp',
            ]
        );

        $primaryGrades = ['الصف الأول الابتدائي', 'الصف الثاني الابتدائي', 'الصف الثالث الابتدائي'];
        $primarySubjects = ['اللغة العربية', 'الرياضيات', 'اللغة الإنكليزية'];

        foreach ($primaryGrades as $gradeName) {
            $grade = $primaryStage->grades()->updateOrCreate(['name' => $gradeName]);
            foreach ($primarySubjects as $subjectName) {
                $grade->subjects()->updateOrCreate(['name' => $subjectName]);
            }
        }

        // 4. رموز اشتراك عامة صالحة لكل المواد (للتجربة والتشغيل السريع)
        $universalCodes = ['EDU-2026-TEST', '1111-2222-3333', 'VIP-IRAQ-2026', 'FREE-PASS-2026'];
        foreach ($universalCodes as $uCode) {
            SubscriptionCode::updateOrCreate(
                ['code' => $uCode],
                [
                    'subject_id' => null, // صالح لكل المواد
                    'grade_id' => null,   // صالح لكل الصفوف
                    'teacher_id' => null,
                    'status' => 'active',
                    'created_by' => $admin->id,
                    'notes' => 'رمز اشتراك عام تجريبي مفعل لجميع المواد والصفوف',
                ]
            );
        }

        $this->call([
            FaqSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
