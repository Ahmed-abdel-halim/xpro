@extends('layouts.app')

@section('title', $grade->name)

@section('content')
<div class="py-12">
    <div class="bg-white dark:bg-[#141c2f] border border-gray-100 dark:border-white/10 p-8 md:p-10 rounded-[32px] shadow-2xl shadow-gray-200/50 dark:shadow-none mb-14 relative overflow-hidden flex flex-col items-start right-align-fix text-right w-full">
        <!-- Decoration -->
        <div class="absolute -top-24 -left-24 w-64 h-64 bg-amber-500/10 dark:bg-sky-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 w-full h-1 bg-gradient-to-r from-amber-500 to-amber-300 dark:from-sky-500 dark:to-indigo-500"></div>

        <!-- Return Button -->
        <a href="{{ route('stage.show', $grade->stage_id) }}" 
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gray-50 dark:bg-white/5 text-amber-600 dark:text-sky-400 font-bold border border-gray-200 dark:border-white/10 hover:border-amber-500 dark:hover:border-sky-500 hover:-translate-y-1 hover:shadow-xl hover:shadow-amber-500/10 dark:hover:shadow-sky-500/10 transition-all duration-300 mb-8 max-w-fit group relative z-10">
            <i class="fa-solid fa-arrow-right group-hover:-translate-x-1 transition-transform duration-300"></i>
            <span>العودة لـ {{ $grade->stage->name }}</span>
        </a>
        
        <!-- Main Title Area -->
        <div class="flex items-center gap-4 mb-4 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-amber-500/10 dark:bg-sky-500/10 border border-amber-500/20 dark:border-sky-500/20 flex flex-shrink-0 items-center justify-center text-amber-600 dark:text-sky-400 text-3xl shadow-inner">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-[#00555A] dark:text-white">{{ $grade->name }}</h1>
        </div>
        
        <p class="text-lg text-gray-500 dark:text-gray-400 font-medium flex items-center gap-2 relative z-10">
            <i class="fa-solid fa-book-open text-amber-500/70 dark:text-sky-400/70"></i>
            اختر المادة الدراسية للمتابعة
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($subjects as $subject)
            <a href="{{ route('subject.show', $subject->id) }}" 
               class="group relative overflow-hidden rounded-[24px] bg-white dark:bg-[#141c2f] border border-[#00555A]/10 dark:border-white/10 hover:border-amber-500 dark:hover:border-sky-500 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-amber-500/10 dark:hover:shadow-sky-500/10">
                
                <!-- Image Container -->
                <div class="relative h-48 overflow-hidden">
                    @if($subject->image)
                        <img src="{{ $subject->image }}" alt="{{ $subject->name }}" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-amber-500/10 to-white dark:from-sky-900/50 dark:to-[#141c2f] flex items-center justify-center text-5xl text-amber-500/30 dark:text-sky-400">
                            <i class="fa-solid fa-book-open"></i>
                        </div>
                    @endif
                    
                    <!-- Overlay Gradient -->
                    <div class="absolute inset-0 bg-gradient-to-t from-white dark:from-[#141c2f] via-transparent to-transparent opacity-60"></div>
                </div>

                <!-- Content -->
                <div class="p-6 text-right">
                    <div class="flex items-center justify-between mb-3">
                        <span class="px-3 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:bg-sky-500/10 dark:text-sky-400 text-xs font-black uppercase tracking-widest">
                            مادة دراسية
                        </span>
                        <div class="w-8 h-8 rounded-lg bg-amber-500/5 dark:bg-white/5 flex items-center justify-center text-amber-600 dark:text-sky-400 group-hover:bg-amber-500 dark:group-hover:bg-sky-500 group-hover:text-white transition-colors duration-300">
                            <i class="fa-solid fa-arrow-left text-xs"></i>
                        </div>
                    </div>
                    
                    <h3 class="text-2xl font-black text-[var(--text-color)] dark:text-white mb-2 group-hover:text-amber-600 dark:group-hover:text-sky-400 transition-colors">{{ $subject->name }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-medium line-clamp-2">شرح تفاعلي مبسط مع نخبة من المعلمين</p>
                </div>

                <!-- Bottom Action -->
                <div class="px-6 pb-6">
                    <div class="w-full py-3 rounded-xl bg-amber-500 dark:bg-sky-500 border border-amber-500 dark:border-sky-500 text-center text-white dark:text-white text-sm font-black group-hover:bg-amber-600 dark:group-hover:bg-sky-600 group-hover:border-amber-600 dark:group-hover:border-sky-600 transition-all duration-300 shadow-lg shadow-amber-500/20 dark:shadow-sky-500/20">
                        تصفح الكورسات
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
