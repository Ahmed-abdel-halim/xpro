@extends('layouts.dashboard')

@section('title', 'الشؤون المالية')
@section('page-title', 'الإيرادات والمدفوعات')

@section('content')
<div class="mb-10">
    <h1 class="text-3xl font-bold text-[var(--text-color)] dark:text-white mb-2">الإدارة المالية</h1>
    <p class="text-gray-500 font-medium">متابعة إيرادات المنصة، عمولات الإدارة، وحالة طلبات المدرسين.</p>
</div>

<!-- Financial Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="card-glass p-6 rounded-2xl border-r-4 border-sky-500">
        <div class="text-gray-500 text-sm font-medium mb-1">إجمالي المبيعات (عند المعلمين)</div>
        <div class="text-2xl font-black text-[var(--text-color)] dark:text-white">{{ number_format($stats['total_sales'], 2) }} ج.م</div>
    </div>
    <div class="card-glass p-6 rounded-2xl border-r-4 border-green-500">
        <div class="text-gray-500 text-sm font-medium mb-1">عمولة المنصة (المحصلة)</div>
        <div class="text-2xl font-black text-green-600 dark:text-green-400">{{ number_format($stats['total_commission_paid'], 2) }} ج.م</div>
    </div>
    <div class="card-glass p-6 rounded-2xl border-r-4 border-amber-500">
        <div class="text-gray-500 text-sm font-medium mb-1">عمولة المنصة (بانتظار التحصيل)</div>
        <div class="text-2xl font-black text-amber-600 dark:text-amber-400">{{ number_format($stats['total_commission_pending'], 2) }} ج.م</div>
    </div>
</div>

<!-- Teacher Settlements Table -->
<div class="card-glass rounded-3xl overflow-hidden border border-gray-100 dark:border-white/5 shadow-xl shadow-gray-200/40 dark:shadow-none mb-10">
    <div class="p-6 border-b border-gray-100 dark:border-white/5 bg-gray-50 dark:bg-white/5 flex justify-between items-center">
        <h3 class="font-bold text-[var(--text-color)] dark:text-white text-lg flex items-center">
            <i class="fa-solid fa-user-tie ml-3 text-amber-500 dark:text-sky-400"></i>
            تسويات حسابات المعلمين
        </h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-right text-sm">
            <thead>
                <tr class="bg-gray-50 dark:bg-white/5 text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-white/5">
                    <th class="p-4 font-bold text-base">المعلم</th>
                    <th class="p-4 font-bold text-base text-center">العمولة المستحقة</th>
                    <th class="p-4 font-bold text-base text-center">إجمالي العمولة المسددة</th>
                    <th class="p-4 font-bold text-base text-center">الحالة</th>
                    <th class="p-4 font-bold text-base text-center">العمليات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                @forelse($teachers as $teacher)
                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                    <td class="p-4">
                        <div class="font-bold text-[var(--text-color)] dark:text-white">{{ $teacher->name }}</div>
                        <div class="text-[10px] text-gray-400 font-bold mt-1">{{ $teacher->email }}</div>
                    </td>
                    <td class="p-4 text-center font-black text-amber-600 dark:text-amber-500">{{ number_format($teacher->pending_commission, 2) }} ج.م</td>
                    <td class="p-4 text-center font-bold text-gray-500">{{ number_format($teacher->paid_commission, 2) }} ج.م</td>
                    <td class="p-4 text-center">
                        @if($teacher->pending_commission > 0)
                            <span class="bg-amber-100 text-amber-600 dark:bg-amber-500/10 dark:text-amber-500 px-2.5 py-1 rounded-lg text-[10px] font-bold">بانتظار التحصيل</span>
                        @else
                            <span class="bg-green-100 text-green-600 dark:bg-green-500/10 dark:text-green-500 px-2.5 py-1 rounded-lg text-[10px] font-bold">مصفّر</span>
                        @endif
                    </td>
                    <td class="p-4 text-center">
                        @if($teacher->pending_commission > 0)
                            <form action="{{ route('admin.finance.settleTeacher', $teacher->id) }}" method="POST" onsubmit="return confirm('تأكيد استلام المبلغ وتصفير حساب المدرس؟')">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-sky-50 text-sky-600 hover:bg-sky-500 hover:text-white dark:bg-sky-500/10 dark:text-sky-400 dark:hover:bg-sky-500 dark:hover:text-white rounded-xl text-xs font-bold transition">تأكيد الاستلام</button>
                            </form>
                        @else
                            <i class="fa-solid fa-circle-check text-green-500 text-lg"></i>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-10 text-center text-gray-500">لا يوجد معلمون في النظام.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Recent Payments Table -->
<div class="card-glass rounded-3xl overflow-hidden border border-gray-100 dark:border-white/5 shadow-xl shadow-gray-200/40 dark:shadow-none">
    <div class="p-6 border-b border-gray-100 dark:border-white/5 bg-gray-50 dark:bg-white/5">
        <h3 class="font-bold text-[var(--text-color)] dark:text-white text-lg">سجل العمليات المالية (آخر 50 عملية مؤكدة)</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-right text-sm">
            <thead>
                <tr class="bg-gray-50 dark:bg-white/5 text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-white/5">
                    <th class="p-4 font-bold">الطالب / المعلم</th>
                    <th class="p-4 font-bold text-center">الكورس</th>
                    <th class="p-4 font-bold text-center">المبلغ</th>
                    <th class="p-4 font-bold text-center">عمولة المنصة</th>
                    <th class="p-4 font-bold text-center">تاريخ التأكيد</th>
                    <th class="p-4 font-bold text-center">الحالة</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                @forelse($recentPayments as $payment)
                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                    <td class="p-4">
                        <div class="font-bold text-[var(--text-color)] dark:text-white">ط: {{ $payment->student->name }}</div>
                        <div class="text-[10px] text-sky-500 font-bold mt-1">م: {{ $payment->teacher->name }}</div>
                    </td>
                    <td class="p-4 text-center text-gray-500 dark:text-gray-400 font-medium">{{ $payment->course->title }}</td>
                    <td class="p-4 text-center font-bold text-[var(--text-color)] dark:text-white">{{ number_format($payment->amount, 2) }} ج.م</td>
                    <td class="p-4 text-center font-bold text-amber-600 dark:text-amber-500">
                        {{ number_format($payment->commission_amount > 0 ? $payment->commission_amount : ($payment->amount * $payment->teacher->getPlatformRate()), 2) }} ج.م
                    </td>
                    <td class="p-4 text-center text-gray-400 text-[10px] font-bold">
                        {{ $payment->confirmed_at ? $payment->confirmed_at->format('Y/m/d H:i') : $payment->created_at->format('Y/m/d H:i') }}
                    </td>
                    <td class="p-4 text-center">
                        @if($payment->is_commission_paid)
                            <span class="text-green-600 bg-green-50 dark:bg-green-500/10 px-2 py-1 rounded-lg text-[10px] font-bold">تم تحصيلها</span>
                        @else
                            <span class="text-amber-600 bg-amber-50 dark:bg-amber-500/10 px-2 py-1 rounded-lg text-[10px] font-bold">بانتظار التحصيل</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-10 text-center text-gray-500">لا توجد عمليات مالية حالياً.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
