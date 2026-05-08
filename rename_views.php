<?php

$dir = 'd:/smartshcool/resources/views/xpro/';
$files = scandir($dir);

$mapping = [
    'الصف الاول الابتدائي' => 'primary-1',
    'الصف الثاني الابتدائي' => 'primary-2',
    'الصف الثالث الابتدائي' => 'primary-3',
    'الصف الرابع الابتدائي' => 'primary-4',
    'الصف الخامس الابتدائي' => 'primary-5',
    'الصف السادس الابتدائي' => 'primary-6',
    'الصف الاول الاعدادي' => 'prep-1',
    'الصف الثاني الاعدادي' => 'prep-2',
    'الصف الثالث الاعدادي' => 'prep-3',
    'الصف الاول ثانوي عام' => 'secondary-1',
    'الصف الثاني ثانوي عام' => 'secondary-2',
    'الصف الثالث ثانوي عام' => 'secondary-3',
    'كي جي ون' => 'kg1',
    'كي جي تو' => 'kg2',
    'بروفايل' => 'profile',
    'برزوفايل' => 'profile',
    'كورس' => 'course',
    'عربي' => 'arabic',
    'انجليزي' => 'english',
    'فرنسي' => 'french',
    'الماني' => 'german',
    'ايطالي' => 'italian',
    'اسباني' => 'spanish',
    'تركي' => 'turkish',
    'صيني' => 'chinese',
    'تاريخ' => 'history',
    'جغرافيا' => 'geography',
    'فلسفة' => 'philosophy',
    'علم نفس' => 'psychology',
    'كيميا' => 'chemistry',
    'فيزياء' => 'physics',
    'احياء' => 'biology',
    'رياضة' => 'math',
    'دروس' => 'lessons',
    'الفرقة الاولى' => 'year-1',
    'الفرقة الثانية' => 'year-2',
    'الفرقة الثالثة' => 'year-3',
    'الفرقة الرابعة' => 'year-4',
    'تجارة' => 'commerce',
    'حقوق' => 'law',
    'هندسة' => 'engineering',
    'طب' => 'medicine',
    'تمريض' => 'nursing',
    'اسنان' => 'dentistry',
    'اعلام' => 'media',
    'علوم' => 'science',
    'اداب' => 'arts',
    'زراعة' => 'agriculture',
    'تربية' => 'education',
    'حاسب الي' => 'computer',
    'دين' => 'religion',
    'تربيه وطنية' => 'national-education',
    'برمجة' => 'programming',
    'تطوير' => 'development',
    'تصميم' => 'design',
    'مهارات' => 'skills',
    'تواصل' => 'communication',
    'تحليل' => 'analysis',
    'بيانات' => 'data',
    'ذكاء اصطناعي' => 'ai',
];

foreach ($files as $file) {
    if ($file === '.' || $file === '..') continue;
    
    $oldPath = $dir . $file;
    if (is_dir($oldPath)) continue;

    $info = pathinfo($file);
    $filename = $info['filename'];
    $ext = $info['extension'];

    if ($ext === 'html' || $ext === 'HTML' || $ext === 'htnl') {
        $newName = $filename;
        foreach ($mapping as $ar => $en) {
            $newName = str_replace($ar, $en, $newName);
        }
        
        // Clean up: lowercase, replace spaces with dashes, removes non-alphanumeric except dashes
        $newName = strtolower($newName);
        $newName = str_replace([' ', '(', ')', '&', '.'], '-', $newName);
        $newName = preg_replace('/-+/', '-', $newName);
        $newName = trim($newName, '-');
        
        // Final name
        $finalName = $newName . '.blade.php';
        $newPath = $dir . $finalName;
        
        if ($oldPath !== $newPath) {
            echo "Renaming $file to $finalName\n";
            rename($oldPath, $newPath);
        }
    }
}
