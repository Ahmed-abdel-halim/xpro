@extends('layouts.app')

@section('title', 'الأسئلة الشائعة - Xpro')

@section('content')
<!-- Hero Section -->
<div class="relative min-h-[50vh] flex items-center overflow-hidden bg-gradient-to-br from-[#e0f2f1] via-[#f5f5f5] to-[#e8f5e9] dark:from-[#0b1121] dark:via-[#1a1f2e] dark:to-[#0f172a] transition-all duration-500 rounded-[3rem] mb-20 shadow-2xl">
    <!-- Enhanced Decorative background elements -->
    <div class="absolute top-10 left-10 w-72 h-72 bg-gradient-to-br from-yellow-400/30 to-amber-500/20 rounded-full blur-3xl animate-pulse"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 bg-gradient-to-br from-sky-400/20 to-blue-500/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>

    <div class="container mx-auto px-10 relative z-10 text-center">
        <!-- Badge -->
        <div class="inline-flex items-center gap-3 mb-8 bg-white/80 dark:bg-[#1e293b]/80 backdrop-blur-md px-5 py-2.5 rounded-full border border-[#004d40]/10 dark:border-white/10 shadow-lg">
            <div class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></div>
            <span class="text-sm font-black text-[#004d40] dark:text-amber-400">إجابات شاملة</span>
            <i class="fa-solid fa-question-circle text-amber-500 text-sm"></i>
        </div>
        
        <!-- Main Heading -->
        <h1 class="text-5xl lg:text-7xl font-black text-[#004d40] dark:text-white leading-[1.1] mb-6">
            كل ما تحتاج <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#00897b] to-[#00695c] dark:from-sky-400 dark:to-sky-600">معرفته</span>
        </h1>
        
        <!-- Enhanced Description -->
        <p class="text-lg lg:text-xl text-gray-600 dark:text-gray-300 mb-12 max-w-3xl mx-auto leading-relaxed font-medium">
            نجيب هنا على أبرز تساؤلاتكم حول منصة Xpro التعليمية، من التسجيل وحتى استخدام الميزات المختلفة
        </p>
    </div>
</div>

