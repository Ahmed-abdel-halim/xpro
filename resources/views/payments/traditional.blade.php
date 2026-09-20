@extends('layouts.app')

@section('title', 'تأكيد بيانات التحويل')

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-100 dark:border-gray-700">
        <div class="bg-gradient-to-r from-amber-500 to-orange-500 p-6 text-white">
            <h1 class="text-2xl font-bold">تأكيد تفاصيل التحويل</h1>
            <p class="text-amber-50 opacity-90">يرجى إدخال بيانات التحويل ليتم تفعيل الكورس لك</p>
        </div>

        <div class="p-8">
            <!-- Course Info -->
            <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-dashed border-gray-300 dark:border-gray-600">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">الكورس المختار:</p>
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">{{ $course->title }}</h2>
                    </div>
                    <div class="text-left">
                        <p class="text-sm text-gray-500 dark:text-gray-400">المبلغ المطلوب:</p>
                        <p class="text-2xl font-black text-amber-600 dark:text-amber-400">
                            {{ number_format($course->price, 2) }} <span class="text-sm">د.ع</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Company Payment Info (NOT teacher) -->
            <div class="mb-8 p-6 bg-amber-50 dark:bg-amber-900/20 rounded-xl border-2 border-amber-200 dark:border-amber-800 text-center">
                <div class="flex items-center justify-center gap-2 mb-3">
                    <i class="fa-solid fa-building text-amber-600 dark:text-amber-400 text-lg"></i>
                    <p class="text-amber-800 dark:text-amber-300 font-bold text-lg">رقم التحويل الخاص بالشركة</p>
                </div>
                <div class="flex items-center justify-center gap-3 mt-2">
                    @php
                        $companyPhone = \App\Models\Setting::where('key', 'contact_phone')->value('value') 
                                     ?? \App\Models\Setting::where('key', 'company_phone')->value('value') 
                                     ?? '---';
                    @endphp
                    <span class="text-3xl font-black text-amber-600 dark:text-amber-400 select-all tracking-widest" id="company-phone">
                        {{ $companyPhone }}
                    </span>
                    @if($companyPhone !== '---')
                    <button type="button" onclick="copyToClipboard('{{ $companyPhone }}')" 
                            class="p-2 hover:bg-amber-200 dark:hover:bg-amber-800 rounded-lg transition-colors text-amber-600" 
                            title="نسخ الرقم">
                        <i class="fa-solid fa-copy text-lg"></i>
                    </button>
                    @endif
                </div>
                <p class="mt-3 text-sm text-amber-700 dark:text-amber-400/80 font-medium">
                    <i class="fa-solid fa-circle-info ml-1"></i>
                    يرجى تحويل المبلغ إلى رقم الشركة أعلاه، ثم ملء بيانات التحويل أدناه
                </p>
                <p class="mt-1 text-xs text-amber-600/70 dark:text-amber-500/60">
                    سيتم مراجعة الطلب من قِبل فريق الإدارة وتفعيل الكورس خلال ساعات قليلة
                </p>
            </div>

            <!-- Form -->
            <form action="{{ route('payment.traditional.process', $course) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">وسيلة التحويل</label>
                        <select name="payment_method" required 
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-4 focus:ring-amber-500/20 focus:border-amber-500 transition-all outline-none">
                            <option value="">اختر الوسيلة...</option>
                            <option value="zaincash"     {{ old('payment_method') === 'zaincash'     ? 'selected' : '' }}>زين كاش (ZainCash)</option>
                            <option value="bank_transfer"{{ old('payment_method') === 'bank_transfer'? 'selected' : '' }}>تحويل بنكي</option>
                        </select>
                        @error('payment_method') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">الرقم الذي تم التحويل منه</label>
                        <input type="text" name="sender_number" value="{{ old('sender_number') }}" 
                               placeholder="رقم الموبايل أو اسم الحساب" required 
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-4 focus:ring-amber-500/20 focus:border-amber-500 transition-all outline-none">
                        @error('sender_number') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">تاريخ العملية</label>
                    <input type="date" name="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" required 
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-4 focus:ring-amber-500/20 focus:border-amber-500 transition-all outline-none">
                    @error('payment_date') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">صورة إيصال التحويل (سكرين شوت)</label>
                    <div class="relative group">
                        <input type="file" name="proof_image" id="proof_image" accept="image/*" required class="hidden">
                        <label for="proof_image" class="flex flex-col items-center justify-center w-full h-32 px-4 py-6 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl cursor-pointer hover:border-amber-500 hover:bg-amber-50 dark:hover:bg-amber-900/10 transition-all">
                            <div id="file-preview-container" class="flex flex-col items-center justify-center">
                                <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 group-hover:text-amber-500 mb-2"></i>
                                <p class="text-sm text-gray-500 dark:text-gray-400" id="file-name">اضغط هنا لرفع الصورة</p>
                            </div>
                        </label>
                    </div>
                    @error('proof_image') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">ملاحظات إضافية (اختياري)</label>
                    <textarea name="notes" rows="3" placeholder="أي تفاصيل أخرى تريد إخبارنا بها..." 
                              class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-4 focus:ring-amber-500/20 focus:border-amber-500 transition-all outline-none resize-none">{{ old('notes') }}</textarea>
                </div>

                <div class="pt-4 flex flex-col sm:flex-row gap-4">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-black py-4 px-8 rounded-xl shadow-lg shadow-amber-500/20 transform hover:-translate-y-1 transition-all duration-300 text-lg">
                        إرسال الطلب الآن
                    </button>
                    <a href="{{ route('course.show', $course) }}" class="sm:w-32 flex items-center justify-center bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 font-bold py-4 px-6 rounded-xl transition-all duration-300">
                        رجوع
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        const btn = document.querySelector('[onclick*="copyToClipboard"]');
        btn.innerHTML = '<i class="fa-solid fa-check text-lg text-emerald-500"></i>';
        setTimeout(() => {
            btn.innerHTML = '<i class="fa-solid fa-copy text-lg"></i>';
        }, 1500);
    });
}

document.getElementById('proof_image').addEventListener('change', function(e) {
    const fileName = e.target.files[0] ? e.target.files[0].name : 'اضغط هنا لرفع الصورة';
    if (e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const container = document.getElementById('file-preview-container');
            container.innerHTML = `<img src="${event.target.result}" class="h-20 w-auto rounded-lg mb-1 shadow-sm border border-gray-200"><p class="text-xs text-amber-600 font-bold">${fileName}</p>`;
        };
        reader.readAsDataURL(e.target.files[0]);
    }
});
</script>
@endsection
