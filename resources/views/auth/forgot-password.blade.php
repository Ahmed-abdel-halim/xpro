@extends('layouts.app')

@section('title', 'نسيت كلمة المرور')

@section('content')
<div class="flex justify-center items-center min-h-[70vh]">
    <div class="bg-white dark:bg-white/5 p-10 rounded-[2.5rem] w-full max-w-md shadow-2xl shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-white/10 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-amber-500/10 dark:bg-sky-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-emerald-500/10 dark:bg-purple-500/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2 pointer-events-none"></div>
        
        <h2 class="text-3xl font-black mb-4 text-center text-[var(--text-color)] dark:text-transparent dark:bg-clip-text dark:bg-gradient-to-l dark:from-sky-400 dark:to-emerald-400 relative z-10">نسيت كلمة المرور؟</h2>
        
        <div class="mb-6 text-sm font-medium text-gray-500 dark:text-gray-400 text-center relative z-10 leading-relaxed">
            لا مشكلة. فقط أدخل بريدك الإلكتروني وسنقوم بإرسال رابط يتيح لك اختيار كلمة مرور جديدة.
        </div>

        <!-- Session Status -->
        @if(session('status'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 text-sm font-bold text-center relative z-10">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="relative z-10">
            @csrf

            <!-- Email Address -->
            <div class="space-y-6">
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700 dark:text-gray-400">البريد الإلكتروني</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 focus:ring-2 focus:ring-amber-500/20 dark:focus:ring-sky-500/20 transition shadow-sm dark:shadow-inner">
                    @error('email') <span class="text-red-500 dark:text-red-400 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="w-full py-4 rounded-xl bg-amber-500 hover:bg-amber-600 dark:bg-sky-500 dark:hover:bg-sky-600 transition text-white font-bold text-lg shadow-lg shadow-amber-500/30 dark:shadow-sky-500/20 hover:-translate-y-1">
                    إرسال رابط استعادة كلمة المرور
                </button>

                <p class="text-center text-gray-600 dark:text-gray-400 font-medium mt-6 pt-6 border-t border-gray-100 dark:border-white/10">
                    تذكرت كلمة المرور؟ <a href="{{ route('login') }}" class="text-amber-500 hover:text-amber-600 dark:text-sky-400 dark:hover:text-sky-300 font-bold transition mr-1">تسجيل الدخول</a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection
