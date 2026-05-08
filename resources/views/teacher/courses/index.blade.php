@extends('layouts.dashboard')

@section('title', 'كورساتي')
@section('page-title', 'إدارة الكورسات المرفوعة')

@section('content')
<div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h1 class="text-3xl font-bold text-[var(--text-color)] dark:text-white mb-2">كورساتي التعليمية</h1>
        <p class="text-gray-500 font-medium">هنا يمكنك إدارة جميع الكورسات التي قمت برفعها وتعديل محتواها.</p>
    </div>
    <a href="{{ route('teacher.courses.create') }}" class="px-6 py-3 bg-amber-500 hover:bg-amber-600 dark:bg-sky-500 dark:hover:bg-sky-600 transition rounded-xl text-white font-bold shadow-lg shadow-amber-500/20 dark:shadow-sky-500/20 flex items-center shrink-0">
        <i class="fa-solid fa-plus ml-2"></i>
        إضافة كورس جديد
    </a>
</div>



<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($courses as $course)
        <div class="card-glass rounded-3xl overflow-hidden group border border-gray-100 dark:border-white/5 shadow-xl shadow-gray-200/40 dark:shadow-none hover:-translate-y-2 transition-transform duration-300">
            <div class="h-48 bg-gray-100 dark:bg-gray-900 relative overflow-hidden">
                @if($course->thumbnail)
                    <img src="{{ $course->thumbnail }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500 opacity-90 dark:opacity-70">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-300 dark:text-gray-700 text-5xl">
                        <i class="fa-solid fa-photo-film"></i>
                    </div>
                @endif
                <div class="absolute top-4 right-4 flex space-x-2 space-x-reverse">
                    <span class="bg-amber-500 dark:bg-sky-500 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg shadow-md">
                        {{ $course->subject->name }}
                    </span>
                </div>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-bold text-[var(--text-color)] dark:text-white mb-2 line-clamp-1 group-hover:text-amber-600 dark:group-hover:text-sky-400 transition-colors">{{ $course->title }}</h3>
                <div class="flex items-center text-gray-500 dark:text-gray-400 text-xs mb-4 font-bold">
                    <i class="fa-solid fa-layer-group ml-1.5 text-amber-500/70 dark:text-sky-400/70"></i>
                    {{ $course->subject->grade->name }} - {{ $course->subject->grade->stage->name }}
                </div>
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-6 line-clamp-2 h-10 leading-relaxed font-medium">{{ $course->description }}</p>
                
                <div class="flex items-center justify-between pt-6 border-t border-gray-100 dark:border-white/5">
                    <div class="text-emerald-600 dark:text-emerald-400 font-bold text-lg">
                        {{ number_format($course->price, 2) }} <span class="text-xs">ج.م</span>
                    </div>
                    <div class="flex space-x-2 space-x-reverse">
                        <a href="{{ route('teacher.courses.lessons.index', $course->id) }}" class="p-2.5 bg-purple-50 hover:bg-purple-100 text-purple-600 dark:bg-white/5 dark:hover:bg-purple-500/20 dark:text-purple-400 rounded-lg transition" title="إدارة الدروس">
                            <i class="fa-solid fa-video"></i>
                        </a>
                        <a href="{{ route('teacher.courses.edit', $course->id) }}" class="p-2.5 bg-sky-50 hover:bg-sky-100 text-sky-600 dark:bg-white/5 dark:hover:bg-sky-500/20 dark:text-sky-400 rounded-lg transition" title="تعديل">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>

                        <form action="{{ route('teacher.courses.destroy', $course->id) }}" method="POST" data-confirm="هل أنت متأكد من حذف هذا الكورس نهائياً؟">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2.5 bg-red-50 hover:bg-red-100 text-red-600 dark:bg-white/5 dark:hover:bg-red-500/20 dark:text-red-500 rounded-lg transition" title="حذف">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full py-20 card-glass rounded-3xl border border-gray-100 dark:border-white/5 text-center flex flex-col items-center justify-center">
            <div class="w-32 h-32 mb-8 bg-gray-50 dark:bg-white/5 rounded-[2rem] flex items-center justify-center text-5xl text-gray-300 dark:text-gray-700 shadow-inner">
                <i class="fa-solid fa-folder-open"></i>
            </div>
            <h2 class="text-2xl font-black text-[var(--text-color)] dark:text-white mb-3">لا توجد كورسات حالياً</h2>
            <p class="text-gray-500 dark:text-gray-400 mb-8 font-medium">ابدأ الآن برفع أول كورس تعليمي لك على المنصة.</p>
            <a href="{{ route('teacher.courses.create') }}" class="px-8 py-3.5 bg-amber-500 hover:bg-amber-600 dark:bg-sky-500 dark:hover:bg-sky-600 transition rounded-xl text-white font-bold shadow-lg shadow-amber-500/20 dark:shadow-sky-500/20 flex items-center">
                <i class="fa-solid fa-plus ml-2"></i>
                أضف كورس جديد الآن
            </a>
        </div>
    @endforelse
</div>
@endsection
