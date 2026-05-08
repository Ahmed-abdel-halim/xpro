@extends('layouts.app')

@section('title', 'خدماتنا - Xpro')

@section('content')
<!-- Hero Section -->
<div class="relative min-h-[70vh] flex items-center overflow-hidden bg-gradient-to-br from-[#e0f2f1] via-[#f5f5f5] to-[#e8f5e9] dark:from-[#0b1121] dark:via-[#1a1f2e] dark:to-[#0f172a] transition-all duration-500 rounded-[3rem] mb-20 shadow-2xl">
    <!-- Enhanced Decorative background elements -->
    <div class="absolute top-10 left-10 w-72 h-72 bg-gradient-to-br from-yellow-400/30 to-amber-500/20 rounded-full blur-3xl animate-pulse"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 bg-gradient-to-br from-sky-400/20 to-blue-500/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>

    <div class="container mx-auto px-10 relative z-10 text-center">
        <!-- Badge -->
        <div class="inline-flex items-center gap-3 mb-8 bg-white/80 dark:bg-[#1e293b]/80 backdrop-blur-md px-5 py-2.5 rounded-full border border-[#004d40]/10 dark:border-white/10 shadow-lg">
            <div class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></div>
            <span class="text-sm font-black text-[#004d40] dark:text-amber-400">خدمات تعليمية متكاملة</span>
            <i class="fa-solid fa-graduation-cap text-amber-500 text-sm"></i>
        </div>
        
        <!-- Main Heading -->
        <h1 class="text-5xl lg:text-7xl font-black text-[#004d40] dark:text-white leading-[1.1] mb-6">
            كل ما تحتاجه <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#00897b] to-[#00695c] dark:from-sky-400 dark:to-sky-600">لنجاحك التعليمي</span>
        </h1>
        
        <!-- Enhanced Description -->
        <p class="text-lg lg:text-xl text-gray-600 dark:text-gray-300 mb-12 max-w-3xl mx-auto leading-relaxed font-medium">
            نقدم مجموعة شاملة من الخدمات التعليمية المصممة لتلبية جميع احتياجات الطلاب والمعلمين وأولياء الأمور، مع ضمان أعلى معايير الجودة والاحترافية.
        </p>
    </div>
</div>

