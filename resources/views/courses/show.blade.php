@extends('layouts.app')

@section('title', $course->title)

@section('content')
<div class="py-12" x-data="{ 
    activeVideo: null,
    showPaymentModal: false,
    isEmbed(url) {
        if (!url) return false;
        const low = url.toLowerCase();
        return low.includes('youtube.com') || 
               low.includes('youtu.be') || 
               low.includes('vimeo.com') || 
               low.includes('drive.google.com/file/d/') ||
               low.includes('embed') || 
               low.includes('iframe') || 
               low.includes('player.');
    },
    isVideo(url) {
        if (!url) return false;
        // Strip query parameters and hashes for checking extension
        const cleanUrl = url.split('?')[0].split('#')[0].toLowerCase();
        const exts = ['.mp4', '.mov', '.webm', '.ogg', '.m4v', '.mkv', '.avi'];
        return exts.some(ext => cleanUrl.endsWith(ext));
    },
    isAudio(url) {
        if (!url) return false;
        const exts = ['.mp3', '.wav', '.m4a', '.ogg'];
        return exts.some(ext => url.toLowerCase().endsWith(ext));
    },
    isGooglePhotos(url) {
        if (!url) return false;
        const low = url.toLowerCase();
        return low.includes('photos.app.goo.gl') || low.includes('photos.google.com');
    },
    getEmbedUrl(url) {
        if (url.includes('youtube.com/watch')) {
            const urlObj = new URL(url);
            return 'https://www.youtube.com/embed/' + urlObj.searchParams.get('v') + '?autoplay=1&modestbranding=1&rel=0&showinfo=0&iv_load_policy=3&enablejsapi=1&origin=' + window.location.origin;
        }
        if (url.includes('youtu.be/')) {
            const videoId = url.split('youtu.be/')[1].split('?')[0];
            return 'https://www.youtube.com/embed/' + videoId + '?autoplay=1&modestbranding=1&rel=0&showinfo=0&iv_load_policy=3&enablejsapi=1&origin=' + window.location.origin;
        }
        if (url.includes('vimeo.com/')) {
            const videoId = url.split('vimeo.com/')[1].split('?')[0];
            return 'https://player.vimeo.com/video/' + videoId + '?autoplay=1&badge=0&byline=0&portrait=0&title=0';
        }
        if (url.includes('drive.google.com/file/d/')) {
            const fileId = url.split('drive.google.com/file/d/')[1].split('/')[0];
            return 'https://drive.google.com/file/d/' + fileId + '/preview';
        }
        return url;
    },
    initPlayer() {
        if (!this.activeVideo) return;
        this.$nextTick(() => {
            setTimeout(() => {
                if (this.$refs.player) {
                    if (window.plyrInstance) window.plyrInstance.destroy();
                    window.plyrInstance = new Plyr(this.$refs.player, {
                        autoplay: true,
                        rtl: true,
                        clickToPlay: true,
                        fullscreen: { enabled: true, fallback: true, iosNative: true },
                        youtube: { noCookie: false, rel: 0, showinfo: 0, iv_load_policy: 3, modestbranding: 1 },
                        controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'captions', 'settings', 'pip', 'airplay', 'fullscreen'],
                        settings: ['quality', 'speed']
                    });
                }
            }, 50);
        });
    }
}">

<!-- Payment Modal -->
<div x-show="showPaymentModal" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
     @click.self="showPaymentModal = false">
    
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full p-6"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-90"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-90">
        
        <div class="text-center">
            <div class="w-16 h-16 bg-amber-100 dark:bg-amber-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-lock text-amber-600 dark:text-amber-400 text-2xl"></i>
            </div>
            
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">المحتوى مخصص للمشتركين</h3>
            
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                يجب الاشتراك في الكورس لمشاهدة هذا الفيديو. اشترك الآن واحصل على وصول كامل لجميع الدروس.
            </p>
            
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">سعر الكورس</p>
                <p class="text-2xl font-bold text-amber-600 dark:text-amber-400">{{ number_format($course->price, 2) }} جنيه</p>
            </div>
            
            <div class="space-y-3">
                <a href="{{ route('payment.traditional', $course->id) }}" 
                   class="block w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 px-4 rounded-lg transition-colors duration-300">
                    <i class="fa-solid fa-money-bill-transfer ml-2"></i>
                    الدفع التقليدي
                </a>
                
                <button @click="showPaymentModal = false" 
                        class="block w-full bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-3 px-4 rounded-lg transition-colors duration-300">
                    إلغاء
                </button>
            </div>
        </div>
    </div>
