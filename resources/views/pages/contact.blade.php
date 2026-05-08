@extends('layouts.app')

@section('title', 'تواصل معنا')

@section('content')
<div class="py-20 max-w-4xl mx-auto px-4">
    <div class="bg-white dark:bg-[#141c2f] border border-[#00555A]/10 dark:border-white/10 p-8 md:p-12 rounded-[2rem] shadow-2xl shadow-amber-500/5 dark:shadow-none">
        
        <div class="text-center mb-12">
            <div class="w-20 h-20 mx-auto bg-amber-500/10 dark:bg-sky-500/10 border border-amber-500/20 dark:border-sky-500/20 flex items-center justify-center text-amber-500 dark:text-sky-400 text-4xl rounded-[1.5rem] mb-6 shadow-[0_0_30px_rgba(245,158,11,0.15)] dark:shadow-[0_0_30px_rgba(14,165,233,0.15)]">
                <i class="fa-solid fa-envelope-open-text"></i>
            </div>
            <h1 class="text-4xl md:text-5xl font-black mb-4 gradient-text">نحن هنا لخدمتك</h1>
            <p class="text-lg text-gray-600 dark:text-gray-400 leading-relaxed max-w-2xl mx-auto">
                هل لديك استفسار، اقتراح، أو واجهت مشكلة؟ يسعدنا تواصلك معنا وسنقوم بالرد عليك في أقرب وقت ممكن.
            </p>
        </div>

        <form x-data="contactForm" 
            action="{{ route('contact.store') }}"
            @submit.prevent="submitForm($event)" 
            class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-600 dark:text-gray-400 text-sm font-bold mb-2">الاسم بالكامل</label>
                    <input type="text" name="name" required class="w-full bg-gray-50 dark:bg-[#0b1121] border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3.5 text-gray-800 dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 focus:ring-1 focus:ring-amber-500/50 dark:focus:ring-sky-500/50 transition" placeholder="أدخل اسمك الكريم">
                </div>
                <div>
                    <label class="block text-gray-600 dark:text-gray-400 text-sm font-bold mb-2">البريد الإلكتروني</label>
                    <input type="email" name="email" required class="w-full bg-gray-50 dark:bg-[#0b1121] border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3.5 text-gray-800 dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 focus:ring-1 focus:ring-amber-500/50 dark:focus:ring-sky-500/50 transition" placeholder="example@email.com">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-600 dark:text-gray-400 text-sm font-bold mb-2">رقم الهاتف / الواتساب</label>
                    <input type="text" name="phone" required class="w-full bg-gray-50 dark:bg-[#0b1121] border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3.5 text-gray-800 dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 focus:ring-1 focus:ring-amber-500/50 dark:focus:ring-sky-500/50 transition" placeholder="مثال: 010xxxxxxxx">
                </div>
                <div>
                    <label class="block text-gray-600 dark:text-gray-400 text-sm font-bold mb-2">عنوان الرسالة</label>
                    <input type="text" name="subject" required class="w-full bg-gray-50 dark:bg-[#0b1121] border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3.5 text-gray-800 dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 focus:ring-1 focus:ring-amber-500/50 dark:focus:ring-sky-500/50 transition" placeholder="بخصوص ماذا تريد التواصل؟">
                </div>
            </div>

            <div>
                <label class="block text-gray-600 dark:text-gray-400 text-sm font-bold mb-2">الرسالة</label>
                <textarea name="message" rows="5" required class="w-full bg-gray-50 dark:bg-[#0b1121] border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3.5 text-gray-800 dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 focus:ring-1 focus:ring-amber-500/50 dark:focus:ring-sky-500/50 transition resize-none" placeholder="اكتب رسالتك هنا بدقة..."></textarea>
            </div>

            <button type="submit" :disabled="loading" class="w-full py-4 mt-4 bg-amber-500 hover:bg-amber-600 dark:bg-sky-500 dark:hover:bg-sky-600 disabled:opacity-50 transition-all duration-300 rounded-xl text-white font-bold shadow-lg shadow-amber-500/20 dark:shadow-sky-500/20 flex items-center justify-center hover:-translate-y-1">
                <i class="fa-solid fa-paper-plane border-0 ml-3" x-show="!loading"></i>
                <i class="fa-solid fa-spinner fa-spin border-0 ml-3" x-show="loading" style="display: none;"></i>
                <span x-text="loading ? 'جاري إرسال رسالتك...' : 'إرسال الرسالة الآن'"></span>
            </button>
        </form>

        <div class="mt-12 pt-8 border-t border-[#00555A]/10 dark:border-white/10">
            <p class="text-center text-gray-500 dark:text-gray-400 mb-6 text-sm">أو يمكنك التواصل معنا عبر منصات التواصل الاجتماعي</p>
            <div class="flex items-center justify-center gap-6 flex-wrap">
                <!-- Facebook -->
                @if(!empty($settings['social_facebook']))
                <a href="{{ $settings['social_facebook'] }}" target="_blank" class="w-12 h-12 rounded-full bg-[#1877F2]/10 dark:bg-[#1877F2]/20 border border-[#1877F2]/20 flex items-center justify-center text-[#1877F2] hover:bg-[#1877F2] hover:text-white transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-[#1877F2]/30 text-xl">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
                @endif

                <!-- Instagram -->
                @if(!empty($settings['social_instagram']))
                <a href="{{ $settings['social_instagram'] }}" target="_blank" class="w-12 h-12 rounded-full bg-[#E4405F]/10 dark:bg-[#E4405F]/20 border border-[#E4405F]/20 flex items-center justify-center text-[#E4405F] hover:bg-gradient-to-tr hover:from-[#F58529] hover:via-[#DD2A7B] hover:to-[#8134AF] hover:text-white hover:border-transparent transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-[#E4405F]/30 text-xl">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                @endif

                <!-- Twitter/X -->
                @if(!empty($settings['social_twitter']))
                <a href="{{ $settings['social_twitter'] }}" target="_blank" class="w-12 h-12 rounded-full bg-black/5 dark:bg-white/10 border border-black/10 dark:border-white/20 flex items-center justify-center text-[var(--text-color)] dark:text-white hover:bg-black dark:hover:bg-white dark:hover:text-black hover:text-white transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-black/20 text-xl">
                    <i class="fa-brands fa-x-twitter"></i>
                </a>
                @endif

                <!-- YouTube -->
                @if(!empty($settings['social_youtube']))
                <a href="{{ $settings['social_youtube'] }}" target="_blank" class="w-12 h-12 rounded-full bg-[#FF0000]/10 dark:bg-[#FF0000]/20 border border-[#FF0000]/20 flex items-center justify-center text-[#FF0000] hover:bg-[#FF0000] hover:text-white transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-[#FF0000]/30 text-xl">
                    <i class="fa-brands fa-youtube"></i>
                </a>
                @endif

                <!-- WhatsApp -->
                @php
                    $whatsappNumber = $settings['contact_whatsapp'] ?? '201551322666';
                    $whatsappUrl = "https://wa.me/" . preg_replace('/[^0-9]/', '', $whatsappNumber) . "?text=" . urlencode("السلام عليكم، أود الاستفسار عن خدمات منصة Xpro");
                @endphp
                <a href="{{ $whatsappUrl }}" target="_blank" class="w-12 h-12 rounded-full bg-[#25D366]/10 dark:bg-[#25D366]/20 border border-[#25D366]/20 flex items-center justify-center text-[#25D366] hover:bg-[#25D366] hover:text-white transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-[#25D366]/30 text-xl">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('contactForm', () => ({
            loading: false,
            submitForm(event) {
                this.loading = true;
                const form = event.target;
                
                fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
                    }
                })
                .then(response => {
                    if (!response.ok && response.status !== 422) {
                        throw new Error('Network error');
                    }
                    return response.json();
                })
                .then(data => {
                    this.loading = false;
                    if(data.success) {
                        this.$dispatch('toast', {message: data.message, type: 'success'}); 
                        form.reset();
                    } else if (data.message) {
                        this.$dispatch('toast', {message: data.message, type: 'error'}); 
                    } else {
                        this.$dispatch('toast', {message: 'يرجى مراجعة البيانات المدخلة.', type: 'error'});
                    }
                })
                .catch(error => {
                    this.loading = false;
                    this.$dispatch('toast', {message: 'تعذر الاتصال بالخادم.', type: 'error'}); 
                    console.error('Error:', error);
                });
            }
        }));
    });
</script>
@endsection