<!-- FAQ Categories -->
<div class="max-w-7xl mx-auto px-6 mb-24">
    <!-- Quick Links -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12">
        <a href="#general" class="bg-white dark:bg-[#141c2f] border border-[#00555A]/10 dark:border-white/10 rounded-2xl p-4 text-center hover:border-amber-500 dark:hover:border-sky-500 transition-all duration-300 hover:-translate-y-1 group">
            <i class="fa-solid fa-info-circle text-amber-500 dark:text-amber-400 text-2xl mb-2 group-hover:scale-110 transition-transform"></i>
            <span class="text-sm font-black text-[#004d40] dark:text-white">عام</span>
        </a>
        
        <a href="#registration" class="bg-white dark:bg-[#141c2f] border border-[#00555A]/10 dark:border-white/10 rounded-2xl p-4 text-center hover:border-sky-500 dark:hover:border-sky-500 transition-all duration-300 hover:-translate-y-1 group">
            <i class="fa-solid fa-user-plus text-sky-500 dark:text-sky-400 text-2xl mb-2 group-hover:scale-110 transition-transform"></i>
            <span class="text-sm font-black text-[#004d40] dark:text-white">التسجيل</span>
        </a>
        
        <a href="#pricing" class="bg-white dark:bg-[#141c2f] border border-[#00555A]/10 dark:border-white/10 rounded-2xl p-4 text-center hover:border-emerald-500 dark:hover:border-emerald-500 transition-all duration-300 hover:-translate-y-1 group">
            <i class="fa-solid fa-tag text-emerald-500 dark:text-emerald-400 text-2xl mb-2 group-hover:scale-110 transition-transform"></i>
            <span class="text-sm font-black text-[#004d40] dark:text-white">الأسعار</span>
        </a>
        
        <a href="#technical" class="bg-white dark:bg-[#141c2f] border border-[#00555A]/10 dark:border-white/10 rounded-2xl p-4 text-center hover:border-purple-500 dark:hover:border-purple-500 transition-all duration-300 hover:-translate-y-1 group">
            <i class="fa-solid fa-cog text-purple-500 dark:text-purple-400 text-2xl mb-2 group-hover:scale-110 transition-transform"></i>
            <span class="text-sm font-black text-[#004d40] dark:text-white">فني</span>
        </a>
    </div>

    <!-- FAQ Items -->
    <div class="space-y-6">
        <!-- General Section -->
        <div id="general" class="mb-12">
            <h2 class="text-3xl lg:text-4xl font-black mb-8 gradient-text">أسئلة عامة</h2>
            
            <div class="space-y-4" x-data="{ active: null }">
                <div class="group border border-[#00555A]/10 dark:border-white/5 rounded-3xl overflow-hidden bg-white/50 dark:bg-[#141c2f]/50 backdrop-blur-md transition-all duration-300">
                    <button @click="active = (active === 0 ? null : 0)" 
                            class="w-full px-8 py-6 text-right flex items-center justify-between gap-4 group-hover:bg-amber-500/5 dark:group-hover:bg-sky-500/5 transition-colors">
                        <span class="text-lg md:text-xl font-bold text-[var(--text-color)] dark:text-white transition-colors" :class="active === 0 ? 'text-amber-600 dark:text-sky-400' : ''">
                            ما هي منصة Xpro؟
                        </span>
                        <div class="flex-shrink-0 w-10 h-10 rounded-2xl bg-amber-500/10 text-amber-600 dark:bg-sky-500/10 dark:text-sky-400 flex items-center justify-center transition-all duration-300" 
                             :class="active === 0 ? 'rotate-180 bg-amber-500 dark:bg-sky-500 text-white' : ''">
                            <i class="fa-solid fa-chevron-down text-sm"></i>
                        </div>
                    </button>
                    
                    <div x-show="active === 0" 
                         x-collapse
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="px-8 pb-6">
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-lg border-t border-[#00555A]/5 dark:border-white/5 pt-4">
                            Xpro هي منصة تعليمية متكاملة تربط بين الطلاب والمعلمين، توفر دروساً مسجلة، فصولاً مباشرة، اختبارات تفاعلية، وأدوات تتبع التقدم الأكاديمي.
                        </p>
                    </div>
                </div>

                <div class="group border border-[#00555A]/10 dark:border-white/5 rounded-3xl overflow-hidden bg-white/50 dark:bg-[#141c2f]/50 backdrop-blur-md transition-all duration-300">
                    <button @click="active = (active === 1 ? null : 1)" 
                            class="w-full px-8 py-6 text-right flex items-center justify-between gap-4 group-hover:bg-amber-500/5 dark:group-hover:bg-sky-500/5 transition-colors">
                        <span class="text-lg md:text-xl font-bold text-[var(--text-color)] dark:text-white transition-colors" :class="active === 1 ? 'text-amber-600 dark:text-sky-400' : ''">
                            هل المنصة مناسبة لجميع المراحل الدراسية؟
                        </span>
                        <div class="flex-shrink-0 w-10 h-10 rounded-2xl bg-amber-500/10 text-amber-600 dark:bg-sky-500/10 dark:text-sky-400 flex items-center justify-center transition-all duration-300" 
                             :class="active === 1 ? 'rotate-180 bg-amber-500 dark:bg-sky-500 text-white' : ''">
                            <i class="fa-solid fa-chevron-down text-sm"></i>
                        </div>
                    </button>
                    
                    <div x-show="active === 1" 
                         x-collapse
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="px-8 pb-6">
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-lg border-t border-[#00555A]/5 dark:border-white/5 pt-4">
                            نعم، المنصة تغطي جميع المراحل من الابتدائي إلى الجامعي، مع محتوى مخصص لكل مرحلة ومادة دراسية.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Registration Section -->
        <div id="registration" class="mb-12">
            <h2 class="text-3xl lg:text-4xl font-black mb-8 gradient-text">التسجيل والحسابات</h2>
            
            <div class="space-y-4" x-data="{ active: null }">
                <div class="group border border-[#00555A]/10 dark:border-white/5 rounded-3xl overflow-hidden bg-white/50 dark:bg-[#141c2f]/50 backdrop-blur-md transition-all duration-300">
                    <button @click="active = (active === 0 ? null : 0)" 
                            class="w-full px-8 py-6 text-right flex items-center justify-between gap-4 group-hover:bg-amber-500/5 dark:group-hover:bg-sky-500/5 transition-colors">
                        <span class="text-lg md:text-xl font-bold text-[var(--text-color)] dark:text-white transition-colors" :class="active === 0 ? 'text-amber-600 dark:text-sky-400' : ''">
                            كيف أسجل في المنصة؟
                        </span>
                        <div class="flex-shrink-0 w-10 h-10 rounded-2xl bg-amber-500/10 text-amber-600 dark:bg-sky-500/10 dark:text-sky-400 flex items-center justify-center transition-all duration-300" 
                             :class="active === 0 ? 'rotate-180 bg-amber-500 dark:bg-sky-500 text-white' : ''">
                            <i class="fa-solid fa-chevron-down text-sm"></i>
                        </div>
                    </button>
                    
                    <div x-show="active === 0" 
                         x-collapse
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="px-8 pb-6">
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-lg border-t border-[#00555A]/5 dark:border-white/5 pt-4">
                            التسجيل سهل جداً! اضغط على زر "سجل الآن" واملأ بياناتك الأساسية. ستحصل على تأكيد عبر البريد الإلكتروني ثم يمكنك البدء فوراً.
                        </p>
                    </div>
                </div>

                <div class="group border border-[#00555A]/10 dark:border-white/5 rounded-3xl overflow-hidden bg-white/50 dark:bg-[#141c2f]/50 backdrop-blur-md transition-all duration-300">
                    <button @click="active = (active === 1 ? null : 1)" 
                            class="w-full px-8 py-6 text-right flex items-center justify-between gap-4 group-hover:bg-amber-500/5 dark:group-hover:bg-sky-500/5 transition-colors">
                        <span class="text-lg md:text-xl font-bold text-[var(--text-color)] dark:text-white transition-colors" :class="active === 1 ? 'text-amber-600 dark:text-sky-400' : ''">
                            هل التسجيل مجاني؟
                        </span>
                        <div class="flex-shrink-0 w-10 h-10 rounded-2xl bg-amber-500/10 text-amber-600 dark:bg-sky-500/10 dark:text-sky-400 flex items-center justify-center transition-all duration-300" 
                             :class="active === 1 ? 'rotate-180 bg-amber-500 dark:bg-sky-500 text-white' : ''">
                            <i class="fa-solid fa-chevron-down text-sm"></i>
                        </div>
                    </button>
                    
                    <div x-show="active === 1" 
                         x-collapse
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="px-8 pb-6">
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-lg border-t border-[#00555A]/5 dark:border-white/5 pt-4">
                            نعم، التسجيل مجاني تماماً. يمكنك الوصول إلى الكثير من المحتوى المجاني، مع إمكانية الاشتراك في خطط مدفوعة للميزات الإضافية.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pricing Section -->
        <div id="pricing" class="mb-12">
            <h2 class="text-3xl lg:text-4xl font-black mb-8 gradient-text">الأسعار والدفع</h2>
            
            <div class="space-y-4" x-data="{ active: null }">
                <div class="group border border-[#00555A]/10 dark:border-white/5 rounded-3xl overflow-hidden bg-white/50 dark:bg-[#141c2f]/50 backdrop-blur-md transition-all duration-300">
                    <button @click="active = (active === 0 ? null : 0)" 
                            class="w-full px-8 py-6 text-right flex items-center justify-between gap-4 group-hover:bg-amber-500/5 dark:group-hover:bg-sky-500/5 transition-colors">
                        <span class="text-lg md:text-xl font-bold text-[var(--text-color)] dark:text-white transition-colors" :class="active === 0 ? 'text-amber-600 dark:text-sky-400' : ''">
                            ما هي طرق الدفع المتاحة؟
                        </span>
                        <div class="flex-shrink-0 w-10 h-10 rounded-2xl bg-amber-500/10 text-amber-600 dark:bg-sky-500/10 dark:text-sky-400 flex items-center justify-center transition-all duration-300" 
                             :class="active === 0 ? 'rotate-180 bg-amber-500 dark:bg-sky-500 text-white' : ''">
                            <i class="fa-solid fa-chevron-down text-sm"></i>
                        </div>
                    </button>
                    
                    <div x-show="active === 0" 
                         x-collapse
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="px-8 pb-6">
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-lg border-t border-[#00555A]/5 dark:border-white/5 pt-4">
                            نقبل جميع وسائل الدفع الرئيسية: البطاقات الائتمانية، الحوالات البنكية، والدفع الإلكتروني الآمن. جميع المعاملات مشفرة ومؤمنة.
                        </p>
                    </div>
                </div>

                <div class="group border border-[#00555A]/10 dark:border-white/5 rounded-3xl overflow-hidden bg-white/50 dark:bg-[#141c2f]/50 backdrop-blur-md transition-all duration-300">
                    <button @click="active = (active === 1 ? null : 1)" 
                            class="w-full px-8 py-6 text-right flex items-center justify-between gap-4 group-hover:bg-amber-500/5 dark:group-hover:bg-sky-500/5 transition-colors">
                        <span class="text-lg md:text-xl font-bold text-[var(--text-color)] dark:text-white transition-colors" :class="active === 1 ? 'text-amber-600 dark:text-sky-400' : ''">
                            هل يمكنني إلغاء اشتراكي في أي وقت؟
                        </span>
                        <div class="flex-shrink-0 w-10 h-10 rounded-2xl bg-amber-500/10 text-amber-600 dark:bg-sky-500/10 dark:text-sky-400 flex items-center justify-center transition-all duration-300" 
                             :class="active === 1 ? 'rotate-180 bg-amber-500 dark:bg-sky-500 text-white' : ''">
                            <i class="fa-solid fa-chevron-down text-sm"></i>
                        </div>
                    </button>
                    
                    <div x-show="active === 1" 
                         x-collapse
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="px-8 pb-6">
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-lg border-t border-[#00555A]/5 dark:border-white/5 pt-4">
                            نعم، يمكنك إلغاء اشتراكك في أي وقت. سيتم إيقاف التجديد التلقائي وستبقى صالحاً حتى نهاية الفترة المدفوعة.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Technical Section -->
        <div id="technical" class="mb-12">
            <h2 class="text-3xl lg:text-4xl font-black mb-8 gradient-text">أسئلة فنية</h2>
            
            <div class="space-y-4" x-data="{ active: null }">
                <div class="group border border-[#00555A]/10 dark:border-white/5 rounded-3xl overflow-hidden bg-white/50 dark:bg-[#141c2f]/50 backdrop-blur-md transition-all duration-300">
                    <button @click="active = (active === 0 ? null : 0)" 
                            class="w-full px-8 py-6 text-right flex items-center justify-between gap-4 group-hover:bg-amber-500/5 dark:group-hover:bg-sky-500/5 transition-colors">
                        <span class="text-lg md:text-xl font-bold text-[var(--text-color)] dark:text-white transition-colors" :class="active === 0 ? 'text-amber-600 dark:text-sky-400' : ''">
                            ما هي متطلبات النظام؟
                        </span>
                        <div class="flex-shrink-0 w-10 h-10 rounded-2xl bg-amber-500/10 text-amber-600 dark:bg-sky-500/10 dark:text-sky-400 flex items-center justify-center transition-all duration-300" 
                             :class="active === 0 ? 'rotate-180 bg-amber-500 dark:bg-sky-500 text-white' : ''">
                            <i class="fa-solid fa-chevron-down text-sm"></i>
                        </div>
                    </button>
                    
                    <div x-show="active === 0" 
                         x-collapse
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="px-8 pb-6">
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-lg border-t border-[#00555A]/5 dark:border-white/5 pt-4">
                            المنصة تعمل على جميع المتصفحات الحديثة (Chrome, Firefox, Safari, Edge) وتتطلب اتصال إنترنت مستقر. متاحة على أجهزة الكمبيوتر والجوالات والأجهزة اللوحية.
                        </p>
                    </div>
                </div>

                <div class="group border border-[#00555A]/10 dark:border-white/5 rounded-3xl overflow-hidden bg-white/50 dark:bg-[#141c2f]/50 backdrop-blur-md transition-all duration-300">
                    <button @click="active = (active === 1 ? null : 1)" 
                            class="w-full px-8 py-6 text-right flex items-center justify-between gap-4 group-hover:bg-amber-500/5 dark:group-hover:bg-sky-500/5 transition-colors">
                        <span class="text-lg md:text-xl font-bold text-[var(--text-color)] dark:text-white transition-colors" :class="active === 1 ? 'text-amber-600 dark:text-sky-400' : ''">
                            هل هناك تطبيق موبايل؟
                        </span>
                        <div class="flex-shrink-0 w-10 h-10 rounded-2xl bg-amber-500/10 text-amber-600 dark:bg-sky-500/10 dark:text-sky-400 flex items-center justify-center transition-all duration-300" 
                             :class="active === 1 ? 'rotate-180 bg-amber-500 dark:bg-sky-500 text-white' : ''">
                            <i class="fa-solid fa-chevron-down text-sm"></i>
                        </div>
                    </button>
                    
                    <div x-show="active === 1" 
                         x-collapse
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="px-8 pb-6">
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-lg border-t border-[#00555A]/5 dark:border-white/5 pt-4">
                            نعم، تطبيق Xpro متاح الآن لنظامي iOS و Android. يمكنك تحميله من App Store أو Google Play والوصول إلى جميع الميزات من جوالك.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Still Need Help Section -->
<div class="max-w-7xl mx-auto px-6 mb-24">
    <div class="bg-gradient-to-r from-[#004d40] to-[#00695c] dark:from-sky-600 dark:to-sky-700 rounded-3xl p-12 lg:p-16 text-center relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        
        <div class="relative z-10">
            <h2 class="text-3xl lg:text-4xl font-black text-white mb-6">لم تجد إجابتك؟</h2>
            <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
                فريق الدعم لدينا جاهز لمساعدتك في أي استفسار أو مشكلة تواجهها
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('contact') }}" class="px-8 py-4 bg-white text-[#004d40] dark:text-sky-600 font-black text-lg rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                    تواصل مع الدعم الفني
                </a>
                <a href="mailto:support@xpro.com" class="px-8 py-4 bg-white/20 text-white font-black text-lg rounded-2xl border-2 border-white/30 hover:bg-white/30 transition-all duration-300">
                    support@xpro.com
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
