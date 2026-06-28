@extends('layouts.dashboard')

@section('title', 'طلبك قيد المراجعة')
@section('page-title', 'حالة الحساب')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[60vh] py-12 px-4">
    <div class="card-glass max-w-lg w-full p-8 rounded-3xl border border-gray-100 dark:border-white/5 text-center shadow-2xl relative overflow-hidden">
        <!-- Decorative Glow -->
        <div class="absolute -top-10 -left-10 w-40 h-40 bg-amber-500/10 dark:bg-sky-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-orange-500/10 dark:bg-indigo-500/10 rounded-full blur-3xl"></div>
        
        <!-- Icon Section with pulse animation -->
        <div class="relative w-24 h-24 bg-amber-100 dark:bg-sky-500/10 rounded-full flex items-center justify-center mx-auto mb-8 animate-pulse">
            <i class="fa-solid fa-clock-rotate-left text-4xl text-amber-600 dark:text-sky-400"></i>
        </div>
        
        <!-- Content -->
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[var(--text-color)] dark:text-white mb-4 leading-tight">
            حسابك قيد المراجعة والتدقيق
        </h1>
        
        <p class="text-gray-500 dark:text-gray-400 font-medium text-base mb-6 leading-relaxed">
            مرحباً بك يا أستاذ/ <span class="text-amber-600 dark:text-sky-400 font-bold">{{ auth()->user()->name }}</span>.
            لقد تم استلام طلب تسجيلك كمعلم بنجاح. نقوم حالياً بمراجعة البيانات وتفعيل الحساب.
        </p>

        <div class="p-5 bg-amber-500/5 dark:bg-sky-500/5 rounded-2xl border border-amber-500/10 dark:border-sky-500/10 mb-8">
            <div class="flex items-start space-x-3 space-x-reverse text-right">
                <i class="fa-solid fa-circle-info text-amber-600 dark:text-sky-400 mt-1 flex-shrink-0"></i>
                <div>
                    <h4 class="font-bold text-amber-800 dark:text-sky-300 text-sm mb-1">ماذا يعني هذا؟</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                        بمجرد موافقة الإدارة على طلبك، ستتمكن من الوصول الكامل إلى لوحة التحكم الخاصة بك لرفع الكورسات، إدارة الدروس، ومتابعة مبيعاتك وأرباحك.
                    </p>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
            <a href="{{ route('profile.edit') }}" class="w-full sm:w-auto px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-white/5 dark:hover:bg-white/10 text-gray-700 dark:text-white transition rounded-xl font-bold text-sm flex items-center justify-center">
                <i class="fa-solid fa-user-gear ml-2"></i>
                تعديل الملف الشخصي
            </a>
            
            <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                @csrf
                <button type="submit" class="w-full px-6 py-3 bg-red-500/10 hover:bg-red-500/20 text-red-600 dark:text-red-400 transition rounded-xl font-bold text-sm flex items-center justify-center">
                    <i class="fa-solid fa-right-from-bracket ml-2"></i>
                    تسجيل الخروج
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
