@extends('layouts.dashboard')

@section('title', 'إدارة الدفعات')
@section('page-title', 'طلبات تفعيل الكورسات')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">إدارة طلبات الالتحاق <i class="fa-solid fa-shield-check text-sky-400"></i></h1>
        <p class="text-gray-500">راجع التحويلات البنكية والمحافظ الإلكترونية لتفعيل الكورسات للطلاب.</p>
    </div>
    
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="card-glass rounded-3xl p-6 border-l-4 border-l-amber-500 shadow-xl shadow-amber-500/5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-bold mb-1">طلبات معلقة</p>
                    <p class="text-3xl font-black text-gray-800 dark:text-white">{{ $payments->where('status', 'pending')->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-amber-500/10 rounded-2xl flex items-center justify-center text-amber-500">
                    <i class="fa-solid fa-clock-rotate-left text-2xl"></i>
                </div>
            </div>
        </div>
        
        <div class="card-glass rounded-3xl p-6 border-l-4 border-l-emerald-500 shadow-xl shadow-emerald-500/5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-bold mb-1">تم تفعيلهم</p>
                    <p class="text-3xl font-black text-gray-800 dark:text-white">{{ $payments->where('status', 'confirmed')->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-500">
                    <i class="fa-solid fa-user-check text-2xl"></i>
                </div>
            </div>
        </div>
        
        <div class="card-glass rounded-3xl p-6 border-l-4 border-l-sky-500 shadow-xl shadow-sky-500/5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-bold mb-1">إجمالي الإيرادات</p>
                    <p class="text-3xl font-black text-gray-800 dark:text-white">{{ number_format($payments->where('status', 'confirmed')->sum('amount'), 2) }} <span class="text-sm font-bold">ج.م</span></p>
                </div>
                <div class="w-14 h-14 bg-sky-500/10 rounded-2xl flex items-center justify-center text-sky-500">
                    <i class="fa-solid fa-money-bill-trend-up text-2xl"></i>
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
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-widest">الطالب</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-widest">الكورس</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-widest">التفاصيل المالية</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-widest">الإثبات</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-widest">الإجراء</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @foreach($payments as $payment)
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                        <td class="px-6 py-6">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-tr from-amber-400 to-orange-500 rounded-xl flex items-center justify-center text-white font-black shadow-lg shadow-orange-500/20">
                                    {{ substr($payment->student->name, 0, 1) }}
                                </div>
                                <div class="mr-4">
                                    <div class="text-sm font-bold text-gray-800 dark:text-white">{{ $payment->student->name }}</div>
                                    <div class="text-[10px] text-gray-500 font-medium italic">{{ $payment->student->phone ?? $payment->student->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <div class="text-sm font-bold text-gray-800 dark:text-white">{{ $payment->course->title }}</div>
                            <div class="text-xs font-black text-sky-500 mt-1">{{ number_format($payment->amount, 2) }} جنيه</div>
                        </td>
                        <td class="px-6 py-6">
                            <div class="text-xs font-bold text-gray-600 dark:text-gray-300">
                                @if($payment->payment_method === 'wallet') <i class="fa-solid fa-mobile-screen-button ml-1"></i> محفظة
                                @elseif($payment->payment_method === 'instapay') <i class="fa-solid fa-bolt ml-1"></i> إنستا باي
                                @else <i class="fa-solid fa-building-columns ml-1"></i> تحويل بنكي @endif
                            </div>
                            <div class="text-[10px] text-gray-400 mt-1">
                                من: <span class="font-black text-gray-500 dark:text-gray-300">{{ $payment->sender_number ?? '---' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            @if($payment->proof_image)
                                <button onclick="viewProof('{{ asset('storage/' . $payment->proof_image) }}')" class="group relative block">
                                    <img src="{{ asset('storage/' . $payment->proof_image) }}" class="w-12 h-12 object-cover rounded-xl border-2 border-white/10 group-hover:border-sky-500 transition-all shadow-lg">
                                    <div class="absolute inset-0 bg-black/40 rounded-xl opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                                        <i class="fa-solid fa-magnifying-glass-plus text-white text-[10px]"></i>
                                    </div>
                                </button>
                            @else
                                <span class="text-[10px] text-gray-400 italic">بدون إرفاق</span>
                            @endif
                        </td>
                        <td class="px-6 py-6 text-left">
                            @if($payment->status === 'pending')
                                <button onclick="confirmPayment({{ $payment->id }})" class="bg-emerald-500 hover:bg-emerald-600 text-white text-[10px] font-black py-2 px-4 rounded-xl shadow-lg shadow-emerald-500/20 transition-all transform hover:-translate-y-0.5">
                                    تفعيل الكورس
                                </button>
                            @else
                                <div class="flex items-center text-emerald-500 font-black text-[10px] bg-emerald-500/10 px-3 py-1.5 rounded-lg border border-emerald-500/20">
                                    <i class="fa-solid fa-circle-check ml-1.5"></i>
                                    تم التفعيل
                                </div>
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

<!-- Proof Image Modal (Glassmorphism) -->
<div id="proof-modal" class="fixed inset-0 z-[100] hidden bg-black/80 backdrop-blur-xl flex items-center justify-center p-4 transition-all duration-300 opacity-0" onclick="closeProof()">
    <div class="relative max-w-2xl w-full h-full flex flex-col items-center justify-center scale-90 transition-transform duration-300" id="modal-container" @click.stop>
        <button class="absolute -top-12 right-0 text-white text-3xl hover:text-red-500 transition-colors" onclick="closeProof()"><i class="fa-solid fa-circle-xmark"></i></button>
        <div class="bg-white/5 p-2 rounded-3xl border border-white/10 shadow-2xl overflow-hidden">
            <img id="modal-img" src="" class="max-h-[80vh] w-full object-contain rounded-2xl">
        </div>
        <div class="mt-6 text-white font-black bg-white/10 px-6 py-3 rounded-2xl border border-white/10 backdrop-blur-xl flex items-center">
            <i class="fa-solid fa-image ml-2 text-sky-400"></i>
            صورة إثبات الدفع
        </div>
    </div>
</div>

<form id="confirm-form" method="POST" action="{{ route('payment.confirm', ':id') }}" style="display: none;">
    @csrf
</form>

<script>
function viewProof(url) {
    const modal = document.getElementById('proof-modal');
    const container = document.getElementById('modal-container');
    const img = document.getElementById('modal-img');
    img.src = url;
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.add('opacity-100');
        container.classList.remove('scale-90');
        container.classList.add('scale-100');
    }, 10);
    document.body.style.overflow = 'hidden';
}

function closeProof() {
    const modal = document.getElementById('proof-modal');
    const container = document.getElementById('modal-container');
    modal.classList.remove('opacity-100');
    container.classList.remove('scale-100');
    container.classList.add('scale-90');
    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }, 300);
}

function confirmPayment(paymentId) {
    window.confirmAction('هل تحققت من وصول المبلغ وتريد تفعيل الكورس لهذا الطالب؟', () => {
        const form = document.getElementById('confirm-form');
        form.action = form.action.replace(':id', paymentId);
        form.submit();
    }, 'تأكيد تفعيل الكورس', 'info');
}
</script>
@endsection

