@extends('layouts.app')

@section('title', $stage->name)

@section('content')
<div class="py-12">
    <div class="bg-white dark:bg-[#141c2f] border border-gray-100 dark:border-white/10 p-8 md:p-10 rounded-[32px] shadow-2xl shadow-gray-200/50 dark:shadow-none mb-14 relative overflow-hidden flex flex-col items-start right-align-fix text-right w-full">
        <!-- Decoration -->
        <div class="absolute -top-24 -left-24 w-64 h-64 bg-amber-500/10 dark:bg-sky-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 w-full h-1 bg-gradient-to-r from-amber-500 to-amber-300 dark:from-sky-500 dark:to-indigo-500"></div>

        <!-- Return Button -->
        <a href="{{ route('home') }}" 
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gray-50 dark:bg-white/5 text-amber-600 dark:text-sky-400 font-bold border border-gray-200 dark:border-white/10 hover:border-amber-500 dark:hover:border-sky-500 hover:-translate-y-1 hover:shadow-xl hover:shadow-amber-500/10 dark:hover:shadow-sky-500/10 transition-all duration-300 mb-8 max-w-fit group relative z-10">
            <i class="fa-solid fa-arrow-right group-hover:-translate-x-1 transition-transform duration-300"></i>
            <span>العودة للرئيسية</span>
        </a>
        
        <!-- Main Title Area -->
        <div class="flex items-center gap-4 mb-4 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-amber-500/10 dark:bg-sky-500/10 border border-amber-500/20 dark:border-sky-500/20 flex flex-shrink-0 items-center justify-center text-amber-600 dark:text-sky-400 text-3xl shadow-inner">
                <i class="fa-solid fa-layer-group"></i>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-[#00555A] dark:text-white">{{ $stage->name }}</h1>
        </div>
        
        <p class="text-lg text-gray-500 dark:text-gray-400 font-medium flex items-center gap-2 relative z-10">
            <i class="fa-solid fa-circle-info text-amber-500/70 dark:text-sky-400/70 text-sm"></i>
            {{ $stage->description }}
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($grades as $grade)
            <a href="{{ route('grade.show', $grade->id) }}" 
               class="group relative overflow-hidden rounded-[24px] bg-white dark:bg-[#141c2f] border border-[#00555A]/10 dark:border-white/10 hover:border-amber-500 dark:hover:border-sky-500 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-amber-500/10 dark:hover:shadow-sky-500/10 p-8 flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-black text-[var(--text-color)] dark:text-white mb-2 group-hover:text-amber-600 dark:group-hover:text-sky-400 transition-colors">{{ $grade->name }}</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">عرض المواد الدراسية</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-amber-500/10 dark:bg-sky-500/10 flex items-center justify-center text-amber-500 dark:text-sky-400 group-hover:bg-amber-500 dark:group-hover:bg-sky-500 group-hover:text-white transition-all duration-500 shadow-[0_0_20px_rgba(245,158,11,0.1)] dark:shadow-[0_0_20px_rgba(14,165,233,0.1)] group-hover:shadow-amber-500/40 dark:group-hover:shadow-sky-500/40 transform group-hover:-translate-x-2">
                    <i class="fa-solid fa-arrow-left"></i>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
