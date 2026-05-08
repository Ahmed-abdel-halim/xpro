@extends('layouts.dashboard')

@section('title', 'طلبات سحب الأرباح')
@section('page-title', 'إدارة دفع مستحقات المعلمين')

@section('content')
<div class="mb-10">
    <h1 class="text-3xl font-bold text-[var(--text-color)] dark:text-white mb-2">طلبات سحب الأرباح</h1>
    <p class="text-gray-500 font-medium">مراجعة والتحقق من طلبات المعلمين لتحويل أرباحهم عبر فودافون كاش أو إنستا باي.</p>
</div>

<div class="card-glass rounded-2xl overflow-hidden">
    <div class="p-6 border-b border-gray-100 dark:border-white/5 flex items-center justify-between">
        <h3 class="font-bold text-[var(--text-color)] dark:text-white text-lg">طلبات السحب الواردة</h3>
        <div class="flex space-x-2 space-x-reverse">
            <span class="px-3 py-1 bg-amber-50 text-amber-600 dark:bg-yellow-500/10 dark:text-yellow-500 text-xs rounded-full font-bold">معلقة: {{ $withdrawals->where('status', 'pending')->count() }}</span>
            <span class="px-3 py-1 bg-green-50 text-green-600 dark:bg-green-500/10 dark:text-green-500 text-xs rounded-full font-bold">مكتملة: {{ $withdrawals->where('status', 'completed')->count() }}</span>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-right text-sm">
            <thead>
                <tr class="bg-gray-50 dark:bg-white/5 text-gray-500">
                    <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent">المعلم</th>
                    <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent text-center">المبلغ</th>
                    <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent text-center">طريقة التحويل</th>
                    <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent text-center">بيانات الحساب</th>
                    <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent text-center">الحالة</th>
                    <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent text-center">العمليات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                @forelse($withdrawals as $withdrawal)
                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                    <td class="p-4">
                        <div class="font-bold text-[var(--text-color)] dark:text-white">{{ $withdrawal->teacher->name }}</div>
                        <div class="text-[10px] text-gray-400 font-bold mt-1">{{ $withdrawal->created_at->format('Y/m/d H:i') }}</div>
                    </td>
                    <td class="p-4 text-center">
                        <span class="text-lg font-black text-emerald-500 dark:text-emerald-400">{{ number_format($withdrawal->amount, 2) }}</span>
                        <span class="text-[10px] text-gray-500 dark:text-gray-400 font-bold">ج.م</span>
                    </td>
                    <td class="p-4 text-center">
                        @if($withdrawal->payout_method == 'vodafone_cash')
                            <span class="px-2 py-1 bg-red-50 text-red-600 dark:bg-red-500/10 dark:text-red-500 rounded-lg text-xs font-bold">فودافون كاش</span>
                        @else
                            <span class="px-2 py-1 bg-sky-50 text-sky-600 dark:bg-sky-500/10 dark:text-sky-500 rounded-lg text-xs font-bold">إنستا باي</span>
                        @endif
                    </td>
                    <td class="p-4 text-center font-mono text-[var(--text-color)] dark:text-white font-bold">
                        {{ $withdrawal->payout_details }}
                    </td>
                    <td class="p-4 text-center">
                        @if($withdrawal->status == 'pending')
                            <span class="text-amber-600 dark:text-yellow-500 bg-amber-50 dark:bg-yellow-500/10 px-2 py-1 rounded-lg text-[10px] font-bold">بانتظار التحويل</span>
                        @elseif($withdrawal->status == 'completed')
                            <span class="text-green-600 dark:text-green-500 bg-green-50 dark:bg-green-500/10 px-2 py-1 rounded-lg text-[10px] font-bold">تم التحويل</span>
                        @else
                            <span class="text-red-600 dark:text-red-500 bg-red-50 dark:bg-red-500/10 px-2 py-1 rounded-lg text-[10px] font-bold">مرفوضة</span>
                        @endif
                    </td>
                    <td class="p-4 text-center">
                        @if($withdrawal->status == 'pending')
                            <div class="flex items-center justify-center space-x-2 space-x-reverse">
                                <form action="{{ route('admin.withdrawals.approve', $withdrawal->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد أنك قمت بتحويل المبلغ بالفعل؟')">
                                    @csrf
                                    <button class="px-3 py-1 bg-green-500 hover:bg-green-600 rounded-lg text-white text-xs transition">تم الدفع</button>
                                </form>
                                <button onclick="rejectWithdrawal({{ $withdrawal->id }})" class="px-3 py-1 border border-red-500/50 text-red-500 hover:bg-red-500/10 rounded-lg text-xs transition">رفض</button>
                            </div>
                        @else
                            <span class="text-gray-600 text-xs italic">تمت المعالجة</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-10 text-center text-gray-500">لا توجد طلبات سحب حالياً.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Reject Modal (Optional/Simplified with raw JS prompt if needed, but let's keep it simple) -->
<script>
function rejectWithdrawal(id) {
    const note = prompt('سبب الرفض (اختياري):');
    if (note !== null) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/withdrawals/${id}/reject`;
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);
        
        const noteInput = document.createElement('input');
        noteInput.type = 'hidden';
        noteInput.name = 'admin_note';
        noteInput.value = note;
        form.appendChild(noteInput);
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
