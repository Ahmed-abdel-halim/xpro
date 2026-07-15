@extends('layouts.dashboard')

@section('title', 'تفعيل كورس لطالب')
@section('page-title', 'التفعيل اليدوي للكورسات')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-10">
        <a href="{{ route('teacher.dashboard') }}" class="text-amber-500 hover:text-amber-600 dark:text-sky-400 dark:hover:text-sky-300 transition text-sm flex items-center mb-2 font-bold">
            <i class="fa-solid fa-arrow-right ml-2"></i>
            العودة للوحة المعلم
        </a>
        <h1 class="text-3xl font-bold text-[var(--text-color)] dark:text-white">تفعيل كورس لطالب (دفع كاش)</h1>
        <p class="text-gray-500 font-medium mt-2">يمكنك استخدام هذه الصفحة لتفعيل الكورس لأي طالب مباشرةً في حال استلام قيمة الكورس منه نقداً (كاش) خارج المنصة.</p>
    </div>

    <!-- Info Box -->
    <div class="mb-8 p-6 bg-amber-500/10 border border-amber-500/20 text-amber-600 dark:text-amber-400 rounded-2xl flex items-start space-x-4 space-x-reverse">
        <div class="w-10 h-10 bg-amber-500/20 rounded-xl flex items-center justify-center flex-shrink-0 text-amber-500">
            <i class="fa-solid fa-circle-exclamation text-xl"></i>
        </div>
        <div>
            <h4 class="font-bold mb-1">ملاحظة هامة جداً:</h4>
            <p class="text-sm font-medium leading-relaxed">
                يجب أن يكون الطالب قد قام بإنشاء حساب على المنصة أولاً. بعد تفعيل الكورس، سيتم تسجيل عملية الدفع كعملية مؤكدة وتطبيق نسبة عمولة المنصة المعتادة عليها.
            </p>
        </div>
    </div>

    <form action="{{ route('teacher.enrollments.store') }}" method="POST">
        @csrf
        <div class="card-glass p-8 rounded-3xl border border-gray-100 dark:border-white/5 space-y-6">
            <div>
                <label class="block text-gray-500 dark:text-gray-400 text-sm font-bold mb-2">البريد الإلكتروني للطالب أو رقم الهاتف</label>
                <input type="text" name="student_identifier" value="{{ old('student_identifier') }}" required
                       class="w-full bg-gray-50 border border-gray-200 dark:bg-white/5 dark:border-white/10 rounded-xl px-4 py-3 text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition"
                       placeholder="مثال: student@example.com أو 01000000000">
                @error('student_identifier')
                    <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-500 dark:text-gray-400 text-sm font-bold mb-2">الكورس المراد تفعيله</label>
                <select name="course_id" required class="w-full bg-gray-50 border border-gray-200 dark:bg-white/5 dark:border-white/10 rounded-xl px-4 py-3 text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                    <option value="" disabled selected>اختر الكورس</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->title }} ({{ number_format($course->price, 2) }} ج.م)
                        </option>
                    @endforeach
                </select>
                @error('course_id')
                    <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-4 bg-amber-500 hover:bg-amber-600 dark:bg-sky-500 dark:hover:bg-sky-600 transition rounded-xl text-white font-bold shadow-lg shadow-amber-500/20 dark:shadow-sky-500/20 group hover:-translate-y-1">
                    <i class="fa-solid fa-user-plus ml-2"></i>
                    تفعيل الكورس للطالب الآن
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
