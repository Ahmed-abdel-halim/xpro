@extends('layouts.app')

@section('title', 'تم إرسال طلب الدفع')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 text-center">
        <div class="w-20 h-20 bg-green-100 dark:bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fa-solid fa-check text-green-600 dark:text-green-400 text-3xl"></i>
        </div>
        
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">تم إرسال طلب الدفع بنجاح!</h1>
        
        <p class="text-lg text-gray-600 dark:text-gray-300 mb-8">
            تم تسجيل طلب الدفع الخاص بك. سيقوم المدرس بمراجعة الطلب وتأكيد الدفع قريباً.
        </p>
        
        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">تفاصيل الدفع</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-right">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">الكورس</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $payment->course->title }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">المبلغ</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ number_format($payment->amount, 2) }} جنيه</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">طريقة الدفع</p>
                    <p class="font-medium text-gray-900 dark:text-white">
                        {{ $payment->payment_method === 'bank_transfer' ? 'تحويل بنكي' : 'محفظة إلكترونية' }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">رقم المعاملة</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $payment->transaction_id ?: '-' }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-amber-50 dark:bg-amber-500/10 rounded-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-amber-900 dark:text-amber-300 mb-2">الخطوات التالية</h3>
            <ol class="text-right space-y-2 text-amber-800 dark:text-amber-200">
                <li>1. سيقوم المدرس بمراجعة طلب الدفع الخاص بك</li>
                <li>2. سيتم تأكيد الدفع بعد التحقق من المعاملة</li>
                <li>3. سيتم تفعيل الكورس لك بعد تأكيد الدفع</li>
                <li>4. ستصلك إشعارات عبر البريد الإلكتروني بكل التطورات</li>
            </ol>
        </div>
        
        <div class="flex gap-4 justify-center">
            <a href="{{ route('payments.student') }}" class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-300">
                عرض سجل الدفعات
            </a>
            <a href="{{ route('course.show', $payment->course_id) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-3 px-6 rounded-lg transition-colors duration-300">
                العودة للكورس
            </a>
        </div>
    </div>
</div>
@endsection
