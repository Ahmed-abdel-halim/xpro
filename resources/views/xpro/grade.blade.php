@extends('layouts.app')

@section('title', $grade->name)

@section('content')
<div class="py-12">
    <div class="bg-white dark:bg-[#141c2f] border border-gray-100 dark:border-white/10 p-8 md:p-10 rounded-[32px] shadow-2xl shadow-gray-200/50 dark:shadow-none mb-14 relative overflow-hidden flex flex-col items-start right-align-fix text-right w-full">
        <!-- Decoration -->
        <div class="absolute -top-24 -left-24 w-64 h-64 bg-amber-500/10 dark:bg-sky-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 w-full h-1 bg-gradient-to-r from-amber-500 to-amber-300 dark:from-sky-500 dark:to-indigo-500"></div>

        <!-- Return Button -->
        <a href="{{ route('stage.show', $grade->stage_id) }}" 
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gray-50 dark:bg-white/5 text-amber-600 dark:text-sky-400 font-bold border border-gray-200 dark:border-white/10 hover:border-amber-500 dark:hover:border-sky-500 hover:-translate-y-1 hover:shadow-xl hover:shadow-amber-500/10 dark:hover:shadow-sky-500/10 transition-all duration-300 mb-8 max-w-fit group relative z-10">
            <i class="fa-solid fa-arrow-right group-hover:-translate-x-1 transition-transform duration-300"></i>
            <span>العودة لـ {{ $grade->stage->name }}</span>
        </a>
        
        <!-- Main Title Area -->
        <div class="flex items-center gap-4 mb-4 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-amber-500/10 dark:bg-sky-500/10 border border-amber-500/20 dark:border-sky-500/20 flex flex-shrink-0 items-center justify-center text-amber-600 dark:text-sky-400 text-3xl shadow-inner">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-[#00555A] dark:text-white">{{ $grade->name }}</h1>
        </div>
        
        <p class="text-lg text-gray-500 dark:text-gray-400 font-medium flex items-center gap-2 relative z-10">
            <i class="fa-solid fa-book-open text-amber-500/70 dark:text-sky-400/70"></i>
            اختر المادة الدراسية - ستحتاج رمز الاشتراك للوصول إليها
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($subjects as $subject)
            @php
                $hasAccess = session("subject_access_{$subject->id}") 
                    || (auth()->check() && (
                        auth()->user()->isAdmin() 
                        || auth()->user()->isTeacher() 
                        || auth()->user()->enrolledCourses()->where('subject_id', $subject->id)->exists()
                    ));
            @endphp

            @if($hasAccess)
                {{-- الطالب مفعل له الاشتراك بالمادة -> دخول مباشر --}}
                <a href="{{ route('subject.videos', ['gradeId' => $grade->id, 'subjectId' => $subject->id]) }}"
                   class="group relative overflow-hidden rounded-[24px] bg-white dark:bg-[#141c2f] border border-emerald-500/30 hover:border-emerald-500 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-emerald-500/10 text-right w-full flex flex-col justify-between">
                    
                    <!-- Image Container -->
                    <div class="relative h-48 overflow-hidden">
                        @if($subject->image)
                            <img src="{{ $subject->image }}" alt="{{ $subject->name }}" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-emerald-500/10 to-white dark:from-emerald-950/40 dark:to-[#141c2f] flex items-center justify-center text-5xl text-emerald-500/40">
                                <i class="fa-solid fa-book-open"></i>
                            </div>
                        @endif
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-white dark:from-[#141c2f] via-transparent to-transparent opacity-60"></div>
                        
                        <div class="absolute top-4 right-4 px-3 py-1.5 rounded-full bg-emerald-500 text-white text-xs font-black flex items-center gap-1.5 shadow-lg">
                            <i class="fa-solid fa-circle-check"></i>
                            <span>متاح للمشاهدة</span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6 text-right flex-1">
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-xs font-black uppercase tracking-widest">
                                مادة دراسية مفعلة
                            </span>
                            <div class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-600 flex items-center justify-center">
                                <i class="fa-solid fa-play text-xs"></i>
                            </div>
                        </div>
                        
                        <h3 class="text-2xl font-black text-[var(--text-color)] dark:text-white mb-2 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">{{ $subject->name }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm font-medium line-clamp-2">اضغط لمشاهدة جميع المحاضرات والفيديوهات</p>
                    </div>

                    <!-- Bottom Action -->
                    <div class="px-6 pb-6">
                        <div class="w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-center text-white text-sm font-black transition-all duration-300 shadow-lg shadow-emerald-600/20 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-circle-play"></i>
                            <span>دخول إلى المحاضرات</span>
                        </div>
                    </div>
                </a>
            @else
                {{-- زر المادة يفتح modal رمز الاشتراك --}}
                <button type="button" onclick="openCodeModal({{ $subject->id }}, '{{ addslashes($subject->name) }}')"
                   class="group relative overflow-hidden rounded-[24px] bg-white dark:bg-[#141c2f] border border-[#00555A]/10 dark:border-white/10 hover:border-amber-500 dark:hover:border-sky-500 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-amber-500/10 dark:hover:shadow-sky-500/10 text-right w-full flex flex-col justify-between">
                    
                    <!-- Image Container -->
                    <div class="relative h-48 overflow-hidden">
                        @if($subject->image)
                            <img src="{{ $subject->image }}" alt="{{ $subject->name }}" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-amber-500/10 to-white dark:from-sky-900/50 dark:to-[#141c2f] flex items-center justify-center text-5xl text-amber-500/30 dark:text-sky-400">
                                <i class="fa-solid fa-book-open"></i>
                            </div>
                        @endif
                        
                        <!-- Overlay Gradient -->
                        <div class="absolute inset-0 bg-gradient-to-t from-white dark:from-[#141c2f] via-transparent to-transparent opacity-60"></div>
                        
                        <!-- Lock Icon Overlay -->
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="w-14 h-14 rounded-2xl bg-amber-500/90 dark:bg-sky-500/90 flex items-center justify-center text-white text-2xl shadow-2xl">
                                <i class="fa-solid fa-key"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6 text-right flex-1">
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-3 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:bg-sky-500/10 dark:text-sky-400 text-xs font-black uppercase tracking-widest">
                                مادة دراسية
                            </span>
                            <div class="w-8 h-8 rounded-lg bg-amber-500/5 dark:bg-white/5 flex items-center justify-center text-amber-600 dark:text-sky-400 group-hover:bg-amber-500 dark:group-hover:bg-sky-500 group-hover:text-white transition-colors duration-300">
                                <i class="fa-solid fa-key text-xs"></i>
                            </div>
                        </div>
                        
                        <h3 class="text-2xl font-black text-[var(--text-color)] dark:text-white mb-2 group-hover:text-amber-600 dark:group-hover:text-sky-400 transition-colors">{{ $subject->name }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm font-medium line-clamp-2">أدخل رمز الاشتراك للوصول إلى المحاضرات</p>
                    </div>

                    <!-- Bottom Action -->
                    <div class="px-6 pb-6">
                        <div class="w-full py-3 rounded-xl bg-amber-500 dark:bg-sky-500 border border-amber-500 dark:border-sky-500 text-center text-white text-sm font-black group-hover:bg-amber-600 dark:group-hover:bg-sky-600 transition-all duration-300 shadow-lg shadow-amber-500/20 dark:shadow-sky-500/20">
                            <i class="fa-solid fa-key ml-2"></i>
                            أدخل رمز الاشتراك
                        </div>
                    </div>
                </button>
            @endif
        @endforeach
    </div>
</div>

<!-- ===== Modal رمز الاشتراك ===== -->
<div id="code-modal" class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm hidden">
    <div class="bg-white dark:bg-[#141c2f] border border-gray-100 dark:border-white/10 w-full max-w-md rounded-3xl p-8 shadow-2xl" onclick="event.stopPropagation()">
        
        <!-- Header -->
        <div class="text-center mb-6">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-amber-500/10 dark:bg-sky-500/10 flex items-center justify-center text-2xl text-amber-600 dark:text-sky-400">
                <i class="fa-solid fa-key"></i>
            </div>
            <h3 class="text-2xl font-black text-[var(--text-color)] dark:text-white mb-1">رمز الاشتراك</h3>
            <p class="text-gray-500 dark:text-gray-400 text-sm font-medium" id="modal-subject-name">
                أدخل رمز الاشتراك للوصول إلى المادة
            </p>
        </div>

        <!-- Form -->
        <form id="code-form" method="POST" action="">
            @csrf
            
            @if($errors->any())
                <div class="mb-4 p-3 bg-red-500/10 border border-red-500/20 rounded-xl text-red-500 text-sm font-bold">
                    <i class="fa-solid fa-circle-xmark ml-2"></i>
                    {{ $errors->first('subscription_code') }}
                </div>
            @endif

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 text-right">
                    أدخل الرمز هنا
                </label>
                <input type="text" 
                       name="subscription_code" 
                       id="code-input"
                       placeholder="XXXX-XXXX-XXXX"
                       class="w-full px-5 py-4 rounded-2xl border-2 border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-[var(--text-color)] dark:text-white focus:border-amber-500 dark:focus:border-sky-500 outline-none transition font-black text-center text-lg tracking-widest uppercase"
                       autocomplete="off"
                       value="{{ old('subscription_code') }}">
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 py-4 rounded-2xl bg-amber-500 hover:bg-amber-600 dark:bg-sky-500 dark:hover:bg-sky-600 text-white font-black text-base transition-all duration-300 hover:-translate-y-0.5 shadow-lg shadow-amber-500/20 dark:shadow-sky-500/20">
                    <i class="fa-solid fa-unlock ml-2"></i>
                    تحقق وادخل
                </button>
                <button type="button" onclick="closeCodeModal()" class="px-6 py-4 rounded-2xl bg-gray-100 hover:bg-gray-200 dark:bg-white/5 dark:hover:bg-white/10 text-gray-700 dark:text-white font-bold transition">
                    إلغاء
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let currentSubjectId = null;
let currentGradeId   = {{ $grade->id }};

function openCodeModal(subjectId, subjectName) {
    currentSubjectId = subjectId;
    document.getElementById('modal-subject-name').textContent = 'مادة: ' + subjectName;
    document.getElementById('code-form').action = '/subject/' + currentGradeId + '/' + subjectId + '/verify';
    document.getElementById('code-modal').classList.remove('hidden');
    setTimeout(() => document.getElementById('code-input').focus(), 100);
}

function closeCodeModal() {
    document.getElementById('code-modal').classList.add('hidden');
}

document.getElementById('code-modal').addEventListener('click', function(e) {
    if (e.target === this) closeCodeModal();
});

// Auto-format رمز الاشتراك
document.getElementById('code-input')?.addEventListener('input', function() {
    let val = this.value.replace(/[^A-Za-z0-9]/g, '').toUpperCase();
    let formatted = val.match(/.{1,4}/g)?.join('-') ?? val;
    if (formatted.length <= 14) this.value = formatted;
});

// فتح modal تلقائياً إذا كان هناك خطأ
@if($errors->any())
    openCodeModal({{ old('subject_id', 0) }}, '');
@endif
</script>
@endsection