</div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <div :class="activeVideo ? 'p-0 bg-black' : 'bg-white dark:bg-[#141c2f] p-2 min-h-[350px] md:min-h-[400px] flex flex-col justify-center'" class="border border-[#00555A]/10 dark:border-white/10 rounded-3xl overflow-hidden shadow-2xl shadow-amber-500/5 dark:shadow-none transition-all duration-300">
                <!-- Video Player Area -->
                <div x-show="activeVideo" class="w-full h-full relative" style="display: none;" x-effect="initPlayer()" 
                     x-data="{ 
                        wmX: 50, 
                        wmY: 50,
                        moveWatermark() {
                            setInterval(() => {
                                this.wmX = Math.random() * 80 + 10;
                                this.wmY = Math.random() * 80 + 10;
                            }, 5000);
                        }
                     }" x-init="moveWatermark()">
                    
                    <!-- Shared Watermark for all video types -->
                    <div class="absolute pointer-events-none z-[100] transition-all duration-[5000ms] ease-in-out select-none mix-blend-overlay opacity-30 px-4 py-2"
                         :style="`top: ${wmY}%; left: ${wmX}%; transform: translate(-50%, -50%);`"
                         x-show="activeVideo">
                        <div class="text-white text-sm md:text-xl font-black rotate-[-15deg] bg-black/50 px-2 py-1 rounded backdrop-blur-sm">
                            {{ auth()->check() ? auth()->user()->email . ' - ' . auth()->user()->phone : 'Xpro Protected' }}
                        </div>
                    </div>

                    <!-- Embed Player (YouTube/Vimeo) -->
                    <template x-if="activeVideo && isEmbed(activeVideo)">
                        <div class="rounded-2xl overflow-hidden shadow-2xl relative group bg-black aspect-video youtube-container">
                            <div class="plyr__video-embed" x-ref="player" :key="activeVideo">
                                <iframe x-bind:src="getEmbedUrl(activeVideo)" allowfullscreen allowtransparency allow="autoplay"></iframe>
                            </div>
                        </div>
                    </template>
                    
                    <!-- Plyr Video Player (Direct Upload) -->
                    <template x-if="activeVideo && isVideo(activeVideo)">
                        <div class="rounded-2xl overflow-hidden shadow-2xl relative group bg-black">
                            <!-- Video Element with multiple restrictions -->
                            <video x-ref="player" playsinline controls class="w-full h-full" controlsList="nodownload noremoteplayback noplaybackrate" disablePictureInPicture oncontextmenu="return false;">
                                <source x-bind:src="activeVideo" />
                            </video>
                        </div>
                    </template>

                    <!-- Audio Player -->
                    <template x-if="activeVideo && isAudio(activeVideo)">
                        <div class="p-12 text-center bg-gray-50 dark:bg-[#0b1121] rounded-2xl border border-[#00555A]/5 dark:border-white/5">
                            <div class="mb-6 text-amber-500 dark:text-sky-400 text-5xl drop-shadow-lg shadow-amber-500/20 dark:shadow-sky-500/20">
                                <i class="fa-solid fa-volume-high"></i>
                            </div>
                            <audio x-ref="player" controls class="w-full">
                                <source x-bind:src="activeVideo" />
                            </audio>
                            <p class="mt-4 text-gray-600 dark:text-gray-400 font-medium">ملف صوتي - استمع للدرس</p>
                        </div>
                    </template>

                    <!-- Google Photos (Direct play card since embedding is blocked by Google) -->
                    <template x-if="activeVideo && isGooglePhotos(activeVideo)">
                        <div class="p-12 text-center bg-gray-50 dark:bg-[#0b1121] rounded-2xl border border-[#00555A]/5 dark:border-white/5 flex flex-col items-center">
                            <div class="mb-6 relative group cursor-pointer" @click="window.open(activeVideo, '_blank')">
                                <!-- Mock video frame with play button -->
                                <div class="w-72 max-w-full aspect-video bg-gray-900 rounded-2xl flex items-center justify-center border border-gray-700 relative overflow-hidden group-hover:border-amber-500 dark:group-hover:border-sky-500 transition-colors duration-300">
                                    <div class="absolute inset-0 bg-cover bg-center opacity-30 blur-sm" style="background-image: url('{{ $course->thumbnail ?? 'https://placehold.co/1200x675/0f172a/38bdf8?text=Course+Preview' }}')"></div>
                                    <div class="w-16 h-16 bg-amber-500 dark:bg-sky-500 text-white rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300 relative z-10">
                                        <i class="fa-solid fa-play text-2xl ml-1"></i>
                                    </div>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold mb-2 text-[var(--text-color)] dark:text-white">مشاهدة الدرس على Google Photos</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md ml-auto mr-auto text-sm leading-relaxed">
                                هذا الدرس مرفوع كفيديو على Google Photos. نظراً لقيود الأمان والحماية الخاصة بجوجل، يرجى فتح وتشغيل الفيديو في نافذة جديدة للمشاهدة.
                            </p>
                            <a x-bind:href="activeVideo" target="_blank" class="px-8 py-3 bg-amber-500 hover:bg-amber-600 dark:bg-sky-500 dark:hover:bg-sky-600 transition-all duration-300 rounded-xl text-white font-bold flex items-center shadow-lg shadow-amber-500/20 dark:shadow-sky-500/20 hover:-translate-y-1">
                                <i class="fa-solid fa-arrow-up-right-from-square ml-3"></i>
                                تشغيل الفيديو في نافذة جديدة
                            </a>
                        </div>
                    </template>

                    <!-- Other Types (PDF/Documents/RAR) -->
                    <template x-if="activeVideo && !isEmbed(activeVideo) && !isVideo(activeVideo) && !isAudio(activeVideo) && !isGooglePhotos(activeVideo)">
                        <div class="p-20 text-center bg-gray-50 dark:bg-[#0b1121] rounded-2xl border border-[#00555A]/5 dark:border-white/5 flex flex-col items-center">
                            <div class="mb-6 text-amber-500 dark:text-sky-400 text-6xl drop-shadow-lg shadow-amber-500/20 dark:shadow-sky-500/20">
                                <i class="fa-solid fa-file-circle-check"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-4 text-[var(--text-color)] dark:text-white">هذا الدرس عبارة عن ملف مرفق</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-sm ml-auto mr-auto">يحتوي هذا الدرس على ملف خارجي يمكنك تحميله والاطلاع عليه مباشرة.</p>
                            <a x-bind:href="activeVideo" target="_blank" class="px-8 py-3 bg-amber-500 hover:bg-amber-600 dark:bg-sky-500 dark:hover:bg-sky-600 transition-all duration-300 rounded-xl text-white font-bold flex items-center shadow-lg shadow-amber-500/20 dark:shadow-sky-500/20 hover:-translate-y-1">
                                <i class="fa-solid fa-download ml-3"></i>
                                تحميل / عرض الملف
                            </a>
                        </div>
                    </template>
                </div>

                <!-- Default Locked Area -->
                <div x-show="!activeVideo && !{{ $isEnrolled ? 'true' : 'false' }}" class="relative rounded-2xl overflow-hidden min-h-[350px] md:min-h-[400px] flex flex-col justify-center" @if($isEnrolled) style="display: none;" @endif>
                    <!-- Blurred Background Image -->
                    <img src="{{ $course->thumbnail ?? 'https://placehold.co/1200x675/0f172a/38bdf8?text=Course+Preview' }}" 
                         alt="Preview" class="absolute inset-0 w-full h-full object-cover opacity-80 dark:opacity-50 blur-sm scale-110">
                    
                    <!-- Content Overlay -->
                    <div class="relative z-10 flex flex-col items-center justify-center text-center p-6 md:p-8 bg-white/70 dark:bg-[#141c2f]/85 backdrop-blur-md min-h-[350px] md:min-h-[400px] w-full">
                        <div class="text-5xl mb-4 text-red-500 drop-shadow-lg">
                            <i class="fa-solid fa-lock"></i>
                        </div>

                        <h2 class="text-2xl md:text-3xl font-black mb-3 text-[var(--text-color)] dark:text-white">المحتوى مغلق</h2>
                        <p class="text-gray-700 dark:text-gray-300 font-medium mb-6 text-sm md:text-base">يجب الاشتراك في الكورس لتتمكن من مشاهدة الفيديوهات</p>
                        
                        @if($hasPending)
                            <div class="px-6 py-3 md:px-8 md:py-4 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-600 dark:text-amber-400 font-bold text-base md:text-lg inline-flex items-center gap-2">
                                <i class="fa-solid fa-clock-rotate-left"></i> بانتظار تأكيد الدفع...
                            </div>
                            <p class="text-xs text-gray-500 mt-2">لديك عملية دفع قيد المراجعة. سيقوم المدرس بتأكيد الدفع قريباً.</p>
                        @else
                            <div class="space-y-3 w-full max-w-sm">
                                <button @click="showPaymentModal = true" class="w-full py-3 md:py-4 rounded-xl bg-amber-500 hover:bg-amber-600 dark:bg-sky-500 dark:hover:bg-sky-600 transition-all duration-300 hover:-translate-y-1 text-white font-bold text-sm md:text-base flex items-center justify-center gap-2 shadow-xl shadow-amber-500/20 dark:shadow-sky-500/20 border border-amber-600 dark:border-sky-400/50">
                                    <i class="fa-solid fa-unlock-keyhole"></i> اشترك الآن لتفعيل الكورس
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Default Enrolled Area -->
                <div x-show="!activeVideo && {{ $isEnrolled ? 'true' : 'false' }}" class="aspect-video bg-gray-50 dark:bg-[#0b1121] flex flex-col items-center justify-center text-gray-500 dark:text-gray-400 rounded-2xl border border-gray-200 dark:border-white/5 m-2" @if(!$isEnrolled) style="display: none;" @endif>
                    <div class="text-7xl mb-6 text-amber-500 border-amber-500 dark:text-sky-400 dark:border-sky-400 drop-shadow-[0_0_15px_rgba(245,158,11,0.3)] dark:drop-shadow-[0_0_15px_rgba(14,165,233,0.3)]">
                        <i class="fa-solid fa-circle-play"></i>
                    </div>
                    <p class="text-xl font-medium text-[var(--text-color)] dark:text-white">اختر درساً من القائمة لبدء المشاهدة</p>
                </div>
            </div>

            <div class="bg-white dark:bg-[#141c2f] border border-[#00555A]/10 dark:border-white/10 p-8 rounded-[2rem] shadow-2xl shadow-amber-500/5 dark:shadow-none">
                <h1 class="text-4xl font-black mb-4 text-[var(--text-color)] dark:text-white">{{ $course->title }}</h1>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed mb-8 text-lg">{{ $course->description }}</p>
                
                <div class="flex items-center space-x-4 space-x-reverse py-6 border-t border-[#00555A]/10 dark:border-white/10 mt-6">
                    <div class="w-14 h-14 rounded-2xl bg-amber-500/10 dark:bg-sky-500/10 border border-amber-500/20 dark:border-sky-500/20 text-amber-500 dark:text-sky-400 flex items-center justify-center text-2xl shadow-[0_0_15px_rgba(245,158,11,0.1)] dark:shadow-[0_0_15px_rgba(14,165,233,0.1)]">
                        <i class="fa-solid fa-chalkboard-user"></i>
                    </div>

                    <div>
                        <div class="font-bold text-xl text-[var(--text-color)] dark:text-white mb-1">{{ $course->teacher->name }}</div>
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-500">معلم خبير في {{ $course->subject->name }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar / Lesson List -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-[#141c2f] border border-[#00555A]/10 dark:border-white/10 p-6 rounded-[2rem] sticky top-24 shadow-2xl shadow-amber-500/5 dark:shadow-none">
                <h3 class="text-2xl font-black mb-6 flex items-center justify-between text-[var(--text-color)] dark:text-white border-b border-[#00555A]/10 dark:border-white/10 pb-4">
                    <span>محتوى الكورس</span>
                    <span class="text-sm font-bold bg-amber-500/10 dark:bg-sky-500/10 text-amber-600 dark:text-sky-400 px-3 py-1 rounded-full border border-amber-500/20 dark:border-sky-500/20">{{ $course->lessons->count() }} درس</span>
                </h3>

                <div class="space-y-3">
                    @forelse($course->lessons as $lesson)
                        <div 
                            @if($isEnrolled || $lesson->is_free)
                                @click="activeVideo = '{{ $lesson->video_url }}'"
                            @else
                                @click="showPaymentModal = true"
                            @endif
                            class="p-4 rounded-xl {{ $isEnrolled || $lesson->is_free ? 'hover:bg-gray-50 dark:hover:bg-sky-900/10 cursor-pointer border border-transparent hover:border-[#00555A]/10 dark:hover:border-sky-500/20 hover:shadow-md hover:shadow-amber-500/5 dark:hover:shadow-sky-500/5 hover:-translate-y-0.5' : 'hover:bg-gray-50 dark:hover:bg-white/10 cursor-pointer border border-[#00555A]/5 dark:border-transparent' }} transition-all duration-300 flex items-center gap-4 group"
                        >
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ $isEnrolled || $lesson->is_free ? 'bg-amber-500/10 border border-amber-500/20 text-amber-500 dark:bg-sky-500/10 dark:border-sky-500/20 dark:text-sky-400 group-hover:bg-amber-500 group-hover:text-white dark:group-hover:bg-sky-500 dark:group-hover:text-white transition-colors duration-300 shadow-[0_0_10px_rgba(245,158,11,0.1)] dark:shadow-[0_0_10px_rgba(14,165,233,0.1)]' : 'bg-gray-200 dark:bg-white/10 text-gray-500' }}">
                                @if($isEnrolled || $lesson->is_free) 
                                    <i class="fa-solid fa-play text-sm ml-0.5"></i> 
                                @else 
                                    <i class="fa-solid fa-lock text-sm"></i> 
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-bold text-[var(--text-color)] dark:text-white truncate group-hover:text-amber-600 dark:group-hover:text-sky-400 transition-colors">{{ $lesson->title }}</div>
                                <div class="text-xs font-medium text-gray-500 dark:text-gray-500 truncate mt-1">{{ $lesson->description }}</div>
                            </div>
                            
                            @if(!($isEnrolled || $lesson->is_free))
                                <div class="flex-shrink-0">
                                    <span class="text-[10px] font-bold bg-red-100 text-red-600 dark:bg-red-500/10 dark:text-red-400 px-2 py-1 rounded-md">مغلق</span>
                                </div>
                            @elseif($lesson->is_free && !$isEnrolled)
                                <div class="flex-shrink-0">
                                    <span class="text-[10px] font-bold bg-green-100 text-green-600 dark:bg-emerald-500/10 dark:text-emerald-400 px-2 py-1 rounded-md border border-green-200 dark:border-emerald-500/20">مجاني</span>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center p-8 bg-gray-50 dark:bg-white/5 rounded-2xl border border-[#00555A]/5 dark:border-white/10">
                            <i class="fa-solid fa-video-slash text-4xl text-gray-300 dark:text-gray-600 mb-3"></i>
                            <p class="text-gray-500 font-medium text-sm">لا توجد دروس حالياً في هذا الكورس.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Security Scripts and Styles -->

<style>
    /* Prevent text and image selection */
    body {
        -webkit-touch-callout: none; /* iOS Safari */
        -webkit-user-select: none; /* Safari */
        -khtml-user-select: none; /* Konqueror HTML */
        -moz-user-select: none; /* Old versions of Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
        user-select: none; /* Non-prefixed version, currently supported by Chrome, Edge, Opera and Firefox */
    }

    /* Hide everything if trying to print */
    @media print {
        html, body {
            display: none !important;
            opacity: 0 !important;
            visibility: hidden !important;
        }
    }

    /* YouTube UI Hiding Hack - Stable Scale Method */
    .youtube-container {
        position: relative;
        overflow: hidden;
        border-radius: 1.5rem;
        width: 100%;
        background: black;
        aspect-ratio: 16/9;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }
    
    .youtube-container .plyr__video-embed {
        /* Zoom in to hide YouTube branding edges */
        transform: scale(1.3);
        transform-origin: center;
        width: 100%;
        height: 100%;
    }

    .youtube-container iframe {
        pointer-events: none !important;
    }

    /* Top Solid Mask to hide title definitively */
    .youtube-container::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 45px;
        background: black;
        z-index: 10;
        pointer-events: none;
    }

    /* Ensure controls are NOT clipped and stay at the bottom of the container */
    .plyr--video .plyr__controls,
    .plyr--video .plyr__control--overlaid {
        z-index: 100 !important;
        pointer-events: auto !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Prevent Right Click (Context Menu)
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });

        // 2. Prevent touch callout / long press on mobile
        document.addEventListener('touchstart', function(e) {
            if (e.target.closest('video, iframe, .plyr')) {
                e.target.style.webkitTouchCallout = 'none';
            }
        }, { passive: true });

        // 3. Prevent Keyboard Shortcuts (DevTools, Save, Print, PrintScreen)
        document.addEventListener('keydown', function(e) {
            // F12
            if (e.key === 'F12' || e.keyCode === 123) {
                e.preventDefault();
                return false;
            }
            // Ctrl+Shift+I / J / C (DevTools)
            if (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J' || e.key === 'C')) {
                e.preventDefault();
                return false;
            }
            // Ctrl+U (Source), Ctrl+S (Save), Ctrl+P (Print)
            if (e.ctrlKey && (e.key === 'U' || e.key === 'u' || e.key === 'S' || e.key === 's' || e.key === 'P' || e.key === 'p')) {
                e.preventDefault();
                return false;
            }
            // PrintScreen / Screenshot shortcut deterrence
            if (e.key === 'PrintScreen') {
                copyToClipboard('غير مسموح بنسخ أو تصوير محتوى الدورة.');
                alert('تحذير: غير مسموح بتصوير الشاشة لحماية حقوق الملكية الفكرية.');
            }
        });

        // Attempt to clear clipboard if PrintScreen is released
        document.addEventListener('keyup', function(e) {
            if (e.key === 'PrintScreen') {
                copyToClipboard('غير مسموح بنسخ أو تصوير محتوى الدورة.');
            }
        });

        function copyToClipboard(text) {
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).catch(err => {});
            }
        }
        
        // Pause player if DevTools opened
        let checkDevTools = function() {
            const widthThreshold = window.outerWidth - window.innerWidth > 160;
            const heightThreshold = window.outerHeight - window.innerHeight > 160;
            if (widthThreshold || heightThreshold) {
                if (window.plyrInstance) window.plyrInstance.pause();
                const videoEl = document.querySelector('video');
                if (videoEl) videoEl.pause();
            }
        };
        window.addEventListener('resize', checkDevTools);
    });
</script>
@endsection
