<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <script>
        // منع الرعشة البيضاء بتطبيق الثيم قبل الرندر
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            document.documentElement.style.colorScheme = 'dark';
        } else {
            document.documentElement.classList.remove('dark');
            document.documentElement.style.colorScheme = 'light';
        }
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'لوحة التحكم') - Xpro</title>
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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        :root {
            --bg-color: #f3f4f6;
            --text-color: #1f2937;
            --sidebar-bg: rgba(255, 255, 255, 0.9);
            --border-color: rgba(0, 0, 0, 0.05);
            --card-bg: #ffffff;
            --card-border: #e5e7eb;
            --card-hover-border: #d1d5db;
        }
        .dark {
            --bg-color: #0b1121;
            --text-color: #c9d1d9;
            --sidebar-bg: rgba(20, 28, 47, 0.8);
            --border-color: rgba(255, 255, 255, 0.05);
            --card-bg: #141c2f;
            --card-border: #1e293b;
            --card-hover-border: #38bdf8;
        }
        body {
            font-family: 'Outfit', 'Noto Sans Arabic', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
        }
        .theme-transition,
        .theme-transition * {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease !important;
        }
        .sidebar-glass {
            background: var(--sidebar-bg);
            backdrop-filter: blur(12px);
            border-left: 1px solid var(--border-color);
        }
        .nav-glass {
            background: var(--sidebar-bg);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--border-color);
        }
        .card-glass {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            transition: all 0.3s ease;
        }
        .card-glass:hover {
            border-color: var(--card-hover-border);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .gradient-text {
            background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .dark .gradient-text {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .active-link {
            background: rgba(245, 158, 11, 0.1) !important;
            color: #ea580c !important;
            border-left-color: #ea580c !important;
        }
        .dark .active-link {
            background: rgba(14, 165, 233, 0.1) !important;
            color: #38bdf8 !important;
            border-left-color: #38bdf8 !important;
        }
        .nav-link {
            border-left: 4px solid transparent;
            transition: all 0.2s ease-in-out;
        }
        
        /* Smooth page entrance removed to prevent flashing */
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--card-border); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--card-hover-border); }
        
        /* Hide scrollbar utility */
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Select & Option Styling Fix */
        select, option {
            background-color: var(--card-bg) !important;
            color: var(--text-color) !important;
        }
        select:focus {
            border-color: #ea580c !important;
            box-shadow: 0 0 0 2px rgba(234, 88, 12, 0.2) !important;
        }
        .dark select:focus {
            border-color: #38bdf8 !important;
            box-shadow: 0 0 0 2px rgba(56, 189, 248, 0.2) !important;
        }
        optgroup {
            background-color: var(--card-bg) !important;
            color: #ea580c !important;
            font-weight: bold !important;
            font-style: normal !important;
        }
        .dark optgroup {
            color: #38bdf8 !important;
        }

    </style>
    <!-- Hotwire Turbo for SPA-like persistent layout transitions without reloading sidebar -->
    <script src="https://cdn.jsdelivr.net/npm/@hotwired/turbo@7.3.0/dist/turbo.es2017-umd.js"></script>
    <meta name="turbo-cache-control" content="no-cache">
