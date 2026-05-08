@extends('layouts.app')

@section('title', 'Xpro - حلم الكلية اللي في دماغك يبتدي من هنا')

@section('content')
<!-- Modern Hero Section -->
<div class="relative min-h-[90vh] flex items-center overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute top-20 left-10 w-64 h-64 bg-yellow-400/20 rounded-full blur-3xl"></div>
    <div class="absolute bottom-20 right-10 w-96 h-96 bg-sky-400/10 rounded-full blur-3xl"></div>

    <div class="container mx-auto px-6 relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-12 pt-16 lg:pt-0">
            
            <!-- Information Side (Right in RTL) -->
            <div class="lg:w-1/2 text-right order-2 lg:order-1">
                <div class="flex items-center justify-end gap-3 mb-6">
                    <div class="h-[2px] w-12 bg-gray-400 dark:bg-gray-600"></div>
                    <span class="text-gray-600 dark:text-gray-400 font-bold tracking-wide text-sm">فكر . ابتكر . تعلم</span>
                </div>
                
                <h1 class="text-5xl lg:text-7xl font-black text-[#004d40] dark:text-white leading-[1.2] mb-6">
                    حلول مبتكرة لتصل <br>
                    <span class="text-[#00897b] dark:text-sky-500">بمستقبلك للأفضل</span>
                </h1>
                
                <p class="text-lg lg:text-xl text-gray-600 dark:text-gray-400 mb-10 max-w-xl leading-relaxed font-medium">
                    انضم الآن لأكبر منصة تعليمية تفاعلية، حيث نوفر لك كل الموارد التي يحتاجها الطالب المبدع للنجاح والتفوق في دراسته بكل سهولة ويسر.
                </p>
                
                <div class="space-y-6">
                    <p class="text-sm font-bold text-gray-500 dark:text-gray-500">متوفر الآن على</p>
                    <div class="flex flex-wrap items-center justify-end gap-4">
                        <!-- App Store Badge -->
                        <a href="#" class="bg-black text-white px-5 py-2.5 rounded-xl flex items-center gap-3 transition-transform hover:scale-105 hover:shadow-lg">
                            <i class="fa-brands fa-apple text-3xl"></i>
                            <div class="text-right">
                                <div class="text-[10px] leading-none uppercase">Download on the</div>
                                <div class="text-lg font-bold leading-tight">App Store</div>
                            </div>
                        </a>
                        
                        <!-- Play Store Badge -->
                        <a href="#" class="bg-[#004d40] text-white px-5 py-2.5 rounded-xl flex items-center gap-3 transition-transform hover:scale-105 hover:shadow-lg">
                            <i class="fa-brands fa-google-play text-2xl"></i>
                            <div class="text-right">
                                <div class="text-[10px] leading-none uppercase">Get it on</div>
                                <div class="text-lg font-bold leading-tight">Google Play</div>
                            </div>
                        </a>

                        <a href="#more" class="mr-6 group flex items-center gap-2 text-[#004d40] dark:text-sky-400 font-black hover:gap-4 transition-all">
                            <span>تعرف علينا أكثر</span>
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                    </div>
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
                    <div class="absolute top-[20%] -right-10 z-20 bg-white/90 dark:bg-[#1e293b]/90 backdrop-blur-md p-4 rounded-2xl shadow-xl border border-white/50 dark:border-white/10 flex items-start gap-3 animate-float-slow group cursor-default hover:scale-110 transition-transform">
                        <div class="w-10 h-10 rounded-full bg-sky-100 flex items-center justify-center overflow-hidden border-2 border-white">
                            <img src="https://i.pravatar.cc/150?u=sara" alt="Avatar">
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-black text-[#004d40] dark:text-white">سارة أحمد</div>
                            <div class="flex gap-0.5 my-1">
                                <i class="fa-solid fa-star text-[8px] text-amber-500"></i>
                                <i class="fa-solid fa-star text-[8px] text-amber-500"></i>
                                <i class="fa-solid fa-star text-[8px] text-amber-500"></i>
                                <i class="fa-solid fa-star text-[8px] text-amber-500"></i>
                                <i class="fa-solid fa-star text-[8px] text-amber-500"></i>
                            </div>
                            <p class="text-[10px] text-gray-500 dark:text-gray-400 font-bold">المحتوى هنا بجد ممتع وبيسهل المذاكرة.</p>
                        </div>
                    </div>

                    <!-- Floating Testimonial 2 -->
                    <div class="absolute bottom-[20%] -left-6 z-20 bg-white/90 dark:bg-[#1e293b]/90 backdrop-blur-md p-4 rounded-2xl shadow-xl border border-white/50 dark:border-white/10 flex items-start gap-3 animate-float translate-x-4 lg:-translate-x-8 group cursor-default hover:scale-110 transition-transform">
                        <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center overflow-hidden border-2 border-white">
                            <img src="https://i.pravatar.cc/150?u=yassin" alt="Avatar">
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-black text-[#004d40] dark:text-white">ياسين محمود</div>
                            <div class="flex gap-0.5 my-1">
                                <i class="fa-solid fa-star text-[8px] text-amber-500"></i>
                                <i class="fa-solid fa-star text-[8px] text-amber-500"></i>
                                <i class="fa-solid fa-star text-[8px] text-amber-500"></i>
                                <i class="fa-solid fa-star text-[8px] text-amber-500"></i>
                                <i class="fa-solid fa-star text-[8px] text-amber-500"></i>
                            </div>
                            <p class="text-[10px] text-gray-500 dark:text-gray-400 font-bold">قدرت أحسن مستواي في وقت قياسي!</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
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
    h1 {
        font-family: 'Noto Sans Arabic', sans-serif;
    }
</style>
@endsection
