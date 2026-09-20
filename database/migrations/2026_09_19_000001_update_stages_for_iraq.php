<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. تغيير المرحلة الثانوية إلى المتوسطة
        DB::table('stages')->where('name', 'المرحلة الثانوية')->update(['name' => 'المرحلة المتوسطة', 'description' => 'مرحلة بناء الأسس العلمية المتقدمة']);

        // 2. حذف صفوف المرحلة الثانوية القديمة وإضافة الصف الثالث فقط
        $middleStage = DB::table('stages')->where('name', 'المرحلة المتوسطة')->first();
        if ($middleStage) {
            // حذف الصفوف القديمة للمرحلة الثانوية
            $oldGradeIds = DB::table('grades')->where('stage_id', $middleStage->id)->pluck('id');
            if ($oldGradeIds->isNotEmpty()) {
                DB::table('subjects')->whereIn('grade_id', $oldGradeIds)->delete();
                DB::table('grades')->where('stage_id', $middleStage->id)->delete();
            }

            // إضافة الصف الثالث المتوسط
            $gradeId = DB::table('grades')->insertGetId([
                'stage_id' => $middleStage->id,
                'name'     => 'الصف الثالث المتوسط',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // إضافة مواد الصف الثالث المتوسط
            $subjects = ['رياضيات', 'فيزياء', 'كيمياء', 'إنكليزي'];
            foreach ($subjects as $subjectName) {
                DB::table('subjects')->insert([
                    'grade_id'   => $gradeId,
                    'name'       => $subjectName,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // 3. المرحلة الإعدادية - إضافة مواد لصفوفها
        $prepStage = DB::table('stages')->where('name', 'المرحلة الإعدادية')->first();
        if ($prepStage) {
            $prepGrades = DB::table('grades')->where('stage_id', $prepStage->id)->get();
            $prepSubjects = ['رياضيات', 'فيزياء', 'كيمياء', 'إنكليزي', 'أحياء', 'اللغة العربية'];

            foreach ($prepGrades as $grade) {
                // إضافة المواد إن لم تكن موجودة
                foreach ($prepSubjects as $subjectName) {
                    $exists = DB::table('subjects')->where('grade_id', $grade->id)->where('name', $subjectName)->exists();
                    if (!$exists) {
                        DB::table('subjects')->insert([
                            'grade_id'   => $grade->id,
                            'name'       => $subjectName,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            // إذا لم يكن في الإعدادية صفوف، أضف صفوفاً افتراضية
            if ($prepGrades->isEmpty()) {
                foreach (['الصف الأول الإعدادي', 'الصف الثاني الإعدادي', 'الصف الثالث الإعدادي'] as $gradeName) {
                    $gradeId = DB::table('grades')->insertGetId([
                        'stage_id' => $prepStage->id,
                        'name'     => $gradeName,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    foreach ($prepSubjects as $subjectName) {
                        DB::table('subjects')->insert([
                            'grade_id'   => $gradeId,
                            'name'       => $subjectName,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
    }

    public function down(): void
    {
        // إعادة التسمية
        DB::table('stages')->where('name', 'المرحلة المتوسطة')->update(['name' => 'المرحلة الثانوية', 'description' => 'طريقك نحو القمة والجامعة']);
    }
};
