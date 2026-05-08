@extends('layouts.dashboard')

@section('title', 'سجل الدفعات')
@section('page-title', 'سجل العمليات المالية')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">سجل الدفعات <i class="fa-solid fa-receipt text-sky-400"></i></h1>
        <p class="text-gray-500">تابع حالة طلبات الاشتراك في الكورسات ومدفوعاتك.</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="card-glass rounded-3xl p-6 border-l-4 border-l-amber-500 shadow-xl shadow-amber-500/5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-bold mb-1">دفعات معلقة</p>
                    <p class="text-3xl font-black text-gray-800 dark:text-white">{{ $payments->where('status', 'pending')->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-amber-500/10 rounded-2xl flex items-center justify-center text-amber-500">
                    <i class="fa-solid fa-hourglass-half text-2xl"></i>
                </div>
            </div>
        </div>
        
        <div class="card-glass rounded-3xl p-6 border-l-4 border-l-emerald-500 shadow-xl shadow-emerald-500/5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-bold mb-1">دفعات مؤكدة</p>
                    <p class="text-3xl font-black text-gray-800 dark:text-white">{{ $payments->where('status', 'confirmed')->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-500">
                    <i class="fa-solid fa-circle-check text-2xl"></i>
                </div>
            </div>
        </div>
        
        <div class="card-glass rounded-3xl p-6 border-l-4 border-l-sky-500 shadow-xl shadow-sky-500/5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-bold mb-1">إجمالي المدفوع</p>
                    <p class="text-3xl font-black text-gray-800 dark:text-white">{{ number_format($payments->where('status', 'confirmed')->sum('amount'), 2) }} <span class="text-sm">جنيه</span></p>
                </div>
                <div class="w-14 h-14 bg-sky-500/10 rounded-2xl flex items-center justify-center text-sky-500">
                    <i class="fa-solid fa-wallet text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="card-glass rounded-3xl overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 dark:divide-white/5">
                <thead class="bg-gray-50/50 dark:bg-white/5">
                    <tr>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">المدرس والكورس</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">المبلغ</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">طريقة الدفع</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">الحالة</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">التاريخ</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">الإجراء</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @foreach($payments as $payment)
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                        <td class="px-6 py-6">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-tr from-sky-400 to-indigo-500 rounded-xl flex items-center justify-center text-white font-bold shadow-lg">
                                    {{ substr($payment->teacher->name, 0, 1) }}
                                </div>
                                <div class="mr-4">
                                    <div class="text-sm font-bold text-gray-800 dark:text-white">{{ $payment->teacher->name }}</div>
                                    <div class="text-xs text-sky-500 font-bold">{{ $payment->course->title }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <div class="text-sm font-black text-gray-800 dark:text-white">{{ number_format($payment->amount, 2) }} جنيه</div>
                        </td>
                        <td class="px-6 py-6">
                            <div class="text-xs font-bold text-gray-500 dark:text-gray-400">
                                @if($payment->payment_method === 'wallet') محفظة إلكترونية
                                @elseif($payment->payment_method === 'instapay') إنستا باي
                                @else تحويل بنكي @endif
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            @if($payment->status === 'pending')
                                <span class="px-3 py-1 text-[10px] font-black rounded-lg bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400 border border-amber-200 dark:border-amber-500/20">
                                    معلق
                                </span>
                            @elseif($payment->status === 'confirmed')
                                <span class="px-3 py-1 text-[10px] font-black rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20">
                                    مؤكد
                                </span>
                            @else
                                <span class="px-3 py-1 text-[10px] font-black rounded-lg bg-gray-100 text-gray-700 dark:bg-gray-500/20 dark:text-gray-400">
                                    {{ $payment->status }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-6 text-xs text-gray-400">
                            {{ $payment->payment_date ? $payment->payment_date->format('Y-m-d') : '-' }}
                        </td>
                        <td class="px-6 py-6">
                            @if($payment->status === 'confirmed')
                                <a href="{{ route('course.show', $payment->course_id) }}" class="text-xs font-bold text-sky-500 hover:text-sky-600 transition underline underline-offset-4">
                                    دخول الكورس
                                </a>
                            @else
                                <span class="text-[10px] text-gray-400 italic">في انتظار التأكيد</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($payments->hasPages())
            <div class="px-6 py-4 bg-gray-50/50 dark:bg-white/5">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
