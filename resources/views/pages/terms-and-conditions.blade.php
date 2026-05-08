@extends('layouts.app')

@section('title', 'الشروط والأحكام')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">الشروط والأحكام</h1>
        
        <div class="prose prose-lg dark:prose-invert max-w-none">
            
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">قبول الشروط</h2>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                باستخدامك لمنصة Xpro، فإنك تقر بأنك قرأت وفهمت ووافقت على هذه الشروط والأحكام. إذا كنت لا توافق على هذه الشروط، يرجى عدم استخدام منصتنا.
            </p>

            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">الخدمات التعليمية</h2>
            <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-6 space-y-2">
                <li>نقدم محتوى تعليمي عالي الجودة لجميع المراحل الدراسية</li>
                <li>الدروس المسجلة والدروس المباشرة</li>
                <li>الاختبارات التفاعلية والتقييمات</li>
                <li>الشهادات المعتمدة بعد إكمال الدورات</li>
                <li>الدعم الفني المستمر</li>
            </ul>

            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">التسجيل والحسابات</h2>
            <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-6 space-y-2">
                <li>يجب تقديم معلومات دقيقة وحقيقية عند التسجيل</li>
                <li>أنت مسؤول عن سرية حسابك وكلمة المرور</li>
                <li>يُحظر مشاركة بيانات الدخول مع الآخرين</li>
                <li>يجب إبلاغنا فوراً بأي استخدام غير مصرح به لحسابك</li>
            </ul>

            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">الرسوم والمدفوعات</h2>
            <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-6 space-y-2">
                <li>تختلف الرسوم حسب الخدمات والدورات المختارة</li>
                <li>جميع الأسعار معروضة بالعملة المحلية</li>
                <li>يجب سداد المدفوعات قبل الوصول إلى الخدمات المدفوعة</li>
                <li>لا يتم استرداد المبالغ المدفوعة إلا في الحالات المنصوص عليها</li>
            </ul>

            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">الملكية الفكرية</h2>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                جميع المحتويات التعليمية والفيديوهات والمواد المتاحة على المنصة محمية بحقوق الطبع والنشر. يُحظر نسخ أو توزيع أو استخدام هذه المواد دون إذن كتابي منا.
            </p>

            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">الاستخدام المسموح</h2>
            <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-6 space-y-2">
                <li>الاستخدام الشخصي للتعليم والتعلم</li>
                <li>الوصول إلى المحتوى خلال فترة الاشتراك</li>
                <li>تحميل المواد المسموح بها للاستخدام الشخصي</li>
            </ul>

            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">الاستخدام الممنوع</h2>
            <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 mb-6 space-y-2">
                <li>مشاركة بيانات الدخول مع الآخرين</li>
                <li>نسخ أو توزيع المحتوى التعليمي</li>
                <li>استخدام المنصة لأغراض تجارية</li>
                <li>محاولة اختراق أو إتلاف المنصة</li>
                <li>نشر محتوى غير لائق أو مخالف للقانون</li>
            </ul>

            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">الإلغاء والإنهاء</h2>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                نحتفظ بالحق في إنهاء حسابك إذا انتهكت هذه الشروط. يمكنك أيضاً إلغاء اشتراكك في أي وقت من خلال إعدادات الحساب.
            </p>

            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">تحديث الشروط</h2>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                قد نقوم بتحديث هذه الشروط والأحكام من وقت لآخر. سيتم إبلاغك بأي تغييرات مهمة عبر البريد الإلكتروني أو من خلال المنصة.
            </p>

            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">التواصل معنا</h2>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                إذا كان لديك أي أسئلة حول هذه الشروط والأحكام، يمكنك التواصل معنا عبر:
            </p>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
                <p class="text-gray-600 dark:text-gray-300">البريد الإلكتروني: legal@xpro.com</p>
                <p class="text-gray-600 dark:text-gray-300">الهاتف: 01551322666</p>
            </div>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-8">
                آخر تحديث: {{ date('Y/m/d') }}
            </p>
        </div>
    </div>
</div>
@endsection
