@extends('layouts.dashboard')

@section('title', 'لوحة الطالب')
@section('page-title', 'كورساتي التعليمية')

@section('content')
<div class="mb-10">
    <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">مرحباً بك، {{ explode(' ', auth()->user()->name)[0] }} <i class="fa-solid fa-wand-magic-sparkles text-sky-400"></i></h1>

    <p class="text-gray-500">استكمل تعليمك من حيث توقفت اليوم.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @php
        $enrolledCourses = auth()->user()->enrolledCourses;
    @endphp

    @forelse($enrolledCourses as $course)
        <div class="card-glass rounded-3xl overflow-hidden group">
            <div class="h-40 bg-gradient-to-br from-sky-500/20 to-indigo-600/20 relative">
                @if($course->thumbnail)
                    <img src="{{ $course->thumbnail }}" class="w-full h-full object-cover opacity-60">
                @endif
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="text-4xl group-hover:scale-110 transition text-sky-400">
                        <i class="fa-solid fa-book-bookmark"></i>
                    </span>
                </div>

            </div>
            <div class="p-6">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2">{{ $course->title }}</h3>
                <p class="text-xs text-gray-400 mb-4 line-clamp-2">{{ $course->description }}</p>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] text-sky-400 font-bold px-2 py-1 bg-sky-500/10 rounded-lg">قيد التعليم</span>
                    <a href="{{ route('course.show', $course->id) }}" class="text-sm font-bold text-gray-700 dark:text-white hover:text-sky-500 dark:hover:text-sky-400 transition">دخول الكورس ←</a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full py-20 text-center">
            <div class="text-6xl mb-6 text-sky-600/40 dark:text-sky-500/50">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">لم تشترك في أي كورسات بعد</h2>
            <p class="text-gray-500 mb-8">ابدأ الآن بتصفح المواد واختيار كورس يناسبك.</p>
            <a href="{{ route('home') }}" class="px-8 py-3 bg-sky-500 hover:bg-sky-600 transition rounded-xl text-white font-bold shadow-lg shadow-sky-500/20">
                تصفح الكورسات الآن
            </a>
        </div>
    @endforelse
</div>

{{-- Latest Transactions Section --}}
<div class="mt-16">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">آخر المعاملات <i class="fa-solid fa-clock-rotate-left text-sky-400 text-sm"></i></h2>
        <a href="{{ route('payments.student') }}" class="text-sm font-bold text-sky-500 hover:text-sky-600 transition">عرض الكل</a>
    </div>

    <div class="card-glass rounded-3xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 dark:divide-white/5">
                <thead class="bg-gray-50/50 dark:bg-white/5">
                    <tr>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-widest">الكورس</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-widest">المبلغ</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-widest">الحالة</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-widest">التاريخ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse($latestPayments as $payment)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-800 dark:text-white">{{ $payment->course->title }}</div>
                                <div class="text-[10px] text-gray-400">{{ $payment->teacher->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-black text-gray-800 dark:text-white">{{ number_format($payment->amount, 2) }} جنيه</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($payment->status === 'pending')
                                    <span class="px-2 py-0.5 text-[9px] font-black rounded-lg bg-amber-500/10 text-amber-500 border border-amber-500/20">معلق</span>
                                @elseif($payment->status === 'confirmed')
                                    <span class="px-2 py-0.5 text-[9px] font-black rounded-lg bg-emerald-500/10 text-emerald-500 border border-emerald-500/20">مؤكد</span>
                                @else
                                    <span class="px-2 py-0.5 text-[9px] font-black rounded-lg bg-gray-500/10 text-gray-400">{{ $payment->status }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-[10px] text-gray-400 font-medium">
                                {{ $payment->payment_date ? $payment->payment_date->format('Y-m-d') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-sm text-gray-400 italic">لا توجد معاملات مالية مؤخراً</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
