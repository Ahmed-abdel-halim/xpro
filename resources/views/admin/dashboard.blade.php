@extends('layouts.dashboard')

@section('title', 'إحصائيات النظام')
@section('page-title', 'نظرة عامة على النظام')

@section('content')
<!-- Welcome Header -->
<div class="mb-10">
    <h1 class="text-3xl font-bold text-[var(--text-color)] dark:text-white mb-2">مرحباً بك مجدداً، {{ explode(' ', auth()->user()->name)[0] }} 👋</h1>
    <p class="text-gray-500 font-medium">إليك آخر تحديثات المنصة والنشاط المالي لهذا اليوم.</p>
</div>

<!-- Stats Horizontal Scroll/Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <div class="card-glass p-6 rounded-2xl border-r-4 border-blue-500">
        <div class="text-gray-500 text-[10px] font-bold mb-1 uppercase tracking-wider">إجمالي المبيعات (عند المعلمين)</div>
        <div class="text-2xl font-black text-[var(--text-color)] dark:text-white">{{ number_format($stats['total_sales'], 2) }} ج.م</div>
    </div>

    <div class="card-glass p-6 rounded-2xl border-r-4 border-green-500">
        <div class="text-gray-500 text-[10px] font-bold mb-1 uppercase tracking-wider">عمولة المنصة (المحصلة)</div>
        <div class="text-2xl font-black text-green-600 dark:text-green-400">{{ number_format($stats['commission_paid'], 2) }} ج.م</div>
    </div>

    <div class="card-glass p-6 rounded-2xl border-r-4 border-amber-500">
        <div class="text-gray-500 text-[10px] font-bold mb-1 uppercase tracking-wider">عمولة المنصة (بانتظار التحصيل)</div>
        <div class="text-2xl font-black text-amber-600 dark:text-amber-400">{{ number_format($stats['commission_pending'], 2) }} ج.م</div>
    </div>

    <div class="card-glass p-6 rounded-2xl border-r-4 border-purple-500">
        <div class="text-gray-500 text-[10px] font-bold mb-1 uppercase tracking-wider">إجمالي الطلاب</div>
        <div class="text-2xl font-black text-[var(--text-color)] dark:text-white">{{ number_format($stats['total_students']) }}</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Financial Overview Table -->
    <div class="lg:col-span-2 card-glass rounded-3xl overflow-hidden border border-gray-100 dark:border-white/5">
        <div class="p-6 border-b border-gray-100 dark:border-white/5 bg-gray-50 dark:bg-white/5 flex justify-between items-center">
            <h3 class="font-bold text-[var(--text-color)] dark:text-white text-lg">آخر المدفوعات المسجلة</h3>
            <a href="{{ route('admin.finance.index') }}" class="text-xs text-amber-500 hover:text-amber-600 dark:text-sky-400 font-bold transition">عرض الشؤون المالية</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-white/5 text-gray-500 dark:text-gray-400">
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent text-center">الطالب</th>
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent text-center">المعلم</th>
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent text-center">المبلغ</th>
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent text-center">الحالة</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse($recentPayments as $payment)
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                        <td class="p-4 font-bold text-[var(--text-color)] dark:text-white text-center">{{ $payment->student->name }}</td>
                        <td class="p-4 text-gray-500 dark:text-gray-400 font-medium text-center">{{ $payment->teacher->name }}</td>
                        <td class="p-4 font-bold text-[var(--text-color)] dark:text-white text-center">{{ number_format($payment->amount, 2) }} ج.م</td>
                        <td class="p-4 text-center">
                            @if($payment->status === 'confirmed')
                                <span class="bg-green-100 text-green-600 dark:bg-green-500/10 dark:text-green-500 px-2.5 py-1 rounded-lg text-[10px] font-bold">مؤكد</span>
                            @elseif($payment->status === 'pending')
                                <span class="bg-amber-100 text-amber-600 dark:bg-amber-500/10 dark:text-amber-500 px-2.5 py-1 rounded-lg text-[10px] font-bold">معلق</span>
                            @else
                                <span class="bg-red-100 text-red-600 dark:bg-red-500/10 dark:text-red-500 px-2.5 py-1 rounded-lg text-[10px] font-bold">{{ $payment->status }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-10 text-center text-gray-400 font-bold">لا توجد عمليات دفع حديثة.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions / Alerts -->
    <div class="lg:col-span-1 space-y-6">
        <div class="card-glass p-6 rounded-2xl bg-gradient-to-br from-indigo-50 dark:from-indigo-600/20 to-transparent">
            <h3 class="font-bold text-[var(--text-color)] dark:text-white mb-4 text-lg">تنبيهات المسؤول</h3>
            <div class="space-y-4">
                <div class="flex items-start p-3 bg-red-50 dark:bg-red-500/10 rounded-xl border border-red-100 dark:border-red-500/20 shadow-sm shadow-red-500/5">
                    <span class="ml-3 mt-1 text-red-500"><i class="fa-solid fa-triangle-exclamation"></i></span>
                    <div>
                        <div class="text-sm font-bold text-red-400">3 طلبات معلمين</div>
                        <p class="text-xs text-gray-500">هناك معلمين جدد بانتظار الموافقة على ملفاتهم.</p>
                    </div>
                </div>
                <div class="flex items-start p-3 bg-sky-50 dark:bg-blue-500/10 rounded-xl border border-sky-100 dark:border-blue-500/20 shadow-sm shadow-blue-500/5">
                    <span class="ml-3 mt-1 text-sky-600 dark:text-blue-500"><i class="fa-solid fa-credit-card"></i></span>
                    <div>
                        <div class="text-sm font-bold text-sky-700 dark:text-blue-400">تسويات مالية</div>
                        <p class="text-xs text-gray-500 font-medium mt-0.5">وقت صرف مستحقات المعلمين لنهاية الأسبوع.</p>
                    </div>
                </div>

                @if($stats['unread_messages'] > 0)
                <a href="{{ route('admin.messages.index') }}" class="flex items-start p-3 bg-amber-50 dark:bg-sky-500/10 rounded-xl border border-amber-100 dark:border-sky-500/20 hover:bg-amber-100 dark:hover:bg-sky-500/20 transition group shadow-sm">
                    <span class="ml-3 mt-1 text-amber-500 dark:text-sky-500"><i class="fa-solid fa-message"></i></span>
                    <div>
                        <div class="text-sm font-bold text-amber-600 dark:text-sky-400">{{ $stats['unread_messages'] }} رسائل جديدة</div>
                        <p class="text-xs text-gray-500 font-medium mt-0.5">لديك رسائل تواصل لم يتم قراءتها بعد.</p>
                    </div>
                </a>
                @endif

            </div>
        </div>

        <div class="card-glass p-6 rounded-2xl">
            <h3 class="font-bold text-[var(--text-color)] dark:text-white mb-4 text-lg">مخطط سريع</h3>
            <div class="h-32 flex items-end justify-between px-2">
                <div class="w-4 bg-amber-400 dark:bg-sky-500 h-[40%] rounded-t-lg shadow-[0_0_10px_rgba(251,191,36,0.5)] dark:shadow-[0_0_10px_rgba(14,165,233,0.3)]"></div>
                <div class="w-4 bg-amber-500 dark:bg-sky-400 h-[60%] rounded-t-lg shadow-[0_0_10px_rgba(245,158,11,0.5)] dark:shadow-[0_0_10px_rgba(56,189,248,0.3)]"></div>
                <div class="w-4 bg-amber-300 dark:bg-sky-600 h-[30%] rounded-t-lg shadow-[0_0_10px_rgba(252,211,77,0.5)] dark:shadow-[0_0_10px_rgba(2,132,199,0.3)]"></div>
                <div class="w-4 bg-amber-500 dark:bg-sky-400 h-[80%] rounded-t-lg shadow-[0_0_10px_rgba(245,158,11,0.5)] dark:shadow-[0_0_10px_rgba(56,189,248,0.3)]"></div>
                <div class="w-4 bg-amber-400 dark:bg-sky-500 h-[50%] rounded-t-lg shadow-[0_0_10px_rgba(251,191,36,0.5)] dark:shadow-[0_0_10px_rgba(14,165,233,0.3)]"></div>
                <div class="w-4 bg-amber-600 dark:bg-sky-300 h-[90%] rounded-t-lg shadow-[0_0_10px_rgba(217,119,6,0.5)] dark:shadow-[0_0_10px_rgba(125,211,252,0.3)]"></div>
            </div>
            <div class="flex justify-between text-[10px] text-gray-500 font-bold mt-2 pt-2 border-t border-gray-100 dark:border-white/5">
                <span>السبت</span><span>الأحد</span><span>الاثنين</span><span>الثلاثاء</span><span>الأربعاء</span><span>الخميس</span>
            </div>
        </div>
    </div>
</div>
@endsection
