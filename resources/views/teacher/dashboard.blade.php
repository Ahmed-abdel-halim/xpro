@extends('layouts.dashboard')

@section('title', 'لوحة المعلم')
@section('page-title', 'نظرة عامة على أعمالي')

@section('content')
<!-- Welcome Header -->
<div class="mb-10 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-[var(--text-color)] dark:text-white mb-2">أهلاً بك يا أستاذ/ {{ explode(' ', auth()->user()->name)[0] }} <i class="fa-solid fa-chalkboard-user text-amber-500 dark:text-sky-400"></i></h1>
        <p class="text-gray-500 font-medium">إليك ملخص أداء كورساتك وطلابك اليوم.</p>
    </div>
    <div class="flex space-x-4 space-x-reverse">
        <a href="{{ route('teacher.courses.create') }}" class="px-6 py-3 bg-amber-500 hover:bg-amber-600 dark:bg-sky-500 dark:hover:bg-sky-600 transition rounded-xl text-white font-bold text-sm shadow-lg shadow-amber-500/20 dark:shadow-sky-500/20 flex items-center">
            <i class="fa-solid fa-plus ml-2"></i>
            رفع كورس جديد
        </a>
    </div>
</div>

<!-- Teacher Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <div class="card-glass p-6 rounded-2xl border-r-4 border-sky-500">
        <div class="text-gray-500 text-[10px] font-bold mb-1 uppercase tracking-wider">إجمالي الطلاب</div>
        <div class="text-2xl font-black text-[var(--text-color)] dark:text-white">{{ number_format($stats['total_students']) }}</div>
    </div>

    <div class="card-glass p-6 rounded-2xl border-r-4 border-green-500">
        <div class="text-gray-500 text-[10px] font-bold mb-1 uppercase tracking-wider">صافي أرباحك</div>
        <div class="text-2xl font-black text-green-600 dark:text-green-400">{{ number_format($stats['total_revenue'], 2) }} ج.م</div>
    </div>

    <div class="card-glass p-6 rounded-2xl border-r-4 border-amber-500">
        <div class="text-gray-500 text-[10px] font-bold mb-1 uppercase tracking-wider">نسبة المنصة (مستحقة)</div>
        <div class="text-2xl font-black text-amber-600 dark:text-amber-400">{{ number_format($stats['pending_commission'], 2) }} ج.م</div>
    </div>

    <div class="card-glass p-6 rounded-2xl border-r-4 border-purple-500">
        <div class="text-gray-500 text-[10px] font-bold mb-1 uppercase tracking-wider">كورساتي المرفوعة</div>
        <div class="text-2xl font-black text-[var(--text-color)] dark:text-white">{{ $stats['total_courses'] }}</div>
    </div>
</div>

<!-- Bottom Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Quick Actions -->
    <div class="card-glass p-8 rounded-3xl border border-gray-100 dark:border-white/5">
        <h3 class="text-xl font-bold text-[var(--text-color)] dark:text-white mb-6">إجراءات سريعة</h3>
        <div class="grid grid-cols-2 gap-4">
            <a href="{{ route('teacher.courses.create') }}" class="p-6 bg-gray-50 dark:bg-white/5 rounded-2xl border border-gray-100 dark:border-white/5 hover:border-amber-500/50 dark:hover:border-sky-500/50 hover:bg-amber-50 dark:hover:bg-sky-500/5 transition group text-center block shadow-sm">
                <div class="w-12 h-12 bg-amber-100 text-amber-600 dark:bg-sky-500/20 rounded-xl flex items-center justify-center dark:text-sky-400 group-hover:bg-amber-500 dark:group-hover:bg-white/20 group-hover:text-white mx-auto mb-4 transition-colors">
                    <i class="fa-solid fa-plus text-xl"></i>
                </div>
                <span class="text-[var(--text-color)] dark:text-white font-bold block transition-colors">إضافة كورس</span>
            </a>
            <a href="{{ route('teacher.courses.index') }}" class="p-6 bg-gray-50 dark:bg-white/5 rounded-2xl border border-gray-100 dark:border-white/5 hover:border-purple-500/50 hover:bg-purple-50 dark:hover:bg-purple-500/5 transition group text-center block shadow-sm">
                <div class="w-12 h-12 bg-purple-100 text-purple-600 dark:bg-purple-500/20 rounded-xl flex items-center justify-center dark:text-purple-400 group-hover:bg-purple-500 dark:group-hover:bg-white/20 group-hover:text-white mx-auto mb-4 transition-colors">
                    <i class="fa-solid fa-video text-xl"></i>
                </div>
                <span class="text-[var(--text-color)] dark:text-white font-bold block transition-colors">إدارة الدروس</span>
            </a>
        </div>
    </div>

    <!-- Student Activity -->
    <div class="card-glass p-8 rounded-3xl border border-gray-100 dark:border-white/5">
        <h3 class="text-xl font-bold text-[var(--text-color)] dark:text-white mb-6">آخر الطلاب المنضمين</h3>
        <div class="space-y-4">
            @forelse($recentEnrollments as $enrollment)
            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-white/5 rounded-2xl border border-gray-100 dark:border-white/5 shadow-sm">
                <div class="flex items-center space-x-4 space-x-reverse">
                    <div class="w-10 h-10 bg-amber-100 text-amber-600 dark:bg-sky-500/20 rounded-full flex items-center justify-center dark:text-sky-400">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <div>
                        <div class="font-bold text-[var(--text-color)] dark:text-white">{{ $enrollment->student->name }}</div>
                        <div class="text-[10px] text-gray-500 dark:text-gray-400 font-bold mt-1">اشترك في: {{ $enrollment->course->title }}</div>
                    </div>
                </div>
                <span class="text-[10px] text-gray-500 font-bold bg-white dark:bg-black/20 px-2 py-1 rounded-lg border border-gray-100 dark:border-white/5">{{ $enrollment->created_at ? $enrollment->created_at->diffForHumans() : 'غير محدد' }}</span>
            </div>
            @empty
            <div class="flex flex-col items-center justify-center py-10 text-gray-500 dark:text-gray-600">
                <i class="fa-solid fa-users-slash text-4xl mb-4"></i>
                <p class="text-sm font-bold">لا يوجد طلاب مشتركين حالياً.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
