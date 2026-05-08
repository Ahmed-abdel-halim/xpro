<!DOCTYPE html>
<html lang="ar" dir="rtl" x-data="{ 
    darkMode: localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)
}" :class="{ 'dark': darkMode }">
<head>
    <style>
        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 rgba(37, 211, 102, 0.7);
            }
            70% {
                transform: scale(1.1);
                box-shadow: 0 0 15px rgba(37, 211, 102, 0);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 rgba(37, 211, 102, 0);
            }
        }
        @keyframes ripple {
            0% {
                transform: scale(0.8);
                opacity: 1;
            }
            100% {
                transform: scale(1.4);
                opacity: 0;
            }
        }
        .whatsapp-float {
            animation: pulse 2s infinite;
            position: relative;
            overflow: visible;
        }
        .whatsapp-tooltip {
            position: absolute;
            bottom: auto;
            top: calc(100% + 2px);
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 11px;
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.3s;
            pointer-events: none;
            min-width: 100px;
            text-align: center;
            z-index: 9999;
        }
        .whatsapp-float:hover .whatsapp-tooltip {
            opacity: 1;
        }
        .pulse-ripple {
            position: absolute;
            top: 0;
            left: 0;
            transform: none;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            animation: ripple 1.5s infinite;
            z-index: -1;
        }
    </style>
    <script>
        // منع الرعشة البيضاء بتطبيق الثيم قبل الرندر
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Xpro - @yield('title', 'منصة التعليم الحديثة')</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><rect width=%22100%22 height=%22100%22 rx=%2220%22 fill=%22%23fbbf24%22/><text y=%22.9em%22 font-size=%2270%22 x=%2250%%22 text-anchor=%22middle%22 font-family=%22serif%22 fill=%22white%22>🎓</text></svg>">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {}
            }
        }
    </script>
    <!-- FontAwesome for Real Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Noto+Sans+Arabic:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Plyr Player Assets -->
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    <script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>

    <style>
        :root {
            --bg-color: #FFF9ED;
            --text-color: #00555A;
            --nav-bg: #00555A;
            --card-bg: rgba(255, 255, 255, 0.4);
            --accent-color: #00555a;
        }
        .dark {
            --bg-color: #0b1121;
            --text-color: #f1f5f9;
            --nav-bg: #0b1121;
            --card-bg: #141c2f;
            --accent-color: #f97316;
        }
        html {
            scroll-behavior: smooth;
        }
        [x-cloak] { display: none !important; }
        
        body {
            font-family: 'Outfit', 'Noto Sans Arabic', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .glass {
            background: var(--nav-bg);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff !important;
        }
        .gradient-text {
            background: linear-gradient(135deg, #00555A 0%, #00888C 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
            padding-bottom: 0.4em;
            line-height: 1.6;
        }
        .dark .gradient-text {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent !important;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px -10px rgba(0, 85, 90, 0.2);
            border-color: rgba(0, 85, 90, 0.4);
        }

        /* Force Navbar text to be white - refined to exclude buttons */
        nav .nav-link, nav span:not(.logo-cap), nav .user-name {
            color: #ffffff !important;
        }
        .dark nav .nav-link, .dark nav span:not(.logo-cap), .dark nav .user-name {
            color: #ffffff !important;
        }
        
        /* Footer Background */
        footer {
            background-color: #00555A !important;
            color: #ffffff !important;
        }
        .dark footer {
            background-color: var(--nav-bg) !important;
        }
        footer p {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .dark .text-gray-600, .dark .text-gray-500, .dark .text-gray-400 {
            color: #cbd5e1 !important;
        }
        .dark h1, .dark h2, .dark h3 {
            color: #ffffff !important;
        }
        .dark nav a, .dark nav span, .dark nav div:not([class*="bg-"]) {
            color: #ffffff !important;
        }

        /* Animated Waves Config */
        .waves-container {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 35vh;
            min-height: 250px;
            max-height: 400px;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }

        .waves {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .parallax > use {
            animation: move-forever 25s cubic-bezier(.55,.5,.45,.5) infinite;
        }
        .parallax > use:nth-child(1) {
            animation-delay: -2s;
            animation-duration: 7s;
        }
        .parallax > use:nth-child(2) {
            animation-delay: -3s;
            animation-duration: 10s;
        }
        .parallax > use:nth-child(3) {
            animation-delay: -4s;
            animation-duration: 13s;
        }
        .parallax > use:nth-child(4) {
            animation-delay: -5s;
            animation-duration: 20s;
        }
        
        @keyframes move-forever {
            0% { transform: translate3d(-90px,0,0); }
            100% { transform: translate3d(85px,0,0); }
        }

        /* Adjust content z-index so it sits above waves */
        .main-content-wrapper {
            position: relative;
            z-index: 10;
        }

    </style>
</head>
<body class="min-h-screen bg-[var(--bg-color)] flex flex-col relative overflow-x-hidden">
    <!-- Animated Waves Background -->
    <div class="waves-container">
        <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
            <defs>
                <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
            </defs>
            <g class="parallax">
                <use xlink:href="#gentle-wave" x="48" y="0" class="fill-amber-500/10 dark:fill-sky-500/10" />
                <use xlink:href="#gentle-wave" x="48" y="3" class="fill-emerald-500/10 dark:fill-purple-500/10" />
                <use xlink:href="#gentle-wave" x="48" y="5" class="fill-sky-500/10 dark:fill-amber-500/10" />
                <use xlink:href="#gentle-wave" x="48" y="7" class="fill-[#00555A]/5 dark:fill-white/5" />
            </g>
        </svg>
    </div>

    <!-- Navigation -->
    <nav class="glass sticky top-0 z-[900] px-6 py-4 transition-all duration-300 w-full">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-16 space-x-reverse">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 space-x-reverse group">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500 dark:bg-sky-600 flex items-center justify-center text-white shadow-xl group-hover:scale-110 transition-all duration-300">
                        <i class="fa-solid fa-graduation-cap text-xl"></i>
                    </div>
                    <span class="text-2xl font-black text-white transition-colors">Xpro</span>
                </a>
                <div class="hidden lg:flex space-x-6 space-x-reverse mr-12">
                    <a href="{{ route('home') }}" class="nav-link text-white hover:text-white/80 transition-all font-black text-sm tracking-wide">الرئيسية</a>
                    <a href="{{ route('about') }}" class="nav-link text-white hover:text-white/80 transition-all font-black text-sm tracking-wide">عن المنصة</a>
                    <a href="{{ route('services') }}" class="nav-link text-white hover:text-white/80 transition-all font-black text-sm tracking-wide">خدماتنا</a>
                    <a href="{{ route('faq') }}" class="nav-link text-white hover:text-white/80 transition-all font-black text-sm tracking-wide">الأسئلة الشائعة</a>
                    <a href="{{ route('contact') }}" class="nav-link text-white hover:text-white/80 transition-all font-black text-sm tracking-wide">تواصل معنا</a>
                </div>

            </div>
            <div class="flex items-center space-x-3 space-x-reverse md:space-x-6">
                <!-- Theme Switcher -->
                <button @click="darkMode = !darkMode; localStorage.setItem('theme', darkMode ? 'dark' : 'light')" 
                        class="w-12 h-12 rounded-2xl flex items-center justify-center transition-all bg-gray-100 dark:bg-white/10 hover:bg-gray-200 dark:hover:bg-white/20 text-gray-600 dark:text-white border border-gray-200 dark:border-white/20 shadow-sm dark:shadow-lg">
                    <i class="fa-solid text-xl" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
                </button>

                @guest
                    <a href="{{ route('login') }}" class="nav-link text-white hover:text-white/80 transition font-black text-base hidden md:block">دخول</a>
                    <a href="{{ route('register') }}" class="px-8 py-3.5 rounded-2xl bg-[#fbbf24] hover:bg-[#f59e0b] text-[#00555A] dark:bg-sky-600 dark:hover:bg-sky-700 dark:text-white transition-all font-black text-base shadow-xl shadow-amber-500/20 dark:shadow-sky-600/20">سجل الآن</a>
                @else
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center space-x-3 space-x-reverse focus:outline-none group">
                            <div class="hidden md:flex flex-col text-left items-end">
                                <span class="user-name text-base font-black text-white group-hover:text-white/80 transition">{{ auth()->user()->name }}</span>
                                <span class="user-name text-[10px] text-white/60 font-black uppercase tracking-widest">{{ auth()->user()->role }}</span>
                            </div>
                            <div class="w-12 h-12 rounded-2xl overflow-hidden border-2 border-gray-100 dark:border-white/20 group-hover:border-sky-600 dark:group-hover:border-white shadow-xl transition-all duration-300">
                                @if(auth()->user()->avatar)
                                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-amber-500 dark:bg-sky-600 flex items-center justify-center text-white font-black text-lg">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                        </button>

                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                             class="absolute left-0 mt-4 w-56 bg-white dark:bg-[#1e293b] border border-gray-100 dark:border-white/10 rounded-[24px] shadow-2xl py-3 z-[100] backdrop-blur-3xl" x-cloak>
                            
                            <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-4 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-sky-600 transition-all font-bold">
                                <i class="fa-solid fa-gauge-high ml-3 w-5 text-center"></i> لوحة التحكم
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center px-6 py-4 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-sky-600 transition-all font-bold">
                                <i class="fa-solid fa-user-gear ml-3 w-5 text-center"></i> الملف الشخصي
                            </a>
                            <div class="border-t border-gray-100 dark:border-white/5 my-2 mx-4"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-6 py-4 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-500/5 transition-all font-bold">
                                    <i class="fa-solid fa-right-from-bracket ml-3 w-5 text-center"></i> خروج
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest

                <!-- Mobile Menu Button -->
                <div class="lg:hidden relative" x-data="{ mobileMenuOpen: false }">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" @click.away="mobileMenuOpen = false" class="w-12 h-12 rounded-2xl flex items-center justify-center transition-all bg-gray-100 dark:bg-white/10 hover:bg-gray-200 dark:hover:bg-white/20 text-gray-600 dark:text-white border border-gray-200 dark:border-white/20 shadow-sm dark:shadow-lg">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <!-- Mobile Dropdown -->
                    <div x-show="mobileMenuOpen" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                         class="absolute left-0 mt-4 w-48 bg-white dark:bg-[#1e293b] border border-gray-100 dark:border-white/10 rounded-[24px] shadow-2xl py-3 z-[100] backdrop-blur-3xl" x-cloak>
                        
                        <a href="{{ route('home') }}" class="flex items-center px-6 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-sky-600 transition-all font-bold">
                            <i class="fa-solid fa-house ml-3 w-5 text-center"></i> الرئيسية
                        </a>
                        <a href="{{ route('about') }}" class="flex items-center px-6 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-sky-600 transition-all font-bold">
                            <i class="fa-solid fa-circle-info ml-3 w-5 text-center"></i> عن المنصة
                        </a>
                        <a href="{{ route('contact') }}" class="flex items-center px-6 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-sky-600 transition-all font-bold">
                            <i class="fa-solid fa-envelope ml-3 w-5 text-center"></i> تواصل معنا
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main x-data="{ 
        toasts: [],
        add(message, type = 'success') {
            const id = Date.now();
            this.toasts.push({ id, message, type, show: false });
            this.$nextTick(() => {
                const t = this.toasts.find(t => t.id === id);
                if (t) t.show = true;
            });
            setTimeout(() => this.remove(id), 5000);
        },
        remove(id) {
            const t = this.toasts.find(t => t.id === id);
            if (t) {
                t.show = false;
                setTimeout(() => {
                    this.toasts = this.toasts.filter(t => t.id !== id);
                }, 400);
            }
        }
    }" 
    @toast.window="add($event.detail.message, $event.detail.type)"
    class="w-full max-w-7xl mx-auto px-6 py-12 relative main-content-wrapper flex-grow min-h-[70vh]">
        @yield('content')

        <!-- Global Toast Notifications -->
        <div class="fixed top-24 left-8 z-[999] flex flex-col gap-3 pointer-events-none w-full max-w-sm">
            <template x-for="toast in toasts" :key="toast.id">
                <div x-show="toast.show"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 -translate-x-full"
                     x-transition:enter-end="opacity-100 translate-x-0"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 translate-x-0"
                     x-transition:leave-end="opacity-0 -translate-x-full"
                     class="pointer-events-auto flex items-center p-4 rounded-2xl border backdrop-blur-xl shadow-2xl"
                     :class="{
                        'bg-green-500/10 border-green-500/20 text-green-400': toast.type === 'success',
                        'bg-red-500/10 border-red-500/20 text-red-400': toast.type === 'error',
                        'bg-sky-500/10 border-sky-500/20 text-sky-400': toast.type === 'info'
                     }">
                    <div class="ml-3 flex-shrink-0">
                        <i class="fa-solid" :class="{
                            'fa-circle-check': toast.type === 'success',
                            'fa-circle-xmark': toast.type === 'error',
                            'fa-circle-info': toast.type === 'info'
                        }"></i>
                    </div>
                    <div class="ml-auto text-sm font-bold" x-text="toast.message"></div>
                    <button @click="remove(toast.id)" class="mr-4 text-gray-400 hover:text-white transition">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </template>

            {{-- Init from Session --}}
            <span x-init="
                @if(session('success')) add('{{ session('success') }}', 'success'); @endif
                @if(session('error')) add('{{ session('error') }}', 'error'); @endif
                @if(session('status')) add('{{ session('status') }}', 'info'); @endif
            " class="hidden"></span>
        </div>

        <!-- Global Confirmation Modal -->
        <div x-data="{ 
            show: false, 
            title: 'تأكيد الإجراء',
            message: '', 
            onConfirm: null,
            confirmText: 'تأكيد',
            cancelText: 'إلغاء',
            type: 'danger',
            open(options) {
                this.title = options.title || 'تأكيد الإجراء';
                this.message = options.message || '';
                this.onConfirm = options.onConfirm;
                this.confirmText = options.confirmText || 'تأكيد';
                this.type = options.type || 'danger';
                this.show = true;
            },
            confirm() {
                if (this.onConfirm) this.onConfirm();
                this.show = false;
            }
        }" 
        @confirm.window="open($event.detail)"
        x-show="show" 
        class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
            
            <div class="bg-[#0f172a] border border-white/10 w-full max-w-md rounded-3xl p-8 shadow-2xl scale-up" @click.away="show = false">
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-2xl flex items-center justify-center text-3xl"
                         :class="{
                            'bg-red-500/10 text-red-500': type === 'danger',
                            'bg-yellow-500/10 text-yellow-500': type === 'warning',
                            'bg-sky-500/10 text-sky-500': type === 'info'
                         }">
                        <i class="fa-solid" :class="{
                            'fa-trash-can': type === 'danger',
                            'fa-triangle-exclamation': type === 'warning',
                            'fa-circle-info': type === 'info'
                        }"></i>
                    </div>
                    
                    <h3 class="text-2xl font-bold text-white mb-2" x-text="title"></h3>
                    <p class="text-gray-400 mb-8 leading-relaxed" x-text="message"></p>
                    
                    <div class="flex space-x-4 space-x-reverse">
                        <button @click="confirm()" 
                                class="flex-1 py-4 rounded-xl transition text-white font-bold shadow-lg"
                                :class="{
                                    'bg-red-500 hover:bg-red-600 shadow-red-500/20': type === 'danger',
                                    'bg-yellow-500 hover:bg-yellow-600 shadow-yellow-500/20': type === 'warning',
                                    'bg-sky-500 hover:bg-sky-600 shadow-sky-500/20': type === 'info'
                                }"
                                x-text="confirmText">
                        </button>
                        <button @click="show = false" class="flex-1 py-4 rounded-xl bg-white/5 hover:bg-white/10 transition text-white font-bold">
                            إلغاء
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <style>
            [x-cloak] { display: none !important; }
            .scale-up {
                animation: scaleUp 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            }
            @keyframes scaleUp {
                from { transform: scale(0.9); opacity: 0; }
                to { transform: scale(1); opacity: 1; }
            }
        </style>

        <script>
            window.confirmAction = function(message, callback, title = 'تأكيد الحذف', type = 'danger') {
                window.dispatchEvent(new CustomEvent('confirm', { 
                    detail: { 
                        title: title,
                        message: message, 
                        type: type,
                        onConfirm: callback 
                    } 
                }));
            };

            // Auto-intercept forms with data-confirm attribute
            document.addEventListener('submit', (e) => {
                const form = e.target;
                if (form.hasAttribute('data-confirm') && !form.dataset.confirmed) {
                    e.preventDefault();
                    window.confirmAction(form.getAttribute('data-confirm'), () => {
                        form.dataset.confirmed = 'true';
                        form.submit();
                    });
                }
            });
        </script>
    </main>

    <!-- Footer -->
    <footer class="glass mt-auto border-t border-white/10 relative z-10 w-full">
        <!-- Main Footer Content -->
        <div class="bg-gradient-to-br from-[#004d40]/95 to-[#00695c]/95 dark:from-gray-800/95 dark:to-gray-700/95 backdrop-blur-md">
            <div class="max-w-7xl mx-auto px-6 py-16">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                    
                    <!-- About Section -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 rounded-2xl bg-amber-500 dark:bg-sky-600 flex items-center justify-center text-white shadow-lg">
                                <i class="fa-solid fa-graduation-cap text-xl"></i>
                            </div>
                            <span class="text-2xl font-black text-white">Xpro</span>
                        </div>
                        <p class="text-gray-300 leading-relaxed">
                            منصة تعليمية رائدة تقدم محتوى تعليمي عالي الجودة للطلاب في جميع المراحل الدراسية
                        </p>
                        <div class="flex items-center gap-4 pt-4">
                            @if(!empty($settings['social_facebook']))
                            <a href="{{ $settings['social_facebook'] }}" target="_blank" class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 transition-all duration-300 flex items-center justify-center text-white hover:scale-110">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                            @endif

                            @if(!empty($settings['social_instagram']))
                            <a href="{{ $settings['social_instagram'] }}" target="_blank" class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 transition-all duration-300 flex items-center justify-center text-white hover:scale-110">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                            @endif

                            @if(!empty($settings['social_twitter']))
                            <a href="{{ $settings['social_twitter'] }}" target="_blank" class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 transition-all duration-300 flex items-center justify-center text-white hover:scale-110">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                            @endif

                            @if(!empty($settings['social_youtube']))
                            <a href="{{ $settings['social_youtube'] }}" target="_blank" class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 transition-all duration-300 flex items-center justify-center text-white hover:scale-110">
                                <i class="fa-brands fa-youtube"></i>
                            </a>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="space-y-4">
                        <h3 class="text-xl font-black text-white mb-6">روابط سريعة</h3>
                        <ul class="space-y-3">
                            <li>
                                <a href="{{ route('home') }}" class="text-gray-300 hover:text-amber-400 dark:hover:text-sky-400 transition-colors duration-300 flex items-center gap-2">
                                    <i class="fa-solid fa-chevron-left text-xs"></i>
                                    الرئيسية
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('about') }}" class="text-gray-300 hover:text-amber-400 dark:hover:text-sky-400 transition-colors duration-300 flex items-center gap-2">
                                    <i class="fa-solid fa-chevron-left text-xs"></i>
                                    عن المنصة
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('services') }}" class="text-gray-300 hover:text-amber-400 dark:hover:text-sky-400 transition-colors duration-300 flex items-center gap-2">
                                    <i class="fa-solid fa-chevron-left text-xs"></i>
                                    خدماتنا
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('faq') }}" class="text-gray-300 hover:text-amber-400 dark:hover:text-sky-400 transition-colors duration-300 flex items-center gap-2">
                                    <i class="fa-solid fa-chevron-left text-xs"></i>
                                    الأسئلة الشائعة
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('contact') }}" class="text-gray-300 hover:text-amber-400 dark:hover:text-sky-400 transition-colors duration-300 flex items-center gap-2">
                                    <i class="fa-solid fa-chevron-left text-xs"></i>
                                    تواصل معنا
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Services -->
                    <div class="space-y-4">
                        <h3 class="text-xl font-black text-white mb-6">المراحل الدراسية</h3>
                        <ul class="space-y-3">
                            <li>
                                <a href="{{ route('stage.show', 1) }}" class="text-gray-300 hover:text-amber-400 dark:hover:text-sky-400 transition-colors duration-300 flex items-center gap-2">
                                    <i class="fa-solid fa-chevron-left text-xs"></i>
                                    المرحلة الابتدائية
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('stage.show', 2) }}" class="text-gray-300 hover:text-amber-400 dark:hover:text-sky-400 transition-colors duration-300 flex items-center gap-2">
                                    <i class="fa-solid fa-chevron-left text-xs"></i>
                                    المرحلة الإعدادية
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('stage.show', 3) }}" class="text-gray-300 hover:text-amber-400 dark:hover:text-sky-400 transition-colors duration-300 flex items-center gap-2">
                                    <i class="fa-solid fa-chevron-left text-xs"></i>
                                    المرحلة الثانوية
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('stage.show', 4) }}" class="text-gray-300 hover:text-amber-400 dark:hover:text-sky-400 transition-colors duration-300 flex items-center gap-2">
                                    <i class="fa-solid fa-chevron-left text-xs"></i>
                                    التعليم الجامعي
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('stage.show', 5) }}" class="text-gray-300 hover:text-amber-400 dark:hover:text-sky-400 transition-colors duration-300 flex items-center gap-2">
                                    <i class="fa-solid fa-chevron-left text-xs"></i>
                                    سوق العمل
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div class="space-y-4">
                        <h3 class="text-xl font-black text-white mb-6">تواصل معنا</h3>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-amber-500/20 dark:bg-sky-500/20 flex items-center justify-center flex-shrink-0 mt-1">
                                    <i class="fa-solid fa-phone text-amber-400 dark:text-sky-400 text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-gray-300">الهاتف</p>
                                    <p class="text-white font-black">{{ $settings['contact_phone'] ?? '01551322666' }}</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-amber-500/20 dark:bg-sky-500/20 flex items-center justify-center flex-shrink-0 mt-1">
                                    <i class="fa-solid fa-envelope text-amber-400 dark:text-sky-400 text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-gray-300">البريد الإلكتروني</p>
                                    <p class="text-white font-black">{{ $settings['contact_email'] ?? 'info@xpro.com' }}</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-amber-500/20 dark:bg-sky-500/20 flex items-center justify-center flex-shrink-0 mt-1">
                                    <i class="fa-solid fa-location-dot text-amber-400 dark:text-sky-400 text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-gray-300">العنوان</p>
                                    <p class="text-white font-black">{{ $settings['contact_address'] ?? 'مصر' }}</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="bg-[#003d33] dark:bg-gray-900 border-t border-white/5">
            <div class="max-w-7xl mx-auto px-6 py-6 text-center">
                <p class="text-gray-400 text-sm mb-4">
                    &copy; {{ date('Y') }} Xpro. جميع الحقوق محفوظة. للتعليم التفاعلي في متناول الجميع
                </p>
                <p class="text-gray-400 text-sm mb-4 border-b border-gray-700 pb-4">
                    تم التصميم والتطوير بواسطة 
                    <a href="https://www.facebook.com/profile.php?id=100072479525246" target="_blank" class="text-amber-400 hover:text-amber-300 dark:text-sky-400 dark:hover:text-sky-300 transition-colors duration-300">
                        Codinity Tech
                    </a>
                </p>
                <div class="flex flex-wrap justify-center items-center gap-6 text-sm">
                    <a href="{{ route('privacy-policy') }}" class="text-gray-400 hover:text-amber-400 dark:hover:text-sky-400 transition-colors duration-300">
                        سياسة الخصوصية
                    </a>
                    <a href="{{ route('terms-and-conditions') }}" class="text-gray-400 hover:text-amber-400 dark:hover:text-sky-400 transition-colors duration-300">
                        الشروط والأحكام
                    </a>
                </div>
            </div>
        </div>
    </footer>
    @stack('scripts')

    <!-- Floating WhatsApp Button -->
    @php
        $whatsappNumber = $settings['contact_whatsapp'] ?? '201551322666';
        $whatsappUrl = "https://wa.me/" . preg_replace('/[^0-9]/', '', $whatsappNumber) . "?text=" . urlencode("السلام عليكم، أود الاستفسار عن خدمات منصة Xpro");
    @endphp
    <a href="{{ $whatsappUrl }}" target="_blank" 
       class="fixed bottom-6 right-6 w-16 h-16 bg-[#25D366] hover:bg-[#128C7E] text-white rounded-full shadow-2xl flex items-center justify-center transition-all duration-300 hover:scale-110 z-50 whatsapp-float" 
       title="تواصل معنا عبر واتساب">
        <i class="fa-brands fa-whatsapp text-3xl"></i>
        <span class="pulse-ripple"></span>
        <div class="whatsapp-tooltip">تواصل معنا</div>
    </a>
</body>
</html>
