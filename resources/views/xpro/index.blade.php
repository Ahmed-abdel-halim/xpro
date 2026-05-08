@extends('layouts.app')

@section('title', 'الرئيسية')

@section('content')
<!-- Modern Hero Section -->
<div class="relative min-h-[90vh] flex items-center overflow-hidden bg-gradient-to-br from-[#e0f2f1] via-[#f5f5f5] to-[#e8f5e9] dark:from-[#0b1121] dark:via-[#1a1f2e] dark:to-[#0f172a] transition-all duration-500 rounded-[3rem] mb-20 shadow-2xl">
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
                    <span class="text-sm font-black text-[#004d40] dark:text-amber-400">منصة تعليمية معتمدة</span>
                    <i class="fa-solid fa-check-circle text-amber-500 text-sm"></i>
                </div>
                
                <!-- Main Heading -->
                <h1 class="text-5xl lg:text-7xl font-black text-[#004d40] dark:text-white leading-[1.1] mb-6">
                    نحو مستقبل <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#00897b] to-[#00695c] dark:from-sky-400 dark:to-sky-600">تعليمي مشرق</span>
                </h1>
                
                <!-- Enhanced Description -->
                <p class="text-lg lg:text-xl text-gray-600 dark:text-gray-300 mb-12 max-w-2xl leading-relaxed font-medium">
                    نؤمن بقدرة كل طالب على التفوق. منصة Xpro توفر لك بيئة تعليمية متكاملة تجمع بين المعلمين الخبراء، المحتوى التفاعلي، والتقنيات الحديثة لضمان تحقيق أهدافك الأكاديمية بثقة وتميز.
                </p>
                
                <!-- Features List -->
                <div class="space-y-4 mb-12">
                    <div class="flex items-center gap-3 text-gray-700 dark:text-gray-300">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-500/20 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-graduation-cap text-amber-600 dark:text-amber-400"></i>
                        </div>
                        <span class="font-black">معلمون متخصصون في جميع المواد الدراسية</span>
                    </div>
                    <div class="flex items-center gap-3 text-gray-700 dark:text-gray-300">
                        <div class="w-10 h-10 rounded-xl bg-sky-100 dark:bg-sky-500/20 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-laptop text-sky-600 dark:text-sky-400"></i>
                        </div>
                        <span class="font-black">منصة تفاعلية تعمل على جميع الأجهزة</span>
                    </div>
                    <div class="flex items-center gap-3 text-gray-700 dark:text-gray-300">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-500/20 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-chart-line text-emerald-600 dark:text-emerald-400"></i>
                        </div>
                        <span class="font-black">تتبع مستمر للتقدم الأكاديمي</span>
                    </div>
                </div>
                
                <!-- Enhanced CTA Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 lg:gap-6">
                    <a href="{{ route('register') }}" class="group relative px-8 py-4 rounded-2xl bg-gradient-to-r from-[#004d40] to-[#00695c] dark:from-sky-600 dark:to-sky-700 text-white font-black text-lg shadow-2xl transition-all duration-300 hover:shadow-3xl hover:-translate-y-1 overflow-hidden">
                        <span class="relative z-10 flex items-center gap-2">
                            <span>إبدأ رحلتك الآن</span>
                            <i class="fa-solid fa-arrow-left group-hover:translate-x-1 transition-transform"></i>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-amber-500 to-amber-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <span class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>
                    </a>
                    <a href="#stages" class="px-8 py-4 rounded-2xl bg-white/70 dark:bg-white/10 border-2 border-[#004d40]/20 dark:border-white/20 text-[#004d40] dark:text-white font-black text-lg backdrop-blur-md transition-all duration-300 hover:bg-white dark:hover:bg-white/20 hover:shadow-xl hover:-translate-y-1">
                        <span class="flex items-center gap-2">
                            <i class="fa-solid fa-book-open"></i>
                            <span>تصفح المواد</span>
                        </span>
                    </a>
                </div>

            </div>

            <!-- Image Side (Left in RTL) -->
            <div class="lg:w-1/2 relative order-1 lg:order-2 flex justify-center lg:justify-start">
                <!-- Main Image Container -->
                <div class="relative w-full max-w-lg">
                    <!-- Background Circle Decor -->
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[85%] h-[85%] bg-yellow-400/40 dark:bg-sky-500/10 rounded-full"></div>
                    
                    <!-- Teacher Image -->
                    <img src="{{ asset('images/teacher_hero.png') }}" 
                         alt="Xpro Teacher" 
                         class="relative z-10 w-full h-auto drop-shadow-2xl transform transition-transform duration-700 hover:scale-105">

                    <!-- Floating Testimonial 1 -->
                    <div class="absolute top-[15%] -right-2 md:top-[20%] md:-right-10 z-20 flex bg-white/90 dark:bg-[#1e293b]/90 backdrop-blur-md p-2 md:p-4 rounded-xl md:rounded-2xl shadow-xl border border-white/50 dark:border-white/10 items-start gap-2 md:gap-3 animate-float-slow group cursor-default hover:scale-105 md:hover:scale-110 transition-transform">
                        <div class="w-7 h-7 md:w-10 md:h-10 rounded-full bg-sky-100 flex items-center justify-center overflow-hidden border-2 border-white flex-shrink-0">
                            <img src="https://i.pravatar.cc/150?u=sara" alt="Avatar" class="w-full h-full object-cover">
                        </div>
                        <div class="text-right">
                            <div class="text-[10px] md:text-xs font-black text-[#004d40] dark:text-white leading-tight">سارة أحمد</div>
                            <div class="flex gap-0.5 my-0.5 md:my-1">
                                <i class="fa-solid fa-star text-[6px] md:text-[8px] text-amber-500"></i>
                                <i class="fa-solid fa-star text-[6px] md:text-[8px] text-amber-500"></i>
                                <i class="fa-solid fa-star text-[6px] md:text-[8px] text-amber-500"></i>
                                <i class="fa-solid fa-star text-[6px] md:text-[8px] text-amber-500"></i>
                                <i class="fa-solid fa-star text-[6px] md:text-[8px] text-amber-500"></i>
                            </div>
                            <p class="text-[8px] md:text-[10px] text-gray-500 dark:text-gray-400 font-bold whitespace-nowrap">المحتوى ممتع وبيسهل المذاكرة.</p>
                        </div>
                    </div>

                    <!-- Floating Testimonial 2 -->
                    <div class="absolute bottom-[10%] -left-2 md:bottom-[20%] md:-left-6 z-20 flex bg-white/90 dark:bg-[#1e293b]/90 backdrop-blur-md p-2 md:p-4 rounded-xl md:rounded-2xl shadow-xl border border-white/50 dark:border-white/10 items-start gap-2 md:gap-3 animate-float translate-x-0 md:translate-x-4 lg:-translate-x-8 group cursor-default hover:scale-105 md:hover:scale-110 transition-transform">
                        <div class="w-7 h-7 md:w-10 md:h-10 rounded-full bg-amber-100 flex items-center justify-center overflow-hidden border-2 border-white flex-shrink-0">
                            <img src="https://i.pravatar.cc/150?u=mahmoud" alt="Avatar" class="w-full h-full object-cover">
                        </div>
                        <div class="text-right">
                            <div class="text-[10px] md:text-xs font-black text-[#004d40] dark:text-white leading-tight">ياسين محمود</div>
                            <div class="flex gap-0.5 my-0.5 md:my-1">
                                <i class="fa-solid fa-star text-[6px] md:text-[8px] text-amber-500"></i>
                                <i class="fa-solid fa-star text-[6px] md:text-[8px] text-amber-500"></i>
                                <i class="fa-solid fa-star text-[6px] md:text-[8px] text-amber-500"></i>
                                <i class="fa-solid fa-star text-[6px] md:text-[8px] text-amber-500"></i>
                                <i class="fa-solid fa-star text-[6px] md:text-[8px] text-amber-500"></i>
                            </div>
                            <p class="text-[8px] md:text-[10px] text-gray-500 dark:text-gray-400 font-bold whitespace-nowrap">قدرت أحسن مستواي بسرعة!</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<div id="stages" class="text-center mb-12 scroll-mt-24">
    <h2 class="text-4xl lg:text-5xl font-black mb-6 gradient-text">اختر مرحلتك الدراسية</h2>
    <p class="text-xl text-gray-400 max-w-2xl mx-auto">
        اكتشف عالمك التعليمي الجديد مع أفضل المعلمين في مصر.
    </p>
