@extends('layouts.app')

@section('title', $subject->name . ' - ' . $teacher->name)

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
                        <i class="fa-solid fa-user-tie"></i> مدرس المادة: {{ $teacher->name }}
                    </span>
                    <span class="px-4 py-2 rounded-2xl bg-sky-500/10 border border-sky-500/20 text-sky-600 dark:text-sky-400 text-sm font-black flex items-center gap-2">
                        <i class="fa-solid fa-book-open"></i> {{ $subject->name }}
                    </span>
                </div>
                <h1 class="text-4xl md:text-6xl font-black text-[var(--text-color)] dark:text-white mb-4 leading-tight tracking-tight">فصول المعلم</h1>
                <p class="text-gray-600 dark:text-gray-400 font-medium text-lg md:text-xl max-w-2xl ml-auto leading-relaxed">الكورسات المتاحة للأستاذ {{ $teacher->name }} في مادة {{ $subject->name }}.</p>
            </div>

            <!-- Action Button -->
            <div class="shrink-0">
                <a href="{{ route('subject.show', $subject->id) }}" class="group inline-flex items-center gap-3 px-8 py-4 rounded-2xl bg-white dark:bg-white hover:bg-amber-500 text-[#0f1524] hover:text-white transition-all duration-300 font-black shadow-xl shadow-gray-200/50 dark:shadow-white/5 hover:shadow-amber-500/30 border border-gray-100 dark:border-transparent">
                    <span class="text-lg">رجوع للمعلمين</span>
                    <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-1"></i>
                </a>
            </div>
        </div>
    </div>

    @if($courses->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 relative z-10" dir="rtl">
            @foreach($courses as $course)
                <div class="bg-white dark:bg-white/5 p-6 rounded-[2rem] transition-all border border-gray-100 dark:border-white/5 shadow-xl shadow-gray-200/40 dark:shadow-none hover:-translate-y-2 group flex flex-col h-full relative overflow-hidden">
                    <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-amber-400 to-orange-500 dark:from-sky-400 dark:to-indigo-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative overflow-hidden rounded-2xl mb-6">
                        <img src="{{ $course->thumbnail ?? 'https://placehold.co/600x400/0f172a/38bdf8?text=Course' }}" 
                             alt="{{ $course->title }}" class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-black mb-3 text-[var(--text-color)] dark:text-white line-clamp-2 group-hover:text-amber-500 dark:group-hover:text-sky-400 transition-colors">{{ $course->title }}</h3>
                        <div class="flex items-center space-x-2 space-x-reverse mb-6">
                            <div class="w-10 h-10 rounded-full bg-amber-50 dark:bg-sky-500/10 text-amber-500 dark:text-sky-400 flex items-center justify-center text-sm shadow-inner shrink-0 leading-none">
                                <i class="fa-solid fa-user-tie"></i>
                            </div>
                            <span class="text-gray-600 dark:text-gray-400 font-bold text-sm">{{ $course->teacher->name }}</span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center pt-6 border-t border-gray-100 dark:border-white/5 mt-auto">
                        <span class="text-2xl font-black text-emerald-600 dark:text-emerald-400">{{ number_format($course->price, 2) }} <span class="text-sm font-bold opacity-70">ج.م</span></span>
                        <a href="{{ route('course.show', $course->id) }}" class="px-6 py-3 rounded-xl bg-amber-500 hover:bg-amber-600 text-white dark:bg-sky-500 dark:hover:bg-sky-600 dark:text-white transition-all font-bold border border-amber-600/10 dark:border-transparent shadow-lg shadow-amber-500/20 dark:group-hover:shadow-sky-500/20">مشاهدة التفاصيل</a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-20 bg-gray-50 dark:bg-white/5 rounded-[3rem] border border-gray-100 dark:border-white/5 my-12 shadow-sm dark:shadow-none relative overflow-hidden max-w-2xl mx-auto z-10">
            <div class="w-32 h-32 mx-auto bg-white dark:bg-white/5 rounded-[2.5rem] flex items-center justify-center mb-6 shadow-sm border border-gray-100 dark:border-white/5 rotate-3 hover:rotate-0 transition-transform duration-300">
                <i class="fa-solid fa-chalkboard-user text-6xl text-gray-300 dark:text-gray-600"></i>
            </div>
            <h2 class="text-2xl font-black text-[var(--text-color)] dark:text-white mb-3 relative z-10">لا توجد كورسات</h2>
            <p class="text-gray-500 dark:text-gray-400 font-medium relative z-10 max-w-md mx-auto">هذا المعلم لم يقم بإضافة كورسات في هذه المادة بعد.</p>
        </div>
    @endif
</div>
@endsection
