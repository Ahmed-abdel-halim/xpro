@extends('layouts.app')

@section('title', 'دفع قيمة الكورس')

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white dark:bg-[#0f172a] p-8 rounded-3xl shadow-xl border border-gray-100 dark:border-white/10">
            <h1 class="text-3xl font-bold text-center text-[var(--text-color)] dark:text-white mb-8">إتمام عملية الدفع والتسجيل</h1>
            
            @if(isset($pendingPayment))
                <div class="mb-6 p-4 bg-amber-500/10 border border-amber-500/20 rounded-2xl flex items-center gap-4 text-amber-600 dark:text-amber-400">
                    <i class="fa-solid fa-circle-exclamation text-xl"></i>
                    <p class="text-sm font-bold">لديك عملية دفع سابقة بانتظار التأكيد لهذا الكورس. إذا كنت قد دفعت بالفعل، يرجى الانتظار قليلاً أو التواصل مع الدعم. يمكنك المحاولة مرة أخرى إذا فشلت العملية السابقة.</p>
                </div>
            @endif

            <div class="bg-gray-50 dark:bg-white/5 p-6 rounded-2xl mb-8 flex items-center space-x-6 space-x-reverse border border-gray-100 dark:border-white/5 shadow-md shadow-gray-200/40 dark:shadow-none transition">
                <img src="{{ $course->thumbnail ?? 'https://placehold.co/1200x675/0f172a/38bdf8?text=Course+Preview' }}" 
                     alt="{{ $course->title }}" class="w-32 h-20 object-cover rounded-xl shadow-lg shadow-amber-500/10 dark:shadow-sky-500/10">
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-[var(--text-color)] dark:text-white mb-1">{{ $course->title }}</h3>
                    <p class="text-gray-500 font-medium text-sm">المعلم: <span class="text-amber-600 dark:text-sky-400 font-bold">{{ $course->teacher->name }}</span></p>
                    <div class="text-2xl font-black text-amber-500 mt-2">{{ number_format($course->price, 2) }} ج.م</div>
                </div>
            </div>

            <h3 class="text-lg font-bold text-[var(--text-color)] dark:text-white mb-6 flex items-center">
                <i class="fa-solid fa-credit-card ml-3 text-amber-500 dark:text-sky-400"></i>
                اختر طريقة الدفع المناسبة لك
            </h3>

            <form action="{{ route('payment.process', $course->id) }}" method="POST" class="space-y-4">
                @csrf
                
                <label class="block cursor-pointer group">
                    <input type="radio" name="method" value="card" checked class="hidden peer">
                    <div class="p-6 rounded-2xl border-2 peer-checked:border-amber-500 dark:peer-checked:border-sky-500 border-gray-100 dark:border-white/5 bg-gray-50 dark:bg-white/5 group-hover:bg-gray-100 dark:group-hover:bg-white/10 transition flex items-center justify-between shadow-sm dark:shadow-none">
                        <div class="flex items-center space-x-4 space-x-reverse">
                            <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 dark:bg-sky-500/20 dark:text-sky-400 flex items-center justify-center text-xl font-bold">
                                <i class="fa-solid fa-credit-card"></i>
                            </div>
                            <div>
                                <div class="font-bold text-[var(--text-color)] dark:text-white">البطاقات البنكية</div>
                                <div class="text-xs text-gray-500 font-medium mt-1">فيزا، ماستر كارد، وميزة (Visa / Mastercard / Meeza)</div>
                            </div>
                        </div>
                        <i class="fa-solid fa-circle-check text-amber-500 dark:text-sky-500 opacity-0 peer-checked:opacity-100 transition text-2xl drop-shadow-sm"></i>
                    </div>
                </label>

                <label class="block cursor-pointer group">
                    <input type="radio" name="method" value="wallet" class="hidden peer">
                    <div class="p-6 rounded-2xl border-2 peer-checked:border-emerald-500 border-gray-100 dark:border-white/5 bg-gray-50 dark:bg-white/5 group-hover:bg-gray-100 dark:group-hover:bg-white/10 transition flex items-center justify-between shadow-sm dark:shadow-none">
                        <div class="flex items-center space-x-4 space-x-reverse">
                            <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400 flex items-center justify-center text-xl font-bold">
                                <i class="fa-solid fa-mobile-screen-button"></i>
                            </div>
                            <div>
                                <div class="font-bold text-[var(--text-color)] dark:text-white">المحافظ الإلكترونية</div>
                                <div class="text-xs text-gray-500 font-medium mt-1">فودافون كاش، اتصالات، وأورانج كاش (Vodafone / Orange / Etisalat)</div>
                            </div>
                        </div>
                        <i class="fa-solid fa-circle-check text-emerald-500 opacity-0 peer-checked:opacity-100 transition text-2xl drop-shadow-sm"></i>
                    </div>
                </label>

                <!-- Wallet Phone Input -->
                <div id="wallet-phone-container" class="hidden mt-4 p-4 bg-emerald-500/5 border border-emerald-500/10 rounded-2xl animate-in fade-in slide-in-from-top-2 duration-300">
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">رقم الهاتف المسجل عليه المحفظة</label>
                    <div class="relative">
                        <input type="text" name="wallet_phone" id="wallet_phone" placeholder="مثلاً: 01012345678" 
                               class="w-full px-5 py-4 rounded-xl border-2 border-gray-100 dark:border-white/5 bg-white dark:bg-white/5 text-[var(--text-color)] dark:text-white focus:border-emerald-500 outline-none transition font-bold"
                               value="{{ auth()->user()->phone }}">
                        <i class="fa-solid fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                    <p class="text-[11px] text-emerald-600 dark:text-emerald-400 mt-2 font-bold">
                        <i class="fa-solid fa-circle-info ml-1"></i>
                        يرجى كتابة رقم الهاتف الذي تريد الدفع من خلاله. ستقوم بالدفع عن طريق كود الخدمة أو الـ OTP الذي سيصلك.
                    </p>
                </div>

                <label class="block cursor-pointer group">
                    <input type="radio" name="method" value="kiosk" class="hidden peer">
                    <div class="p-6 rounded-2xl border-2 peer-checked:border-orange-500 border-gray-100 dark:border-white/5 bg-gray-50 dark:bg-white/5 group-hover:bg-gray-100 dark:group-hover:bg-white/10 transition flex items-center justify-between shadow-sm dark:shadow-none">
                        <div class="flex items-center space-x-4 space-x-reverse">
                            <div class="w-12 h-12 rounded-xl bg-orange-100 text-orange-600 dark:bg-orange-500/20 dark:text-orange-400 flex items-center justify-center text-xl font-bold">
                                <i class="fa-solid fa-shop"></i>
                            </div>
                            <div>
                                <div class="font-bold text-[var(--text-color)] dark:text-white">الدفع من خلال منافذ ميزة/أمان/مصاري</div>
                                <div class="text-xs text-gray-500 font-medium mt-1">احصل على كود مرجعي وادفع في أي كشك أو مكتب بريد (Ref Code)</div>
                            </div>
                        </div>
                        <i class="fa-solid fa-circle-check text-orange-500 opacity-0 peer-checked:opacity-100 transition text-2xl drop-shadow-sm"></i>
                    </div>
                </label>

                <div class="pt-8">
                    <button type="submit" class="w-full py-4 rounded-2xl bg-amber-500 hover:bg-amber-600 dark:bg-sky-500 dark:hover:bg-sky-600 transition text-white font-black text-xl shadow-lg shadow-amber-500/20 dark:shadow-sky-500/20 flex items-center justify-center space-x-3 space-x-reverse group hover:-translate-y-1">
                        <span>اشترك الآن</span>
                        <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
                    </button>
                    <p class="text-center text-gray-500 text-xs mt-4 font-bold">
                        بضغطك على الزر، سيتم تحويلك إلى صفحة الدفع الآمنة الخاصة بـ Paymob
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const methodInputs = document.querySelectorAll('input[name="method"]');
        const walletPhoneContainer = document.getElementById('wallet-phone-container');
        const walletPhoneInput = document.getElementById('wallet_phone');

        function toggleWalletPhone() {
            const selectedMethod = document.querySelector('input[name="method"]:checked').value;
            if (selectedMethod === 'wallet') {
                walletPhoneContainer.classList.remove('hidden');
                walletPhoneInput.setAttribute('required', 'required');
            } else {
                walletPhoneContainer.classList.add('hidden');
                walletPhoneInput.removeAttribute('required');
            }
        }

        methodInputs.forEach(input => {
            input.addEventListener('change', toggleWalletPhone);
        });

        // Initialize on load
        toggleWalletPhone();
    });
</script>
@endpush
@endsection
