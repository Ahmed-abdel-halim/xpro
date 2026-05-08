<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First delete existing FAQs to avoid duplication
        \App\Models\Faq::truncate();

        $faqs = [
            [
                'question' => 'كيف يمكنني البدء في الدراسة على منصة Xpro؟',
                'answer' => 'الأمر بسيط جداً! كل ما عليك هو إنشاء حساب جديد، اختيار المرحلة الدراسية والصف التابع لك، ثم تصفح المواد والاشتراك في الكورسات التي تختارها.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'هل يمكنني مشاهدة الكورسات في أي وقت؟',
                'answer' => 'نعم، بمجرد اشتراكك في الكورس، تظل جميع الدروس والملفات متاحة لك على مدار الساعة طوال مدة الكورس، لتتعلم بالسرعة التي تناسبك.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'question' => 'ما هي طرق الدفع المتاحة للاشتراك في الكورسات؟',
                'answer' => 'نوفر لك عدة طرق للدفع لتسهيل العملية، يمكنك الدفع عن طريق فودافون كاش، فوري، أو البطاقات البنكية بكل سهولة وأمان.',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'question' => 'هل توجد متابعة دورية مع الطالب؟',
                'answer' => 'بالتأكيد، المنصة توفر نظاماً للمتابعة يتضمن اختبارات دورية بعد الدروس، وتقارير أداء لمساعدة الطالب على تقييم مستواه باستمرار.',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'question' => 'كيف أتواصل مع المعلم إذا كان لدي سؤال؟',
                'answer' => 'توفر المنصة قنوات تواصل مباشرة مع المعلمين ومساعديهم للرد على استفسارات الطلاب وتوضيح أي نقاط غير مفهومة في الدروس.',
                'sort_order' => 5,
                'is_active' => true,
            ]
        ];

        foreach ($faqs as $faq) {
            \App\Models\Faq::create($faq);
        }
    }
}
