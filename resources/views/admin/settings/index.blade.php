@extends('layouts.dashboard')

@section('title', 'إعدادات المنصة')
@section('page-title', 'إعدادات المنصة العامة')

@section('content')
<div class="mb-10">
    <h1 class="text-3xl font-bold text-[var(--text-color)] dark:text-white mb-2">إعدادات المنصة</h1>
    <p class="text-gray-500 font-medium">تحكم في روابط التواصل الاجتماعي ومعلومات الاتصال الظاهرة في الموقع.</p>
</div>

<form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Social Media Settings -->
        <div class="card-glass p-8 rounded-[2rem] border border-gray-100 dark:border-white/5 shadow-xl">
            <h3 class="text-xl font-bold text-[var(--text-color)] dark:text-white mb-6 flex items-center gap-3">
                <i class="fa-solid fa-share-nodes text-amber-500 dark:text-sky-400"></i>
                روابط التواصل الاجتماعي
            </h3>
            
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-gray-500 mb-2">رابط فيسبوك</label>
                    <div class="relative">
                        <i class="fa-brands fa-facebook absolute left-4 top-1/2 -translate-y-1/2 text-blue-600"></i>
                        <input type="url" name="social_facebook" value="{{ $settings['social']['social_facebook'] ?? '' }}" 
                               class="w-full pl-12 pr-4 py-4 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 text-[var(--text-color)] dark:text-white focus:ring-2 focus:ring-amber-500 outline-none transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-500 mb-2">رابط انستجرام</label>
                    <div class="relative">
                        <i class="fa-brands fa-instagram absolute left-4 top-1/2 -translate-y-1/2 text-pink-600"></i>
                        <input type="url" name="social_instagram" value="{{ $settings['social']['social_instagram'] ?? '' }}" 
                               class="w-full pl-12 pr-4 py-4 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 text-[var(--text-color)] dark:text-white focus:ring-2 focus:ring-amber-500 outline-none transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-500 mb-2">رابط يوتيوب (اتركه فارغاً للإخفاء)</label>
                    <div class="relative">
                        <i class="fa-brands fa-youtube absolute left-4 top-1/2 -translate-y-1/2 text-red-600"></i>
                        <input type="url" name="social_youtube" value="{{ $settings['social']['social_youtube'] ?? '' }}" 
                               class="w-full pl-12 pr-4 py-4 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 text-[var(--text-color)] dark:text-white focus:ring-2 focus:ring-amber-500 outline-none transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-500 mb-2">رابط تويتر (اتركه فارغاً للإخفاء)</label>
                    <div class="relative">
                        <i class="fa-brands fa-twitter absolute left-4 top-1/2 -translate-y-1/2 text-sky-500"></i>
                        <input type="url" name="social_twitter" value="{{ $settings['social']['social_twitter'] ?? '' }}" 
                               class="w-full pl-12 pr-4 py-4 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 text-[var(--text-color)] dark:text-white focus:ring-2 focus:ring-amber-500 outline-none transition-all">
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Settings -->
        <div class="card-glass p-8 rounded-[2rem] border border-gray-100 dark:border-white/5 shadow-xl">
            <h3 class="text-xl font-bold text-[var(--text-color)] dark:text-white mb-6 flex items-center gap-3">
                <i class="fa-solid fa-headset text-amber-500 dark:text-sky-400"></i>
                معلومات الاتصال
            </h3>
            
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-gray-500 mb-2">رقم الهاتف</label>
                    <div class="relative">
                        <i class="fa-solid fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="contact_phone" value="{{ $settings['contact']['contact_phone'] ?? '' }}" 
                               class="w-full pl-12 pr-4 py-4 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 text-[var(--text-color)] dark:text-white focus:ring-2 focus:ring-amber-500 outline-none transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-500 mb-2">رقم واتساب (بدون + أو أصفار دولية)</label>
                    <div class="relative">
                        <i class="fa-brands fa-whatsapp absolute left-4 top-1/2 -translate-y-1/2 text-green-500"></i>
                        <input type="text" name="contact_whatsapp" value="{{ $settings['contact']['contact_whatsapp'] ?? '' }}" 
                               class="w-full pl-12 pr-4 py-4 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 text-[var(--text-color)] dark:text-white focus:ring-2 focus:ring-amber-500 outline-none transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-500 mb-2">البريد الإلكتروني</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="email" name="contact_email" value="{{ $settings['contact']['contact_email'] ?? '' }}" 
                               class="w-full pl-12 pr-4 py-4 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 text-[var(--text-color)] dark:text-white focus:ring-2 focus:ring-amber-500 outline-none transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-500 mb-2">العنوان</label>
                    <div class="relative">
                        <i class="fa-solid fa-location-dot absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="contact_address" value="{{ $settings['contact']['contact_address'] ?? '' }}" 
                               class="w-full pl-12 pr-4 py-4 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 text-[var(--text-color)] dark:text-white focus:ring-2 focus:ring-amber-500 outline-none transition-all">
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="mt-10 flex justify-end">
        <button type="submit" class="px-12 py-5 rounded-2xl bg-amber-500 hover:bg-amber-600 dark:bg-sky-600 dark:hover:bg-sky-700 text-white font-black shadow-xl shadow-amber-500/20 dark:shadow-sky-600/20 transition-all hover:scale-105 active:scale-95">
            حفظ التغييرات
        </button>
    </div>
</form>
@endsection
