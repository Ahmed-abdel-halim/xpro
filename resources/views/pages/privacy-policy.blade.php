@extends('layouts.app')

@section('title', 'سياسة الخصوصية')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">سياسة الخصوصية</h1>
        
        <div class="prose prose-lg dark:prose-invert max-w-none">
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                نحن في منصة Xpro نلتزم بحماية خصوصيتك وبياناتك الشخصية. توضح هذه السياسة كيفية جمع واستخدام وحماية معلوماتك عند استخدامك لمنصتنا.
            </p>

            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">المعلومات التي نجمعها</h2>
            <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-6 space-y-2">
                <li>المعلومات الشخصية الأساسية (الاسم، البريد الإلكتروني، رقم الهاتف)</li>
                <li>المعلومات التعليمية (المرحلة الدراسية، المواد الدراسية)</li>
                <li>معلومات الدفع والاشتراكات</li>
                <li>بيانات الاستخدام والتفاعل مع المنصة</li>
                <li>معلومات التقنية (عنوان IP، نوع المتصفح، نظام التشغيل)</li>
            </ul>

            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">كيف نستخدم معلوماتك</h2>
            <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-6 space-y-2">
                <li>تقديم خدمات تعليمية مخصصة</li>
                <li>تحسين جودة المحتوى التعليمي</li>
                <li>التواصل معك بشأن الخدمات والتحديثات</li>
                <li>معالجة المدفوعات وإدارة الاشتراكات</li>
                <li>ضمان أمان المنصة والوقاية من الاحتيال</li>
            </ul>

            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">حماية البيانات</h2>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                نتخذ إجراءات أمنية قوية لحماية بياناتك بما في ذلك التشفير والجدران النارية والمراقبة المستمرة. لا نشارك معلوماتك مع أطراف ثالثة إلا بموافقتك أو كما يقتضي القانون.
            </p>

            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">حقوقك</h2>
            <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-6 space-y-2">
                <li>الحق في الوصول إلى بياناتك</li>
                <li>الحق في تصحيح أو تحديث معلوماتك</li>
                <li>الحق في حذف حسابك وبياناتك</li>
                <li>الحق في سحب الموافقة على معالجة البيانات</li>
            </ul>

            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">التواصل معنا</h2>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                إذا كان لديك أي أسئلة أو استفسارات حول سياسة الخصوصية، يمكنك التواصل معنا عبر:
            </p>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
                <p class="text-gray-600 dark:text-gray-300">البريد الإلكتروني: privacy@xpro.com</p>
                <p class="text-gray-600 dark:text-gray-300">الهاتف: 01551322666</p>
            </div>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-8">
                آخر تحديث: {{ date('Y/m/d') }}
            </p>
        </div>
    </div>
</div>
@endsection
