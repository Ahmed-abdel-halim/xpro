@extends('layouts.dashboard')

@section('title', 'إدارة الدروس')
@section('page-title', 'دروس كورس: ' . $course->title)

@section('content')
<div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <a href="{{ route('teacher.courses.index') }}" class="text-amber-500 hover:text-amber-600 dark:text-sky-400 dark:hover:text-sky-300 transition text-sm flex items-center mb-2 font-bold">
            <i class="fa-solid fa-arrow-right ml-2"></i>
            العودة للكورسات
        </a>
        <h1 class="text-3xl font-bold text-[var(--text-color)] dark:text-white mb-2">دروس الكورس</h1>
        <p class="text-gray-500 font-medium mt-2">إدارة وترتيب الدروس داخل كورس: <span class="text-amber-600 dark:text-sky-400">{{ $course->title }}</span></p>
    </div>
    <a href="{{ route('teacher.courses.lessons.create', $course->id) }}" class="px-6 py-3.5 bg-amber-500 hover:bg-amber-600 dark:bg-sky-500 dark:hover:bg-sky-600 transition rounded-xl text-white font-bold shadow-lg shadow-amber-500/20 dark:shadow-sky-500/20 flex items-center shrink-0">
        <i class="fa-solid fa-plus ml-2"></i>
        إضافة درس جديد
    </a>
</div>



<div class="card-glass rounded-3xl overflow-hidden border border-gray-100 dark:border-white/5 shadow-xl shadow-gray-200/40 dark:shadow-none">
    <div class="p-6 border-b border-gray-100 dark:border-white/5 bg-gray-50 dark:bg-white/5">
        <h3 class="font-bold text-[var(--text-color)] dark:text-white flex items-center">
            <i class="fa-solid fa-list-ol ml-2 text-amber-500 dark:text-sky-400"></i>
            قائمة الدروس ({{ $lessons->count() }})
        </h3>
    </div>
    
    <div class="divide-y divide-gray-100 dark:divide-white/5">
        @forelse($lessons as $lesson)
            <div class="p-6 hover:bg-gray-50 dark:hover:bg-white/5 transition flex flex-col md:flex-row md:items-center justify-between group gap-4">
                <div class="flex items-center space-x-4 space-x-reverse">
                    <div class="w-10 h-10 bg-amber-100 text-amber-600 dark:bg-sky-500/10 rounded-lg flex items-center justify-center dark:text-sky-400 font-bold shrink-0">
                        {{ $lesson->order }}
                    </div>
                    <div>
                        <div class="font-bold text-[var(--text-color)] dark:text-white flex items-center mb-1 group-hover:text-amber-600 dark:group-hover:text-sky-400 transition-colors">
                            {{ $lesson->title }}
                            @if($lesson->is_free)
                                <span class="mr-3 px-2 py-0.5 bg-green-100 dark:bg-green-500/10 text-green-600 dark:text-green-400 text-[10px] rounded-md border border-green-200 dark:border-green-500/20">مجاني</span>
                            @endif
                        </div>
                        <div class="text-xs text-gray-400 font-medium leading-relaxed truncate max-w-[200px] md:max-w-md w-full" title="{{ $lesson->video_url }}">
                            <i class="fa-solid fa-link ml-1"></i> {{ $lesson->video_url }}
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center space-x-2 space-x-reverse mr-14 md:mr-0 mt-2 md:mt-0">
                    <a href="{{ route('teacher.courses.lessons.edit', [$course->id, $lesson->id]) }}" class="p-2.5 bg-sky-50 hover:bg-sky-100 text-sky-600 dark:bg-white/5 dark:hover:bg-sky-500/20 dark:text-sky-400 rounded-lg transition" title="تعديل">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    <form action="{{ route('teacher.courses.lessons.destroy', [$course->id, $lesson->id]) }}" method="POST" data-confirm="هل أنت متأكد من حذف هذا الدرس؟">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2.5 bg-red-50 hover:bg-red-100 text-red-600 dark:bg-white/5 dark:hover:bg-red-500/20 dark:text-red-500 rounded-lg transition" title="حذف">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="p-20 text-center text-gray-500 dark:text-gray-500 italic bg-gray-50 dark:bg-white/5 rounded-[2rem] m-6 border border-gray-100 dark:border-white/5">
                <i class="fa-solid fa-video-slash text-6xl mb-6 block text-gray-300 dark:text-gray-700"></i>
                <span class="font-bold text-lg text-gray-600 dark:text-gray-400">لا توجد دروس مضافة لهذا الكورس بعد.</span>
            </div>
        @endforelse
    </div>
</div>
@endsection
