@extends('layouts.app')

@section('title', $subject->name)

@section('content')
<div class="py-12 relative min-h-screen">
    <!-- Header Section - Premium Professional Layout -->
    <div class="relative bg-gray-50/50 dark:bg-white/5 border border-gray-100 dark:border-white/10 rounded-[2.5rem] p-8 md:p-12 mb-16 overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-sky-500/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2 pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row-reverse justify-between items-center gap-8">
            <!-- Content -->
            <div class="text-right flex-1">
                <div class="flex items-center justify-start gap-3 mb-6 flex-wrap">
                    <span class="px-4 py-2 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-600 dark:text-amber-500 text-sm font-black flex items-center gap-2">
                        <i class="fa-solid fa-book-open"></i> {{ $subject->name }}
                    </span>
                    <span class="px-4 py-2 rounded-2xl bg-sky-500/10 border border-sky-500/20 text-sky-600 dark:text-sky-400 text-sm font-black flex items-center gap-2">
                        <i class="fa-solid fa-layer-group"></i> {{ $subject->grade->name }}
                    </span>
                </div>
                <h1 class="text-4xl md:text-6xl font-black text-[var(--text-color)] dark:text-white mb-4 leading-tight tracking-tight">مدرسين المادة</h1>
                <p class="text-gray-600 dark:text-gray-400 font-medium text-lg md:text-xl max-w-2xl ml-auto leading-relaxed">اختار المدرس اللي تحب تتابع معاه، وشوف الفصول المتاحة وابدأ رحلتك التعليمية المتميزة.</p>
            </div>

            <!-- Action Button -->
            <div class="shrink-0">
                <a href="{{ route('grade.show', $subject->grade_id) }}" class="group inline-flex items-center gap-3 px-8 py-4 rounded-2xl bg-white dark:bg-white hover:bg-amber-500 text-[#0f1524] hover:text-white transition-all duration-300 font-black shadow-xl shadow-gray-200/50 dark:shadow-white/5 hover:shadow-amber-500/30 border border-gray-100 dark:border-transparent">
                    <span class="text-lg">رجوع للمواد</span>
                    <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-1"></i>
                </a>
            </div>
        </div>
    </div>

    @if($teachers->count() > 0)
        <div class="flex flex-wrap justify-start gap-6 relative z-10" dir="rtl">
            @foreach($teachers as $teacher)
            <!-- Teacher Card -->
            <div class="w-full md:w-[400px] bg-white dark:bg-[#0f1524] rounded-3xl border border-gray-100 dark:border-white/5 p-6 hover:border-amber-500/20 dark:hover:border-white/10 transition-colors shadow-2xl flex flex-col group relative overflow-hidden">
                <!-- Glowing effect -->
                <div class="absolute inset-x-0 -top-10 h-20 bg-amber-500/10 dark:bg-amber-500/20 blur-3xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                
                <div class="flex items-center justify-between mb-8 relative z-10">
                    <div class="text-right flex-1">
                        <div class="text-amber-500 font-bold text-sm mb-1">مدرس المادة</div>
                        <h3 class="text-2xl font-black text-[var(--text-color)] dark:text-white">{{ $teacher->name }}</h3>
                    </div>
                    <div class="w-20 h-20 rounded-2xl overflow-hidden border-2 border-gray-100 dark:border-white/10 shrink-0 ml-4 group-hover:border-amber-500/50 transition-colors">
                        @if($teacher->avatar)
                            <img src="{{ asset('storage/' . $teacher->avatar) }}" alt="{{ $teacher->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-sky-50 dark:bg-sky-900/50 flex items-center justify-center text-3xl text-sky-500 dark:text-sky-400 font-black">
                                {{ mb_substr($teacher->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-white/5 rounded-2xl p-4 flex items-center justify-between mb-6 border border-gray-100 dark:border-white/5">
                    <span class="text-amber-500 font-black text-xl">{{ $teacher->courses_count }}</span>
                    <span class="text-gray-600 dark:text-gray-300 font-bold text-sm">الفصول المتاحة</span>
                </div>

                <a href="{{ route('subject.teacher', ['subject' => $subject->id, 'teacher' => $teacher->id]) }}" class="w-full py-3.5 bg-amber-500 hover:bg-amber-600 dark:bg-white dark:hover:bg-gray-100 text-white dark:text-[#0f1524] rounded-2xl font-black transition-all flex items-center justify-center gap-2 border border-amber-600/20 dark:border-transparent shadow-lg shadow-amber-500/20 dark:group-hover:shadow-[0_0_20px_rgba(255,255,255,0.2)]">
                    <i class="fa-solid fa-arrow-left text-sm group-hover:-translate-x-1 transition-transform"></i>
                    اكتشف الفصول
                </a>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-20 bg-white/5 rounded-3xl border border-white/5 my-12 relative overflow-hidden max-w-2xl mx-auto">
            <div class="w-24 h-24 mx-auto bg-white/5 rounded-2xl flex items-center justify-center mb-6 border border-white/5">
                <i class="fa-solid fa-user-xmark text-5xl text-gray-500"></i>
            </div>
            <h2 class="text-2xl font-black text-white mb-3">لا يوجد معلمين</h2>
            <p class="text-gray-400 font-medium">لم يتم إضافة أي معلمين يشرحون هذه المادة حتى الآن.</p>
        </div>
    @endif
</div>
@endsection
