@extends('layouts.dashboard')

@section('title', 'إدارة الدفعات')
@section('page-title', 'الدفعات الواردة للشركة')

@section('content')
<div>
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-[var(--text-color)] dark:text-white mb-1">إدارة الدفعات</h1>
        <p class="text-gray-500">راجع التحويلات الواردة من الطلاب وفعّل الكورسات لهم.</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="card-glass p-5 rounded-2xl border-r-4 border-amber-500">
            <div class="text-xs text-gray-500 font-bold mb-1">انتظار التأكيد</div>
            <div class="text-2xl font-black text-amber-600 dark:text-amber-400">{{ $stats['pending_count'] }}</div>
            <div class="text-xs text-gray-400 mt-1">{{ number_format($stats['pending_amount'], 0) }} د.ع إجمالي</div>
        </div>
        <div class="card-glass p-5 rounded-2xl border-r-4 border-emerald-500">
            <div class="text-xs text-gray-500 font-bold mb-1">مؤكد اليوم</div>
            <div class="text-2xl font-black text-emerald-600 dark:text-emerald-400">{{ $stats['confirmed_today'] }}</div>
        </div>
        <div class="card-glass p-5 rounded-2xl border-r-4 border-sky-500">
            <div class="text-xs text-gray-500 font-bold mb-1">إجمالي الإيرادات</div>
            <div class="text-2xl font-black text-sky-600 dark:text-sky-400">{{ number_format($stats['total_revenue'], 0) }}</div>
            <div class="text-xs text-gray-400 mt-1">دينار عراقي</div>
        </div>
    </div>

    <!-- Pending Payments -->
    @if($pendingPayments->count() > 0)
    <div class="card-glass rounded-3xl overflow-hidden shadow-2xl mb-10">
        <div class="p-6 border-b border-gray-100 dark:border-white/5 bg-amber-50 dark:bg-amber-500/5 flex justify-between items-center">
            <h3 class="font-bold text-[var(--text-color)] dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-amber-500"></i>
                طلبات الدفع بانتظار تأكيدك
                <span class="bg-amber-500 text-white text-xs px-2 py-0.5 rounded-full font-black">{{ $pendingPayments->count() }}</span>
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-white/5 text-gray-500">
                        <th class="p-4 font-bold">الطالب</th>
                        <th class="p-4 font-bold">الكورس</th>
                        <th class="p-4 font-bold">المبلغ</th>
                        <th class="p-4 font-bold">وسيلة التحويل</th>
                        <th class="p-4 font-bold">إثبات الدفع</th>
                        <th class="p-4 font-bold text-center">الإجراء</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @foreach($pendingPayments as $payment)
                    <tr class="hover:bg-amber-50/50 dark:hover:bg-amber-500/5 transition">
                        <td class="p-4">
                            <div class="font-bold text-[var(--text-color)] dark:text-white">{{ $payment->student->name }}</div>
                            <div class="text-xs text-gray-400">{{ $payment->student->phone ?? $payment->student->email }}</div>
                        </td>
                        <td class="p-4">
                            <div class="font-bold text-[var(--text-color)] dark:text-white text-sm">{{ $payment->course->title }}</div>
                            <div class="text-xs text-gray-400">المدرس: {{ $payment->teacher?->name }}</div>
                        </td>
                        <td class="p-4">
                            <span class="font-black text-emerald-600 dark:text-emerald-400">{{ number_format($payment->amount, 2) }}</span>
                            <span class="text-xs text-gray-400 mr-1">د.ع</span>
                        </td>
                        <td class="p-4 text-gray-500 text-sm">
                            {{ $payment->payment_method }}
                            @if($payment->sender_number)
                                <div class="text-xs text-gray-400">من: {{ $payment->sender_number }}</div>
                            @endif
                        </td>
                        <td class="p-4">
                            @if($payment->proof_image)
                                <a href="{{ asset('storage/' . $payment->proof_image) }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-sky-500 hover:text-sky-600 font-bold">
                                    <i class="fa-solid fa-image"></i> عرض الإيصال
                                </a>
                            @else
                                <span class="text-xs text-gray-400">بدون إيصال</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <div class="flex gap-2 justify-center">
                                <form action="{{ route('admin.payments.confirm', $payment->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs rounded-xl transition shadow-lg shadow-emerald-500/20">
                                        <i class="fa-solid fa-check ml-1"></i> تأكيد وتفعيل
                                    </button>
                                </form>
                                <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST" data-confirm="هل تريد رفض هذه الدفعة؟">
                                    @csrf
                                    <button type="submit" class="px-3 py-2 bg-red-500/10 hover:bg-red-500/20 text-red-500 font-bold text-xs rounded-xl transition">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="p-8 text-center bg-emerald-500/5 border border-emerald-500/10 rounded-2xl mb-10">
        <i class="fa-solid fa-circle-check text-3xl text-emerald-500 mb-2"></i>
        <p class="text-emerald-600 dark:text-emerald-400 font-bold">ممتاز! لا توجد دفعات بانتظار التأكيد.</p>
    </div>
    @endif

    <!-- Confirmed Payments -->
    <div class="card-glass rounded-3xl overflow-hidden">
        <div class="p-6 border-b border-gray-100 dark:border-white/5 flex justify-between items-center">
            <h3 class="font-bold text-[var(--text-color)] dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-500"></i>
                الدفعات المؤكدة (آخر 50)
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-white/5 text-gray-500">
                        <th class="p-4 font-bold">الطالب</th>
                        <th class="p-4 font-bold">الكورس</th>
                        <th class="p-4 font-bold">المبلغ</th>
                        <th class="p-4 font-bold">حصة المدرس</th>
                        <th class="p-4 font-bold">تاريخ التأكيد</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse($confirmedPayments as $payment)
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                        <td class="p-4 font-bold text-[var(--text-color)] dark:text-white text-sm">{{ $payment->student->name }}</td>
                        <td class="p-4 text-gray-500 text-sm">{{ $payment->course->title }}</td>
                        <td class="p-4 font-black text-emerald-600 dark:text-emerald-400">{{ number_format($payment->amount, 2) }} <span class="text-xs font-bold text-gray-400">د.ع</span></td>
                        <td class="p-4 text-sky-600 dark:text-sky-400 font-bold text-sm">{{ number_format($payment->teacher_amount ?? 0, 2) }}</td>
                        <td class="p-4 text-gray-400 text-sm">{{ $payment->confirmed_at?->format('Y-m-d H:i') ?? '---' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="p-8 text-center text-gray-400 font-bold">لا توجد دفعات مؤكدة بعد.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
