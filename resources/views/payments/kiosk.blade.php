@extends('layouts.app')

@section('title', 'كود الدفع المرجعي')

@section('content')
<div class="py-12">
    <div class="max-w-xl mx-auto">
        <div class="bg-white dark:bg-[#0f172a] p-8 rounded-3xl shadow-xl border border-gray-100 dark:border-white/10 text-center">
            <div class="w-20 h-20 bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
                <i class="fa-solid fa-receipt"></i>
            </div>
            
            <h1 class="text-3xl font-extrabold text-[var(--text-color)] dark:text-white mb-4">شكراً لك، طلبك قيد التنفيذ!</h1>
            <p class="text-gray-500 dark:text-gray-400 mb-8 font-medium">يرجى استخدام الكود المرجعي التالي لإتمام عملية الدفع في أي منفذ (أمان، مصاري، ميزة، إلخ)</p>

            <div class="bg-gray-50 dark:bg-white/5 p-8 rounded-2xl border-2 border-dashed border-amber-500/30 mb-8">
                <div class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-2">كود الدفع المرجعي</div>
                <div class="text-2xl md:text-5xl font-black text-amber-500 my-4 select-all" style="letter-spacing: 0.25em; margin-right: -0.25em;">{{ $bill_reference }}</div>
                <div class="text-sm text-gray-500 font-bold mt-4 italic">صالح لمدة 24 ساعة فقط</div>
            </div>

            <div class="grid grid-cols-1 gap-4 mb-8">
                <div class="flex items-start space-x-4 space-x-reverse text-right bg-blue-500/5 p-4 rounded-xl border border-blue-500/10">
                    <div class="w-8 h-8 bg-blue-500 text-white rounded-lg flex items-center justify-center flex-shrink-0 font-bold">1</div>
                    <p class="text-sm font-bold text-gray-700 dark:text-gray-300">توجه إلى أقرب منفذ دفع (أمان، مصاري، ميزة، أو كشك لديه ماكينة دفع).</p>
                </div>
                <div class="flex items-start space-x-4 space-x-reverse text-right bg-blue-500/5 p-4 rounded-xl border border-blue-500/10">
                    <div class="w-8 h-8 bg-blue-500 text-white rounded-lg flex items-center justify-center flex-shrink-0 font-bold">2</div>
                    <p class="text-sm font-bold text-gray-700 dark:text-gray-300">أخبر التاجر برغبتك في الدفع لخدمة "Paymob" أو "مدفوعات قبول".</p>
                </div>
                <div class="flex items-start space-x-4 space-x-reverse text-right bg-blue-500/5 p-4 rounded-xl border border-blue-500/10">
                    <div class="w-8 h-8 bg-blue-500 text-white rounded-lg flex items-center justify-center flex-shrink-0 font-bold">3</div>
                    <p class="text-sm font-bold text-gray-700 dark:text-gray-300">أعطه الكود المرجعي وسدد المبلغ المطلوب.</p>
                </div>
            </div>

            <div class="flex flex-col gap-4">
                <a href="{{ route('dashboard') }}" class="w-full py-4 rounded-2xl bg-amber-500 hover:bg-amber-600 transition text-white font-black text-lg shadow-lg">
                    العودة للرئيسية
                </a>
                <p class="text-xs text-gray-400 font-bold">ستصلك رسالة تأكيد ويتم تفعيل الكورس تلقائياً فور إتمام الدفع.</p>
            </div>
        </div>
    </div>
</div>
@endsection
