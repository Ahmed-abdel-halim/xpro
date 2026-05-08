@extends('layouts.dashboard')

@section('title', 'الأرباح والعمولات')
@section('page-title', 'الملخص المالي')

@section('content')
<div class="mb-10">
    <h1 class="text-3xl font-bold text-[var(--text-color)] dark:text-white mb-2">أرباحي وعمولاتي</h1>
    <p class="text-gray-500 font-medium">متابعة دقيقة لمبيعات كورساتك وصافي أرباحك بعد خصم عمولة المنصة.</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="card-glass p-6 rounded-2xl border-r-4 border-sky-500">
        <div class="text-gray-500 text-sm font-medium mb-1">إجمالي المبيعات (المستلمة)</div>
        <div class="text-2xl font-black text-[var(--text-color)] dark:text-white">{{ number_format($grossRevenue, 2) }} ج.م</div>
    </div>
    
    <div class="card-glass p-6 rounded-2xl border-r-4 border-green-500">
        <div class="text-gray-500 text-sm font-medium mb-1">صافي أرباحك</div>
        <div class="text-2xl font-black text-green-600 dark:text-green-400">{{ number_format($netEarnings, 2) }} ج.م</div>
    </div>

    <div class="card-glass p-6 rounded-2xl border-r-4 border-amber-500">
        <div class="text-gray-500 text-sm font-medium mb-1">عمولة المنصة (بانتظار التسوية)</div>
        <div class="text-2xl font-black text-amber-600 dark:text-amber-400">{{ number_format($pendingCommission, 2) }} ج.م</div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
    <div class="card-glass p-6 rounded-2xl border-r-4 border-purple-500">
        <div class="text-gray-500 text-sm font-medium mb-1">إجمالي العمولة المدفوعة للمنصة</div>
        <div class="text-2xl font-black text-purple-600 dark:text-purple-400">{{ number_format($paidCommission, 2) }} ج.م</div>
    </div>
    <div class="card-glass p-6 rounded-2xl border-r-4 border-sky-500">
        <div class="text-gray-500 text-sm font-medium mb-1">إجمالي الطلاب المشتركين</div>
        <div class="text-2xl font-black text-sky-600 dark:text-sky-400">{{ number_format($totalStudents) }} طالب</div>
    </div>
</div>