<!-- Services Grid -->
<div class="max-w-7xl mx-auto px-6 mb-24">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Service 1 -->
        <div class="bg-white dark:bg-[#141c2f] rounded-3xl p-8 border border-[#00555A]/10 dark:border-white/10 hover:border-amber-500 dark:hover:border-sky-500 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl group">
            <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-video text-3xl"></i>
            </div>
            <h3 class="text-xl font-black text-[#004d40] dark:text-white mb-3 group-hover:text-amber-600 dark:group-hover:text-sky-400 transition-colors text-center">دروس مسجلة</h3>
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed text-center">
                محتوى تعليمي عالي الجودة متاح على مدار الساعة، يمكنك مشاهدته في أي وقت ومن أي مكان
            </p>
        </div>

        <!-- Service 2 -->
        <div class="bg-white dark:bg-[#141c2f] rounded-3xl p-8 border border-[#00555A]/10 dark:border-white/10 hover:border-sky-500 dark:hover:border-sky-500 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl group">
            <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-sky-400 to-sky-600 flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-chalkboard-user text-3xl"></i>
            </div>
            <h3 class="text-xl font-black text-[#004d40] dark:text-white mb-3 group-hover:text-sky-600 dark:group-hover:text-sky-400 transition-colors text-center">دروس مباشرة</h3>
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed text-center">
                فصول دراسية تفاعلية مباشرة مع أفضل المعلمين، مع إمكانية التفاعل والطرح الأسئلة
            </p>
        </div>

        <!-- Service 3 -->
        <div class="bg-white dark:bg-[#141c2f] rounded-3xl p-8 border border-[#00555A]/10 dark:border-white/10 hover:border-emerald-500 dark:hover:border-emerald-500 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl group">
            <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-file-alt text-3xl"></i>
            </div>
            <h3 class="text-xl font-black text-[#004d40] dark:text-white mb-3 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors text-center">اختبارات تفاعلية</h3>
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed text-center">
                اختبارات وتقييمات تفاعلية تساعد على قياس مستوى الفهم وتحسين الأداء الأكاديمي
            </p>
        </div>

        <!-- Service 4 -->
        <div class="bg-white dark:bg-[#141c2f] rounded-3xl p-8 border border-[#00555A]/10 dark:border-white/10 hover:border-purple-500 dark:hover:border-purple-500 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl group">
            <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-chart-line text-3xl"></i>
            </div>
            <h3 class="text-xl font-black text-[#004d40] dark:text-white mb-3 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors text-center">تقارير مفصلة</h3>
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed text-center">
                تقارير مفصلة عن التقدم الأكاديمي والتحليلات الشخصية لمساعدة الطلاب على التحسن
            </p>
        </div>

        <!-- Service 5 -->
        <div class="bg-white dark:bg-[#141c2f] rounded-3xl p-8 border border-[#00555A]/10 dark:border-white/10 hover:border-rose-500 dark:hover:border-rose-500 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl group">
            <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-rose-400 to-rose-600 flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-certificate text-3xl"></i>
            </div>
            <h3 class="text-xl font-black text-[#004d40] dark:text-white mb-3 group-hover:text-rose-600 dark:group-hover:text-rose-400 transition-colors text-center">شهادات معتمدة</h3>
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed text-center">
                شهادات إتمام معتمدة بعد كل دورة، مع إمكانية إضافتها إلى السيرة الذاتية
            </p>
        </div>

        <!-- Service 6 -->
        <div class="bg-white dark:bg-[#141c2f] rounded-3xl p-8 border border-[#00555A]/10 dark:border-white/10 hover:border-indigo-500 dark:hover:border-indigo-500 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl group">
            <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-indigo-400 to-indigo-600 flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-headset text-3xl"></i>
            </div>
            <h3 class="text-xl font-black text-[#004d40] dark:text-white mb-3 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors text-center">دعم فني 24/7</h3>
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed text-center">
                فريق دعم فني متخصص جاهز لمساعدتك في أي وقت لحل أي مشكلة تقنية
            </p>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="max-w-7xl mx-auto px-6 mb-24">
    <div class="text-center mb-16">
        <h2 class="text-4xl lg:text-5xl font-black mb-6 gradient-text">لماذا تختار خدماتنا؟</h2>
        <p class="text-xl text-gray-400 max-w-2xl mx-auto">
            مميزات تجعلنا الخيار الأول للتعليم الرقمي في المنطقة
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="text-center">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-amber-100 dark:bg-amber-500/20 flex items-center justify-center text-amber-600 dark:text-amber-400">
                <i class="fa-solid fa-check text-2xl"></i>
            </div>
            <h3 class="text-lg font-black text-[#004d40] dark:text-white mb-2">جودة عالية</h3>
            <p class="text-gray-600 dark:text-gray-300">محتوى تعليمي معتمد وعالي الجودة</p>
        </div>

        <div class="text-center">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-sky-100 dark:bg-sky-500/20 flex items-center justify-center text-sky-600 dark:text-sky-400">
                <i class="fa-solid fa-mobile-alt text-2xl"></i>
            </div>
            <h3 class="text-lg font-black text-[#004d40] dark:text-white mb-2">توافق كامل</h3>
            <p class="text-gray-600 dark:text-gray-300">يعمل على جميع الأجهزة والمنصات</p>
        </div>

        <div class="text-center">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-emerald-100 dark:bg-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                <i class="fa-solid fa-sync text-2xl"></i>
            </div>
            <h3 class="text-lg font-black text-[#004d40] dark:text-white mb-2">تحديثات مستمرة</h3>
            <p class="text-gray-600 dark:text-gray-300">محتوى جديد ومحدث باستمرار</p>
        </div>

        <div class="text-center">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-purple-100 dark:bg-purple-500/20 flex items-center justify-center text-purple-600 dark:text-purple-400">
                <i class="fa-solid fa-lock text-2xl"></i>
            </div>
            <h3 class="text-lg font-black text-[#004d40] dark:text-white mb-2">آمن وموثوق</h3>
            <p class="text-gray-600 dark:text-gray-300">حماية كاملة للبيانات والخصوصية</p>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="max-w-7xl mx-auto px-6 mb-24">
    <div class="bg-gradient-to-r from-[#004d40] to-[#00695c] dark:from-sky-600 dark:to-sky-700 rounded-3xl p-12 lg:p-16 text-center relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        
        <div class="relative z-10">
            <h2 class="text-3xl lg:text-4xl font-black text-white mb-6">هل أنت مستعد للاستفادة من خدماتنا؟</h2>
            <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
                انضم إلى آلاف الطلاب الذين يستفيدون من خدماتنا التعليمية المتميزة
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-[#004d40] dark:text-sky-600 font-black text-lg rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                    ابدأ الآن
                </a>
                <a href="{{ route('contact') }}" class="px-8 py-4 bg-white/20 text-white font-black text-lg rounded-2xl border-2 border-white/30 hover:bg-white/30 transition-all duration-300">
                    اطلب استشارة مجانية
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .gradient-text {
        background: linear-gradient(135deg, #004d40, #00897b);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .dark .gradient-text {
        background: linear-gradient(135deg, #0ea5e9, #0284c7);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    h1, h2 {
        font-family: 'Noto Sans Arabic', sans-serif;
    }
</style>
@endsection