</head>
<body class="overflow-hidden" x-data="{ 
    darkMode: document.documentElement.classList.contains('dark'),
    sidebarOpen: false,
    toggleTheme() {
        document.documentElement.classList.add('theme-transition');
        this.darkMode = !this.darkMode;
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
            document.documentElement.style.colorScheme = 'dark';
            localStorage.setItem('theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            document.documentElement.style.colorScheme = 'light';
            localStorage.setItem('theme', 'light');
        }
        setTimeout(() => {
            document.documentElement.classList.remove('theme-transition');
        }, 300);
    }
}">
    <div class="flex h-[100dvh] overflow-hidden">
        
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-[40] bg-black/50 lg:hidden backdrop-blur-sm transition-opacity" x-transition.opacity></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : 'translate-x-full lg:translate-x-0'" 
               class="sidebar-glass w-64 flex-shrink-0 flex flex-col border-l border-[var(--border-color)] fixed lg:static inset-y-0 right-0 z-[50] transition-transform duration-300 ease-in-out">
            <div class="h-20 flex items-center justify-between px-6 border-b border-gray-100/50 dark:border-white/5">
                <a href="{{ route('home') }}" class="text-2xl font-bold gradient-text">Xpro Admin</a>
                <button @click="sidebarOpen = false" class="lg:hidden text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            
            <nav class="flex-1 overflow-y-auto py-4 scrollbar-hide">
                <div class="px-4 mb-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">القائمة الرئيسية</div>
                
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="nav-link flex items-center px-6 py-3 mb-1 transition-colors hover:bg-gray-100 dark:hover:bg-white/5 {{ request()->routeIs('admin.dashboard') ? 'active-link' : '' }}">
                        <i class="fa-solid fa-chart-pie ml-3 w-5 text-center"></i>
                        <span>الإحصائيات العامة</span>
                    </a>
                    <a href="{{ route('admin.stages.index') }}" class="nav-link flex items-center px-6 py-3 mb-1 transition-colors hover:bg-gray-100 dark:hover:bg-white/5 {{ request()->routeIs('admin.stages.*') ? 'active-link' : '' }}">
                        <i class="fa-solid fa-layer-group ml-3 w-5 text-center"></i>
                        <span>إدارة المراحل</span>
                    </a>
                    <a href="{{ route('admin.grades.index') }}" class="nav-link flex items-center px-6 py-3 mb-1 transition-colors hover:bg-gray-100 dark:hover:bg-white/5 {{ request()->routeIs('admin.grades.*') ? 'active-link' : '' }}">
                        <i class="fa-solid fa-stairs ml-3 w-5 text-center"></i>
                        <span>إدارة الصفوف</span>
                    </a>
                    <a href="{{ route('admin.subjects.index') }}" class="nav-link flex items-center px-6 py-3 mb-1 transition-colors hover:bg-gray-100 dark:hover:bg-white/5 {{ request()->routeIs('admin.subjects.*') ? 'active-link' : '' }}">
                        <i class="fa-solid fa-book ml-3 w-5 text-center"></i>
                        <span>إدارة المواد</span>
                    </a>

                    <a href="{{ route('admin.teachers.index') }}" class="nav-link flex items-center px-6 py-3 mb-1 transition-colors hover:bg-gray-100 dark:hover:bg-white/5 {{ request()->routeIs('admin.teachers.*') ? 'active-link' : '' }}">
                        <i class="fa-solid fa-user-tie ml-3 w-5 text-center"></i>
                        <span>المعلمون</span>
                    </a>
                    <a href="{{ route('admin.students.index') }}" class="nav-link flex items-center px-6 py-3 mb-1 transition-colors hover:bg-gray-100 dark:hover:bg-white/5 {{ request()->routeIs('admin.students.*') ? 'active-link' : '' }}">
                        <i class="fa-solid fa-user-graduate ml-3 w-5 text-center"></i>
                        <span>الطلاب</span>
                    </a>
                    <a href="{{ route('admin.finance.index') }}" class="nav-link flex items-center px-6 py-3 mb-1 transition-colors hover:bg-gray-100 dark:hover:bg-white/5 {{ request()->routeIs('admin.finance.*') ? 'active-link' : '' }}">
                        <i class="fa-solid fa-wallet ml-3 w-5 text-center"></i>
                        <span>الشؤون المالية</span>
                    </a>
                    <a href="{{ route('admin.messages.index') }}" class="nav-link flex items-center px-6 py-3 mb-1 transition-colors hover:bg-gray-100 dark:hover:bg-white/5 {{ request()->routeIs('admin.messages.*') ? 'active-link' : '' }}">
                        <i class="fa-solid fa-envelope ml-3 w-5 text-center"></i>
                        <span>رسائل التواصل</span>
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="nav-link flex items-center px-6 py-3 mb-1 transition-colors hover:bg-gray-100 dark:hover:bg-white/5 {{ request()->routeIs('admin.settings.*') ? 'active-link' : '' }}">
                        <i class="fa-solid fa-gears ml-3 w-5 text-center"></i>
                        <span>إعدادات المنصة</span>
                    </a>
                    <a href="{{ route('admin.faqs.index') }}" class="nav-link flex items-center px-6 py-3 mb-1 transition-colors hover:bg-gray-100 dark:hover:bg-white/5 {{ request()->routeIs('admin.faqs.*') ? 'active-link' : '' }}">
                        <i class="fa-solid fa-circle-question ml-3 w-5 text-center"></i>
                        <span>الأسئلة الشائعة</span>
                    </a>
                @elseif(auth()->user()->isTeacher())
                    @if(auth()->user()->is_approved)
                        <a href="{{ route('teacher.dashboard') }}" class="nav-link flex items-center px-6 py-3 mb-1 transition-colors hover:bg-gray-100 dark:hover:bg-white/5 {{ request()->routeIs('teacher.dashboard') ? 'active-link' : '' }}">
                            <i class="fa-solid fa-gauge-high ml-3 w-5 text-center"></i>
                            <span>نظرة عامة</span>
                        </a>
                        <a href="{{ route('teacher.courses.index') }}" class="nav-link flex items-center px-6 py-3 mb-1 transition-colors hover:bg-gray-100 dark:hover:bg-white/5 {{ request()->routeIs('teacher.courses.*') ? 'active-link' : '' }}">
                            <i class="fa-solid fa-file-video ml-3 w-5 text-center"></i>
                            <span>كورساتي</span>
                        </a>
                        <a href="{{ route('payments.teacher') }}" class="nav-link flex items-center px-6 py-3 mb-1 transition-colors hover:bg-gray-100 dark:hover:bg-white/5 {{ request()->routeIs('payments.teacher') ? 'active-link' : '' }}">
                            <i class="fa-solid fa-user-check ml-3 w-5 text-center"></i>
                            <span>طلبات التفعيل</span>
                        </a>
                        <a href="{{ route('teacher.enrollments.create') }}" class="nav-link flex items-center px-6 py-3 mb-1 transition-colors hover:bg-gray-100 dark:hover:bg-white/5 {{ request()->routeIs('teacher.enrollments.create') ? 'active-link' : '' }}">
                            <i class="fa-solid fa-user-plus ml-3 w-5 text-center"></i>
                            <span>تفعيل كورس لطالب</span>
                        </a>
                        <a href="{{ route('teacher.courses.create') }}" class="nav-link flex items-center px-6 py-3 mb-1 transition-colors hover:bg-gray-100 dark:hover:bg-white/5 {{ request()->routeIs('teacher.courses.create') ? 'active-link' : '' }}">
                            <i class="fa-solid fa-plus-circle ml-3 w-5 text-center"></i>
                            <span>إضافة كورس</span>
                        </a>
                        <a href="{{ route('teacher.earnings.index') }}" class="nav-link flex items-center px-6 py-3 mb-1 transition-colors hover:bg-gray-100 dark:hover:bg-white/5 {{ request()->routeIs('teacher.earnings.index') ? 'active-link' : '' }}">
                            <i class="fa-solid fa-coins ml-3 w-5 text-center"></i>
                            <span>الأرباح والعمولات</span>
                        </a>
                    @else
                        <a href="{{ route('teacher.pending') }}" class="nav-link flex items-center px-6 py-3 mb-1 transition-colors hover:bg-gray-100 dark:hover:bg-white/5 {{ request()->routeIs('teacher.pending') ? 'active-link' : '' }}">
                            <i class="fa-solid fa-clock ml-3 w-5 text-center"></i>
                            <span>حالة الطلب</span>
                        </a>
                    @endif

                @elseif(auth()->user()->isStudent())
                    <a href="{{ route('dashboard') }}" class="nav-link flex items-center px-6 py-3 mb-1 transition-colors hover:bg-gray-100 dark:hover:bg-white/5 {{ request()->routeIs('dashboard') ? 'active-link' : '' }}">
                        <i class="fa-solid fa-book-open ml-3 w-5 text-center"></i>
                        <span>كورساتي</span>
                    </a>
                    <a href="{{ route('payments.student') }}" class="nav-link flex items-center px-6 py-3 mb-1 transition-colors hover:bg-gray-100 dark:hover:bg-white/5 {{ request()->routeIs('payments.student') ? 'active-link' : '' }}">
                        <i class="fa-solid fa-receipt ml-3 w-5 text-center"></i>
                        <span>سجل الدفعات</span>
                    </a>
                    <a href="{{ route('home') }}" class="nav-link flex items-center px-6 py-3 mb-1 transition-colors hover:bg-gray-100 dark:hover:bg-white/5">
                        <i class="fa-solid fa-magnifying-glass ml-3 w-5 text-center"></i>
                        <span>تصفح المواد</span>
                    </a>
                @endif


                <div class="mt-8 px-4 mb-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">الإعدادات</div>
                <a href="{{ route('profile.edit') }}" class="flex items-center px-6 py-3 mb-1 transition-colors hover:bg-gray-100 dark:hover:bg-white/5 text-[var(--text-color)]">
                    <i class="fa-solid fa-user-gear ml-3 w-5 text-center"></i>
                    <span>الملف الشخصي</span>
                </a>
                
                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-6 py-3 text-red-500 dark:text-red-400 hover:bg-red-500/10 transition-colors">
                        <i class="fa-solid fa-right-from-bracket ml-3 w-5 text-center"></i>
                        <span>تسجيل الخروج</span>
                    </button>
                </form>

            </nav>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            <!-- Top Navbar -->
            <header class="sidebar-glass h-20 flex items-center justify-between px-4 lg:px-8 flex-shrink-0 border-b border-[var(--border-color)]">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="lg:hidden ml-4 text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400 hidden sm:block">@yield('page-title', 'لوحة التحكم')</h2>
                </div>

                <div class="flex items-center space-x-3 sm:space-x-6 space-x-reverse">
                    <!-- Theme Toggle Button -->
                    <button @click="toggleTheme()" 
                            class="w-10 h-10 rounded-xl flex items-center justify-center transition-all bg-gray-100 hover:bg-gray-200 dark:bg-white/5 dark:hover:bg-white/10 ml-2 sm:ml-4 group">
                        <i class="fa-solid fa-moon text-amber-500 text-lg" x-show="!darkMode"></i>
                        <i class="fa-solid fa-sun text-sky-400 text-lg" x-show="darkMode" style="display: none;"></i>
                    </button>

                    <div class="flex flex-col text-left border-r border-gray-200 dark:border-white/10 pr-2 sm:pr-4 hidden sm:flex">
                        <span class="text-sm font-bold text-[var(--text-color)]">{{ auth()->user()->name }}</span>
                        <span class="text-[10px] text-gray-500">{{ auth()->user()->role == 'admin' ? 'مدير النظام' : (auth()->user()->role == 'teacher' ? (auth()->user()->is_approved ? 'معلم معتمد' : 'معلم قيد المراجعة') : 'طالب') }}</span>
                    </div>
                    <div class="w-12 h-12 rounded-2xl overflow-hidden shadow-lg border border-gray-200 dark:border-white/10">
                        @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-full h-full object-cover" alt="{{ auth()->user()->name }}">
                        @else
                            <div class="w-full h-full bg-gradient-to-tr from-amber-500 to-orange-600 dark:from-sky-500 dark:to-indigo-600 flex items-center justify-center text-white font-bold text-xl uppercase">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                </div>
            </header>

            <!-- Scrollable Content -->
             <main class="flex-1 overflow-y-auto p-4 pb-24 sm:p-8 sm:pb-8 relative scrollbar-hide">
                <div class="max-w-7xl mx-auto w-full overflow-x-hidden">
                    @yield('content')
                </div>

                <!-- Global Toast Notifications -->
                <div x-data="{ 
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
                class="fixed top-20 left-8 z-[100] flex flex-col gap-3 pointer-events-none w-full max-w-sm">
                    
                    <template x-for="toast in toasts" :key="toast.id">
                        <div x-show="toast.show"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 -translate-x-full"
                             x-transition:enter-end="opacity-100 translate-x-0"
                             x-transition:leave="transition ease-in duration-300"
                             x-transition:leave-start="opacity-100 translate-x-0"
                             x-transition:leave-end="opacity-0 -translate-x-full"
                             class="pointer-events-auto flex items-center p-4 rounded-2xl border backdrop-blur-xl shadow-2xl bg-white dark:bg-[#141c2f]"
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
                            <div class="ml-auto text-sm font-bold text-[var(--text-color)] dark:text-white" x-text="toast.message"></div>
                            <button @click="remove(toast.id)" class="mr-4 text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition">
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
                class="fixed inset-0 z-[110] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
                x-cloak
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
                    
                    <div class="bg-white dark:bg-[#161b22] border border-gray-200 dark:border-white/10 w-full max-w-md rounded-3xl p-8 shadow-2xl scale-up" @click.away="show = false">
                        <div class="text-center">
                            <div class="w-20 h-20 mx-auto mb-6 rounded-2xl flex items-center justify-center text-3xl"
                                 :class="{
                                    'bg-red-500/10 text-red-500': type === 'danger',
                                    'bg-amber-500/10 text-amber-500': type === 'warning',
                                    'bg-sky-500/10 text-sky-500': type === 'info'
                                 }">
                                <i class="fa-solid" :class="{
                                    'fa-trash-can': type === 'danger',
                                    'fa-triangle-exclamation': type === 'warning',
                                    'fa-circle-info': type === 'info'
                                }"></i>
                            </div>
                            
                            <h3 class="text-2xl font-bold text-[var(--text-color)] dark:text-white mb-2" x-text="title"></h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-8 leading-relaxed" x-text="message"></p>
                            
                            <div class="flex space-x-4 space-x-reverse">
                                <button @click="confirm()" 
                                        class="flex-1 py-4 rounded-xl transition text-white font-bold shadow-lg"
                                        :class="{
                                            'bg-red-500 hover:bg-red-600 shadow-red-500/20': type === 'danger',
                                            'bg-amber-500 hover:bg-amber-600 shadow-amber-500/20': type === 'warning',
                                            'bg-sky-500 hover:bg-sky-600 shadow-sky-500/20': type === 'info'
                                        }"
                                        x-text="confirmText">
                                </button>
                                <button @click="show = false" class="flex-1 py-4 rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-white/5 dark:hover:bg-white/10 transition text-gray-700 dark:text-white font-bold">
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
        </div>
    </div>
</body>
</html>