</div>

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0) translateX(1rem); }
        50% { transform: translateY(-15px) translateX(1rem); }
    }
    @keyframes float-slow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    .animate-float-slow {
        animation: float-slow 8s ease-in-out infinite;
    }
    .gradient-text {
        background: linear-gradient(135deg, #004d40, #00897b);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    h1, h2 {
        font-family: 'Noto Sans Arabic', sans-serif;
    }
    
    /* Counter Animation */
    .counter {
        transition: all 0.3s ease;
    }
    
    /* Enhanced hover effects */
    .hover-lift {
        transition: all 0.3s ease;
    }
    .hover-lift:hover {
        transform: translateY(-5px);
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
                if (counter.getAttribute('data-target') === '98') {
                    counter.innerText = target + '%';
                }
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

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 mt-16 max-w-6xl mx-auto mb-24">
        @foreach($stages as $stage)
            <a href="{{ route('stage.show', $stage->id) }}" 
               class="group relative overflow-hidden rounded-[24px] bg-white dark:bg-[#141c2f] border border-[#00555A]/10 dark:border-white/10 hover:border-amber-500 dark:hover:border-sky-500 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-amber-500/10 dark:hover:shadow-sky-500/10">
                
                <!-- Image Container -->
                <div class="relative h-48 overflow-hidden">
                    @if($stage->image)
                        <img src="{{ $stage->image }}" alt="{{ $stage->name }}" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-amber-500/10 to-white dark:from-sky-900/50 dark:to-[#141c2f] flex items-center justify-center text-5xl text-amber-500/30 dark:text-sky-400">
                            @if(str_contains($stage->name, 'ابتدائي')) <i class="fa-solid fa-school"></i> 
                            @elseif(str_contains($stage->name, 'إعدادي')) <i class="fa-solid fa-book-open"></i> 
                            @elseif(str_contains($stage->name, 'ثانوي')) <i class="fa-solid fa-user-graduate"></i> 
                            @elseif(str_contains($stage->name, 'جامعة')) <i class="fa-solid fa-building-columns"></i> 
                            @else <i class="fa-solid fa-briefcase"></i> @endif
                        </div>
                    @endif
                    
                    <!-- Overlay Gradient -->
                    <div class="absolute inset-0 bg-gradient-to-t from-white dark:from-[#141c2f] via-transparent to-transparent opacity-60"></div>
                </div>

                <!-- Content -->
                <div class="p-6 text-right">
                    <div class="flex items-center justify-between mb-3">
                        <span class="px-3 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:bg-sky-500/10 dark:text-sky-400 text-xs font-black uppercase tracking-widest">
                            مرحلة دراسية
                        </span>
                        <div class="w-8 h-8 rounded-lg bg-amber-500/5 dark:bg-white/5 flex items-center justify-center text-amber-600 dark:text-sky-400 group-hover:bg-amber-500 dark:group-hover:bg-sky-500 group-hover:text-white transition-colors duration-300">
                            <i class="fa-solid fa-arrow-left text-xs"></i>
                        </div>
                    </div>
                    
                    <h3 class="text-2xl font-black text-[var(--text-color)] dark:text-white mb-2 group-hover:text-amber-600 dark:group-hover:text-sky-400 transition-colors">{{ $stage->name }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-medium line-clamp-2">{{ $stage->description }}</p>
                </div>

                <!-- Bottom Action -->
                <div class="px-6 pb-6">
                    <div class="w-full py-3 rounded-xl bg-amber-500 dark:bg-sky-500 border border-amber-500 dark:border-sky-500 text-center text-white dark:text-white text-sm font-black group-hover:bg-amber-600 dark:group-hover:bg-sky-600 group-hover:border-amber-600 dark:group-hover:border-sky-600 transition-all duration-300 shadow-lg shadow-amber-500/20 dark:shadow-sky-500/20">
                        تصفح المواد
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    <!-- Student Reviews Section -->
    <div class="max-w-6xl mx-auto mb-24 px-6 scroll-mt-24">
        <div class="text-center mb-16">
            <h2 class="text-4xl lg:text-5xl font-black mb-6 gradient-text">آراء الطلاب</h2>
            <p class="text-xl text-gray-400 max-w-2xl mx-auto">
                استمع إلى تجارب طلابنا الذين حققوا نجاحاً مع منصتنا
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Student Review 1 -->
            <div class="bg-white dark:bg-[#141c2f] border border-[#00555A]/10 dark:border-white/10 rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center gap-4">
                        <img src="https://i.pravatar.cc/150?img=1" alt="محمد الحربي" 
                             class="w-12 h-12 rounded-full object-cover border-2 border-white dark:border-white/10 shadow-md">
                        <div>
                            <h3 class="text-lg font-black text-[var(--text-color)] dark:text-white">محمد الحربي</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">طالب جامعي</p>
                        </div>
                    </div>
                    <div class="flex gap-1">
                        <i class="fa-solid fa-star text-amber-500 text-sm"></i>
                        <i class="fa-solid fa-star text-amber-500 text-sm"></i>
                        <i class="fa-solid fa-star text-amber-500 text-sm"></i>
                        <i class="fa-solid fa-star text-amber-500 text-sm"></i>
                        <i class="fa-solid fa-star text-amber-500 text-sm"></i>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-4">
                    المنصة ساعدتني جداً في تحسين مستواي الأكاديمي. المحتوى ممتاز والشروحات واضحة ومبسطة.
                </p>
                <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                    <i class="fa-solid fa-graduation-cap text-amber-500"></i>
                    <span>خاض 8 اختبارات</span>
                </div>
            </div>

            <!-- Student Review 2 -->
            <div class="bg-white dark:bg-[#141c2f] border border-[#00555A]/10 dark:border-white/10 rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center gap-4">
                        <img src="https://i.pravatar.cc/150?img=45" alt="نورة القحطاني" 
                             class="w-12 h-12 rounded-full object-cover border-2 border-white dark:border-white/10 shadow-md">
                        <div>
                            <h3 class="text-lg font-black text-[var(--text-color)] dark:text-white">نورة القحطاني</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">موظفة</p>
                        </div>
                    </div>
                    <div class="flex gap-1">
                        <i class="fa-solid fa-star text-amber-500 text-sm"></i>
                        <i class="fa-solid fa-star text-amber-500 text-sm"></i>
                        <i class="fa-solid fa-star text-amber-500 text-sm"></i>
                        <i class="fa-solid fa-star text-amber-500 text-sm"></i>
                        <i class="fa-solid fa-star text-amber-500 text-sm"></i>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-4">
                    أفضل منصة تعليمية تعاملت معها. المرونة في الوقت وجودة المحتوى ممتازة. أنصح بها بشدة.
                </p>
                <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                    <i class="fa-solid fa-book text-amber-500"></i>
                    <span>أنهت 3 كورسات في اللغة</span>
                </div>
            </div>

            <!-- Student Review 3 -->
            <div class="bg-white dark:bg-[#141c2f] border border-[#00555A]/10 dark:border-white/10 rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center gap-4">
                        <img src="https://i.pravatar.cc/150?img=68" alt="عمر السليم" 
                             class="w-12 h-12 rounded-full object-cover border-2 border-white dark:border-white/10 shadow-md">
                        <div>
                            <h3 class="text-lg font-black text-[var(--text-color)] dark:text-white">عمر السليم</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">طالب هندسة حاسوب</p>
                        </div>
                    </div>
                    <div class="flex gap-1">
                        <i class="fa-solid fa-star text-amber-500 text-sm"></i>
                        <i class="fa-solid fa-star text-amber-500 text-sm"></i>
                        <i class="fa-solid fa-star text-amber-500 text-sm"></i>
                        <i class="fa-solid fa-star text-amber-500 text-sm"></i>
                        <i class="fa-solid fa-star text-amber-500 text-sm"></i>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-4">
                    تجربة رائعة! المعلمين محترفين والمنهج منظوم بشكل ممتاز. سجلت في 5 كورسات وكلها مفيدة.
                </p>
                <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                    <i class="fa-solid fa-laptop-code text-amber-500"></i>
                    <span>أنهى 5 كورسات</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Teacher Reviews Section -->
    <div class="max-w-6xl mx-auto mb-24 px-6 scroll-mt-24">
        <div class="text-center mb-16">
            <h2 class="text-4xl lg:text-5xl font-black mb-6 gradient-text">آراء المدرسين</h2>
            <p class="text-xl text-gray-400 max-w-2xl mx-auto">
                شاركنا المعلمون تجاربهم في التعامل مع منصتنا التعليمية
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Teacher Review 1 -->
            <div class="bg-white dark:bg-[#141c2f] border border-[#00555A]/10 dark:border-white/10 rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                <div class="flex items-start gap-6 mb-6">
                    <img src="https://i.pravatar.cc/150?img=2" alt="أ. سارة عبد الله" 
                         class="w-16 h-16 rounded-full object-cover border-3 border-white dark:border-white/10 shadow-lg">
                    <div class="flex-1">
                        <h3 class="text-xl font-black text-[var(--text-color)] dark:text-white mb-1">أ. سارة عبد الله</h3>
                        <p class="text-sm text-amber-600 dark:text-amber-400 font-black mb-3">مدرسة اللغة الإنجليزية</p>
                        <div class="flex gap-1">
                            <i class="fa-solid fa-star text-amber-500 text-sm"></i>
                            <i class="fa-solid fa-star text-amber-500 text-sm"></i>
                            <i class="fa-solid fa-star text-amber-500 text-sm"></i>
                            <i class="fa-solid fa-star text-amber-500 text-sm"></i>
                            <i class="fa-solid fa-star text-amber-500 text-sm"></i>
                        </div>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    منصة ممتازة تتيح لنا كمعلمين الوصول للطلاب بسهولة وتقديم المحتوى التعليمي بشكل احترافي. الأدوات المتاحة تساعد على التفاعل الفعال مع الطلاب.
                </p>
            </div>

            <!-- Teacher Review 2 -->
            <div class="bg-white dark:bg-[#141c2f] border border-[#00555A]/10 dark:border-white/10 rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                <div class="flex items-start gap-6 mb-6">
                    <img src="https://i.pravatar.cc/150?img=12" alt="د. خالد الحميد" 
                         class="w-16 h-16 rounded-full object-cover border-3 border-white dark:border-white/10 shadow-lg">
                    <div class="flex-1">
                        <h3 class="text-xl font-black text-[var(--text-color)] dark:text-white mb-1">د. خالد الحميد</h3>
                        <p class="text-sm text-amber-600 dark:text-amber-400 font-black mb-3">أستاذ البرمجة</p>
                        <div class="flex gap-1">
                            <i class="fa-solid fa-star text-amber-500 text-sm"></i>
                            <i class="fa-solid fa-star text-amber-500 text-sm"></i>
                            <i class="fa-solid fa-star text-amber-500 text-sm"></i>
                            <i class="fa-solid fa-star text-amber-500 text-sm"></i>
                            <i class="fa-solid fa-star text-amber-500 text-sm"></i>
                        </div>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    تجربة تعليمية متكاملة تجمع بين الجودة والسهولة. المنصة توفر بيئة تعليمية محفزة تساعد على تحقيق أفضل النتائج للطلاب والمعلمين معاً.
                </p>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div id="faq" class="max-w-6xl mx-auto mb-24 px-6 scroll-mt-24">
        <div class="text-center mb-16">
            <h2 class="text-4xl lg:text-5xl font-black mb-6 gradient-text">الأسئلة الشائعة</h2>
            <p class="text-xl text-gray-400 max-w-2xl mx-auto">
                نجيب هنا على أبرز تساؤلاتكم لنضعكم على الطريق الصحيح.
            </p>
        </div>

        <div class="space-y-4" x-data="{ active: null }">
            @foreach($faqs as $faq)
                <div class="group border border-[#00555A]/10 dark:border-white/5 rounded-3xl overflow-hidden bg-white/50 dark:bg-[#141c2f]/50 backdrop-blur-md transition-all duration-300">
                    <button @click="active = (active === {{ $loop->index }} ? null : {{ $loop->index }})" 
                            class="w-full px-8 py-6 text-right flex items-center justify-between gap-4 group-hover:bg-amber-500/5 dark:group-hover:bg-sky-500/5 transition-colors">
                        <span class="text-lg md:text-xl font-bold text-[var(--text-color)] dark:text-white transition-colors" :class="active === {{ $loop->index }} ? 'text-amber-600 dark:text-sky-400' : ''">
                            {{ $faq->question }}
                        </span>
                        <div class="flex-shrink-0 w-10 h-10 rounded-2xl bg-amber-500/10 text-amber-600 dark:bg-sky-500/10 dark:text-sky-400 flex items-center justify-center transition-all duration-300" 
                             :class="active === {{ $loop->index }} ? 'rotate-180 bg-amber-500 dark:bg-sky-500 text-white' : ''">
                            <i class="fa-solid fa-chevron-down text-sm"></i>
                        </div>
                    </button>
                    
                    <div x-show="active === {{ $loop->index }}" 
                         x-collapse
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="px-8 pb-6">
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-lg border-t border-[#00555A]/5 dark:border-white/5 pt-4">
                            {{ $faq->answer }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
@endsection