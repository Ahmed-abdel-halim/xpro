@extends('layouts.app')

@section('title', 'عن المنصة - Xpro')

@section('content')
<!-- Hero Section -->
<div class="relative min-h-[80vh] flex items-center overflow-hidden bg-gradient-to-br from-[#e0f2f1] via-[#f5f5f5] to-[#e8f5e9] dark:from-[#0b1121] dark:via-[#1a1f2e] dark:to-[#0f172a] transition-all duration-500 rounded-[3rem] mb-20 shadow-2xl">
    <!-- Enhanced Decorative background elements -->
    <div class="absolute top-10 left-10 w-72 h-72 bg-gradient-to-br from-yellow-400/30 to-amber-500/20 rounded-full blur-3xl animate-pulse"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 bg-gradient-to-br from-sky-400/20 to-blue-500/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-gradient-to-br from-emerald-400/10 to-teal-500/5 rounded-full blur-3xl"></div>

    <div class="container mx-auto px-10 relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-16 pt-20 lg:pt-0">
            
            <!-- Information Side (Right in RTL) -->
            <div class="lg:w-1/2 text-right order-2 lg:order-1">
                <!-- Badge -->
                <div class="inline-flex items-center gap-3 mb-8 bg-white/80 dark:bg-[#1e293b]/80 backdrop-blur-md px-5 py-2.5 rounded-full border border-[#004d40]/10 dark:border-white/10 shadow-lg">
                    <div class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></div>
                    <span class="text-sm font-black text-[#004d40] dark:text-amber-400">منصة تعليمية رائدة</span>
                    <i class="fa-solid fa-award text-amber-500 text-sm"></i>
                </div>
                
                <!-- Main Heading -->
                <h1 class="text-5xl lg:text-7xl font-black text-[#004d40] dark:text-white leading-[1.1] mb-6">
                    نحن نصنع <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#00897b] to-[#00695c] dark:from-sky-400 dark:to-sky-600">مستقبلك التعليمي</span>
                </h1>
                
                <!-- Enhanced Description -->
                <p class="text-lg lg:text-xl text-gray-600 dark:text-gray-300 mb-12 max-w-2xl leading-relaxed font-medium">
                    في Xpro، نؤمن بأن التعليم هو مفتاح التقدم. نقدم منصة تعليمية متكاملة تجمع بين الخبرة والابتكار، حيث نسعى جاهدين لتوفير بيئة تعليمية محفزة تمكن كل طالب من تحقيق أقصى إمكاناته.
                </p>
                
                <!-- Mission & Vision -->
                <div class="space-y-6 mb-12">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-amber-100 dark:bg-amber-500/20 flex items-center justify-center flex-shrink-0 mt-1">
                            <i class="fa-solid fa-bullseye text-amber-600 dark:text-amber-400"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-[#004d40] dark:text-white mb-2">رؤيتنا</h3>
                            <p class="text-gray-600 dark:text-gray-300">أن نكون المنصة التعليمية الأولى في المنطقة، مساهمين في بناء جيل متعلم ومبدع قادر على مواجهة تحديات المستقبل.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-sky-100 dark:bg-sky-500/20 flex items-center justify-center flex-shrink-0 mt-1">
                            <i class="fa-solid fa-rocket text-sky-600 dark:text-sky-400"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-[#004d40] dark:text-white mb-2">رسالتنا</h3>
                            <p class="text-gray-600 dark:text-gray-300">توفير تعليم عالي الجودة في متناول الجميع، باستخدام أحدث التقنيات والمناهج التعليمية المعتمدة عالمياً.</p>
                        </div>
                    </div>
                </div>
                
                <!-- CTA Button -->
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 lg:gap-6">
                    <a href="{{ route('register') }}" class="group relative px-8 py-4 rounded-2xl bg-gradient-to-r from-[#004d40] to-[#00695c] dark:from-sky-600 dark:to-sky-700 text-white font-black text-lg shadow-2xl transition-all duration-300 hover:shadow-3xl hover:-translate-y-1 overflow-hidden mb-8">
                        <span class="relative z-10 flex items-center gap-2">
                            <span>انضم إلينا الآن</span>
                            <i class="fa-solid fa-arrow-left group-hover:translate-x-1 transition-transform"></i>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-amber-500 to-amber-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>
                </div>
            </div>

            <!-- Image Side (Left in RTL) -->
            <div class="lg:w-1/2 relative order-1 lg:order-2 flex justify-center lg:justify-start">
                <div class="relative w-full max-w-lg">
                    <!-- Background Circle Decor -->
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[85%] h-[85%] bg-gradient-to-br from-yellow-400/40 to-amber-500/20 dark:from-sky-500/10 dark:to-blue-500/5 rounded-full"></div>
                    
                    <!-- Main Image -->
                    <img src="{{ asset('images/hero.png') }}" 
                         alt="Xpro About" 
                         class="relative z-10 w-full h-auto drop-shadow-2xl transform transition-transform duration-700 hover:scale-105 rounded-3xl">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Section -->
<div class="max-w-7xl mx-auto px-6 mb-24">
    <div class="text-center mb-16">
        <h2 class="text-4xl lg:text-5xl font-black mb-6 gradient-text">أرقام تحكي قصة نجاحنا</h2>
        <p class="text-xl text-gray-400 max-w-2xl mx-auto">
            نفتخر بالثقة التي يمنحنا إياها طلابنا وأولياء أمورهم يومياً
        </p>
    </div>
    
    <div class="bg-white dark:bg-[#141c2f] rounded-3xl shadow-2xl border border-[#00555A]/10 dark:border-white/10 overflow-hidden">
        <div class="grid grid-cols-2 md:grid-cols-4 divide-x divide-[#00555A]/10 dark:divide-white/5">
            <div class="p-8 text-center group hover:bg-amber-50 dark:hover:bg-amber-500/5 transition-all duration-300">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-users text-2xl"></i>
                </div>
                <div class="text-3xl font-black text-[#004d40] dark:text-amber-400 mb-2 counter" data-target="50000">0</div>
                <div class="text-sm font-bold text-gray-600 dark:text-gray-400">طالب مستفيد</div>
            </div>
            
            <div class="p-8 text-center group hover:bg-sky-50 dark:hover:bg-sky-500/5 transition-all duration-300">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-sky-400 to-sky-600 flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-chalkboard-user text-2xl"></i>
                </div>
                <div class="text-3xl font-black text-[#004d40] dark:text-sky-400 mb-2 counter" data-target="500">0</div>
                <div class="text-sm font-bold text-gray-600 dark:text-gray-400">معلم خبير</div>
            </div>
            
            <div class="p-8 text-center group hover:bg-emerald-50 dark:hover:bg-emerald-500/5 transition-all duration-300">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-book-open text-2xl"></i>
                </div>
                <div class="text-3xl font-black text-[#004d40] dark:text-emerald-400 mb-2 counter" data-target="1000">0</div>
                <div class="text-sm font-bold text-gray-600 dark:text-gray-400">مادة دراسية</div>
            </div>
            
            <div class="p-8 text-center group hover:bg-purple-50 dark:hover:bg-purple-500/5 transition-all duration-300">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-star text-2xl"></i>
                </div>
                <div class="text-3xl font-black text-[#004d40] dark:text-purple-400 mb-2">4.9</div>
                <div class="text-sm font-bold text-gray-600 dark:text-gray-400">تقييم المنصة</div>
            </div>
        </div>
    </div>
</div>

<!-- Core Values Section -->
<div class="max-w-7xl mx-auto px-6 mb-24">
    <div class="text-center mb-16">
        <h2 class="text-4xl lg:text-5xl font-black mb-6 gradient-text">قيمنا الأساسية</h2>
        <p class="text-xl text-gray-400 max-w-2xl mx-auto">
            المبادئ التي توجهنا في كل خطوة نحو تحقيق التميز التعليمي
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="bg-white dark:bg-[#141c2f] rounded-3xl p-8 border border-[#00555A]/10 dark:border-white/10 hover:border-amber-500 dark:hover:border-sky-500 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl text-center group">
            <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-lightbulb text-3xl"></i>
            </div>
            <h3 class="text-xl font-black text-[#004d40] dark:text-amber-400 mb-3">الابتكار</h3>
            <p class="text-gray-600 dark:text-gray-300">نبحث دائماً عن طرق جديدة ومبتكرة لتحسين تجربة التعلم</p>
        </div>

        <div class="bg-white dark:bg-[#141c2f] rounded-3xl p-8 border border-[#00555A]/10 dark:border-white/10 hover:border-sky-500 dark:hover:border-sky-500 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl text-center group">
            <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-sky-400 to-sky-600 flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-handshake text-3xl"></i>
            </div>
            <h3 class="text-xl font-black text-[#004d40] dark:text-sky-400 mb-3">الثقة</h3>
            <p class="text-gray-600 dark:text-gray-300">نبني علاقات قائمة على الثقة والشفافية مع طلابنا وأولياء الأمور</p>
        </div>

        <div class="bg-white dark:bg-[#141c2f] rounded-3xl p-8 border border-[#00555A]/10 dark:border-white/10 hover:border-emerald-500 dark:hover:border-emerald-500 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl text-center group">
            <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-trophy text-3xl"></i>
            </div>
            <h3 class="text-xl font-black text-[#004d40] dark:text-emerald-400 mb-3">الجودة</h3>
            <p class="text-gray-600 dark:text-gray-300">نلتزم بأعلى معايير الجودة في كل ما نقدمه من محتوى وخدمات</p>
        </div>

        <div class="bg-white dark:bg-[#141c2f] rounded-3xl p-8 border border-[#00555A]/10 dark:border-white/10 hover:border-purple-500 dark:hover:border-purple-500 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl text-center group">
            <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-heart text-3xl"></i>
            </div>
            <h3 class="text-xl font-black text-[#004d40] dark:text-purple-400 mb-3">الشغف</h3>
            <p class="text-gray-600 dark:text-gray-300">نحن نشغف بالتعليم ونسعى لإلهام هذا الشغف في كل طالب</p>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="max-w-7xl mx-auto px-6 mb-24">
    <div class="text-center mb-16">
        <h2 class="text-4xl lg:text-5xl font-black mb-6 gradient-text">لماذا تختار Xpro؟</h2>
        <p class="text-xl text-gray-400 max-w-2xl mx-auto">
            مميزات تجعلنا الخيار الأول للتعليم الرقمي في المنطقة
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="bg-white dark:bg-[#141c2f] rounded-3xl p-8 border border-[#00555A]/10 dark:border-white/10 hover:border-amber-500 dark:hover:border-sky-500 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl group">
            <div class="w-16 h-16 bg-gradient-to-br from-amber-400 to-amber-600 text-white rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-desktop"></i>
            </div>
            <h3 class="text-xl font-black text-[#004d40] dark:text-white mb-3 group-hover:text-amber-600 dark:group-hover:text-sky-400 transition-colors">واجهة عصرية وبسيطة</h3>
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                مصممة خصيصاً لتكون سهلة الاستخدام للطلاب في جميع المراحل العمرية دون تعقيد، مع تجربة مستخدم سلسة وممتعة.
            </p>
        </div>

        <div class="bg-white dark:bg-[#141c2f] rounded-3xl p-8 border border-[#00555A]/10 dark:border-white/10 hover:border-sky-500 dark:hover:border-sky-500 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl group">
            <div class="w-16 h-16 bg-gradient-to-br from-sky-400 to-sky-600 text-white rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h3 class="text-xl font-black text-[#004d40] dark:text-white mb-3 group-hover:text-sky-600 dark:group-hover:text-sky-400 transition-colors">محتوى آمن وموثوق</h3>
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                نخبة من أفضل المدرسين المعتمدين المتخصصين لضمان جودة المعلومات المقدمة، مع مراجعة مستمرة للمحتوى.
            </p>
        </div>

        <div class="bg-white dark:bg-[#141c2f] rounded-3xl p-8 border border-[#00555A]/10 dark:border-white/10 hover:border-emerald-500 dark:hover:border-emerald-500 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl group">
            <div class="w-16 h-16 bg-gradient-to-br from-emerald-400 to-emerald-600 text-white rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-bolt"></i>
            </div>
            <h3 class="text-xl font-black text-[#004d40] dark:text-white mb-3 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">سرعة وأداء فائق</h3>
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                خوادم قوية وتقنيات متطورة تضمن لك مشاهدة الدروس بدون تقطيع وبأعلى جودة ممكنة على جميع الأجهزة.
            </p>
        </div>

        <div class="bg-white dark:bg-[#141c2f] rounded-3xl p-8 border border-[#00555A]/10 dark:border-white/10 hover:border-purple-500 dark:hover:border-purple-500 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl group">
            <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 text-white rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-headset"></i>
            </div>
            <h3 class="text-xl font-black text-[#004d40] dark:text-white mb-3 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">دعم فني على مدار الساعة</h3>
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                فريق دعم فني متخصص جاهز لمساعدتك في أي وقت لحل أي مشكلة أو الإجابة على استفساراتك.
            </p>
        </div>

        <div class="bg-white dark:bg-[#141c2f] rounded-3xl p-8 border border-[#00555A]/10 dark:border-white/10 hover:border-rose-500 dark:hover:border-rose-500 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl group">
            <div class="w-16 h-16 bg-gradient-to-br from-rose-400 to-rose-600 text-white rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-certificate"></i>
            </div>
            <h3 class="text-xl font-black text-[#004d40] dark:text-white mb-3 group-hover:text-rose-600 dark:group-hover:text-rose-400 transition-colors">شهادات معتمدة</h3>
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                شهادات إتمام معتمدة تؤكد نجاحك في الدروس وتساعدك في مسيرتك التعليمية والمهنية.
            </p>
        </div>

        <div class="bg-white dark:bg-[#141c2f] rounded-3xl p-8 border border-[#00555A]/10 dark:border-white/10 hover:border-indigo-500 dark:hover:border-indigo-500 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl group">
            <div class="w-16 h-16 bg-gradient-to-br from-indigo-400 to-indigo-600 text-white rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-chart-line"></i>
            </div>
            <h3 class="text-xl font-black text-[#004d40] dark:text-white mb-3 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">تقارير مفصلة</h3>
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                تتبع مستمر للتقدم الأكاديمي مع تقارير مفصلة تساعد أولياء الأمور على متابعة أداء أبنائهم.
            </p>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="max-w-7xl mx-auto px-6 mb-24">
    <div class="bg-gradient-to-r from-[#004d40] to-[#00695c] dark:from-sky-600 dark:to-sky-700 rounded-3xl p-12 lg:p-16 text-center relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        
        <div class="relative z-10">
            <h2 class="text-3xl lg:text-4xl font-black text-white mb-6">هل أنت مستعد لبدء رحلتك التعليمية؟</h2>
            <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
                انضم إلى آلاف الطلاب الذين يحققون نجاحاً مع Xpro كل يوم
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-[#004d40] dark:text-sky-600 font-black text-lg rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                    سجل الآن مجاناً
                </a>
                <a href="{{ route('contact') }}" class="px-8 py-4 bg-white/20 text-white font-black text-lg rounded-2xl border-2 border-white/30 hover:bg-white/30 transition-all duration-300">
                    تواصل معنا
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
    
    /* Counter Animation */
    .counter {
        transition: all 0.3s ease;
    }
    
    h1, h2 {
        font-family: 'Noto Sans Arabic', sans-serif;
    }
</style>

<script>
// Counter Animation
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('.counter');
    const speed = 200;
    
    const animateCounter = (counter) => {
        const target = +counter.getAttribute('data-target');
        const increment = target / speed;
        
        const updateCount = () => {
            const count = +counter.innerText.replace(/,/g, '');
            
            if (count < target) {
                counter.innerText = Math.ceil(count + increment).toLocaleString();
                setTimeout(updateCount, 1);
            } else {
                counter.innerText = target.toLocaleString();
            }
        };
        
        updateCount();
    };
    
    // Intersection Observer for counter animation
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    counters.forEach(counter => {
        observer.observe(counter);
    });
});
</script>
@endsection