<!-- Detailed Table -->
<div class="card-glass rounded-3xl overflow-hidden border border-gray-100 dark:border-white/5 shadow-xl shadow-gray-200/40 dark:shadow-none mb-10">
    <div class="p-6 border-b border-gray-100 dark:border-white/5 bg-gray-50 dark:bg-white/5">
        <h3 class="font-bold text-[var(--text-color)] dark:text-white text-lg flex items-center">
            <i class="fa-solid fa-chart-simple ml-2 text-amber-500 dark:text-sky-400"></i>
            أداء المبيعات لكل كورس
        </h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-right text-sm">
            <thead>
                <tr class="bg-gray-50 dark:bg-white/5 text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-white/5">
                    <th class="p-4 font-bold text-base">اسم الكورس</th>
                    <th class="p-4 font-bold text-base text-center">عدد الطلاب</th>
                    <th class="p-4 font-bold text-base text-center">سعر الكورس</th>
                    <th class="p-4 font-bold text-base text-center">إجمالي المبيعات</th>
                    <th class="p-4 font-bold text-base text-center">صافي ربحك</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                @forelse($courses as $course)
                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition group">
                    <td class="p-4 font-bold text-[var(--text-color)] dark:text-white group-hover:text-amber-600 dark:group-hover:text-sky-400 transition-colors">{{ $course->title }}</td>
                    <td class="p-4 text-center">
                        <span class="bg-amber-100 text-amber-600 dark:bg-sky-500/10 dark:text-sky-400 px-3 py-1.5 rounded-lg font-bold text-xs inline-flex items-center">
                            <i class="fa-solid fa-users ml-1.5 opacity-70"></i>
                            {{ $course->payments_count }} طالب مؤكد
                        </span>
                    </td>
                    <td class="p-4 text-center text-gray-600 dark:text-gray-300 font-medium">{{ number_format($course->price, 2) }} ج.م</td>
                    <td class="p-4 text-center font-bold text-[var(--text-color)] dark:text-white">{{ number_format($course->total_sales, 2) }} ج.م</td>
                    <td class="p-4 text-center text-emerald-600 dark:text-emerald-400 font-bold bg-emerald-50/50 dark:bg-emerald-500/5">
                        {{ number_format($course->teacher_profit, 2) }} ج.م
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-10 text-center text-gray-500 font-bold">
                        <i class="fa-solid fa-chart-line block text-4xl mb-4 text-gray-300 dark:text-gray-700"></i>
                        لا توجد مبيعات متاحة حالياً.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Settlement Section -->
    <div class="card-glass p-8 rounded-3xl border border-gray-100 dark:border-white/5 border-t-8 border-t-amber-500 dark:border-t-sky-500 shadow-xl shadow-gray-200/40 dark:shadow-none">
        <div class="mb-6">
            <h3 class="font-bold text-[var(--text-color)] dark:text-white text-lg flex items-center">
                <i class="fa-solid fa-hand-holding-dollar ml-3 text-amber-500 dark:text-sky-400"></i>
                تسوية مستحقات المنصة
            </h3>
            <p class="text-sm text-gray-500 mt-2">بعد تحويل عمولة المنصة للأدمن، يمكنك تصفير حسابك هنا لبدء فترة محاسبية جديدة.</p>
        </div>

        <div class="bg-amber-50 dark:bg-amber-500/5 p-6 rounded-2xl border border-amber-100 dark:border-amber-500/10 mb-8 text-center">
            <div class="text-amber-800 dark:text-amber-400 text-sm font-bold mb-1">المبلغ المستحق للمنصة حالياً</div>
            <div class="text-4xl font-black text-amber-600 dark:text-amber-500">{{ number_format($pendingCommission, 2) }} <span class="text-lg">ج.م</span></div>
        </div>

        @if($pendingCommission > 0)
            <form action="{{ route('teacher.earnings.settle') }}" method="POST" onsubmit="return confirm('هل أنت متأكد أنك قمت بدفع العمولة وتريد تصفير الحساب؟')">
                @csrf
                <button type="submit" class="w-full py-4 bg-amber-500 hover:bg-amber-600 dark:bg-sky-500 dark:hover:bg-sky-600 rounded-2xl font-black text-white shadow-lg shadow-amber-500/20 dark:shadow-sky-500/20 transition flex items-center justify-center space-x-3 space-x-reverse group">
                    <i class="fa-solid fa-check-double text-xl"></i>
                    <span>تصفير عمولة المنصة الآن</span>
                </button>
            </form>
        @else
            <div class="p-6 bg-green-50 dark:bg-green-500/10 border border-green-200 dark:border-green-500/20 rounded-2xl text-green-600 dark:text-green-400 text-center">
                <i class="fa-solid fa-circle-check mb-2 text-3xl"></i>
                <p class="font-bold text-sm">حسابك مع المنصة مصفّر حالياً.</p>
            </div>
        @endif
    </div>

    <!-- Info Section -->
    <div class="card-glass p-8 rounded-3xl border border-gray-100 dark:border-white/5 shadow-xl shadow-gray-200/40 dark:shadow-none flex flex-col justify-center">
        <h3 class="font-bold text-[var(--text-color)] dark:text-white text-lg mb-4">ملاحظات هامة:</h3>
        <ul class="space-y-4 text-gray-600 dark:text-gray-400 text-sm">
            <li class="flex items-start">
                <i class="fa-solid fa-circle-info ml-3 mt-1 text-sky-500"></i>
                <span>الأرباح تظهر فقط للطلاب الذين قام المدرس بتأكيد دفعهم يدوياً.</span>
            </li>
            <li class="flex items-start">
                <i class="fa-solid fa-circle-info ml-3 mt-1 text-sky-500"></i>
                <span>المدرس يستلم ثمن الكورس كاملاً من الطالب مباشرة (كاش، فودافون كاش، إلخ).</span>
            </li>
            <li class="flex items-start">
                <i class="fa-solid fa-circle-info ml-3 mt-1 text-sky-500"></i>
                <span>يجب تحويل "عمولة المنصة" للأدمن بشكل دوري للحفاظ على نشاط الحساب.</span>
            </li>
        </ul>
    </div>
</div>
@endsection
