@extends('layouts.dashboard')

@section('title', 'كورسات مادة ' . $subject->name)
@section('page-title', 'كورسات مادة ' . $subject->name)

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-[var(--text-color)] dark:text-white mb-2">كورسات مادة: {{ $subject->name }}</h1>
        <p class="text-gray-500">عرض جميع الكورسات المتاحة لهذه المادة والمعلمين القائمين عليها.</p>
    </div>
    <a href="{{ route('admin.subjects.index') }}" class="px-6 py-2 bg-gray-100 dark:bg-white/5 hover:bg-gray-200 dark:hover:bg-white/10 transition rounded-xl text-[var(--text-color)] dark:text-white font-bold text-sm border border-gray-200 dark:border-white/10">
        <i class="fa-solid fa-arrow-right ml-2"></i> العودة للمواد
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($courses as $course)
    <div class="card-glass rounded-2xl overflow-hidden flex flex-col">
        <div class="relative h-48">
            @if($course->thumbnail)
                <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-white/5 dark:to-white/10 flex items-center justify-center">
                    <i class="fa-solid fa-video text-4xl text-gray-300 dark:text-gray-600"></i>
                </div>
            @endif
            <div class="absolute top-4 left-4">
                <span class="bg-black/50 backdrop-blur-md text-white text-xs px-3 py-1 rounded-full font-bold">
                    {{ $course->lessons_count }} فيديو
                </span>
            </div>
        </div>
        
        <div class="p-6 flex-1 flex flex-col">
            <h3 class="text-xl font-bold text-[var(--text-color)] dark:text-white mb-2">{{ $course->title }}</h3>
            
            <div class="flex items-center mb-4 pb-4 border-b border-gray-100 dark:border-white/5">
                <div class="w-8 h-8 rounded-full overflow-hidden bg-sky-500 flex items-center justify-center text-white text-xs font-bold ml-3">
                    @if($course->teacher->avatar)
                        <img src="{{ asset('storage/' . $course->teacher->avatar) }}" class="w-full h-full object-cover">
                    @else
                        {{ substr($course->teacher->name, 0, 1) }}
                    @endif
                </div>
                <div class="flex flex-col">
                    <span class="text-xs text-gray-400">بواسطة</span>
                    <span class="text-sm font-bold text-[var(--text-color)] dark:text-white">{{ $course->teacher->name }}</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="flex flex-col">
                    <span class="text-[10px] text-gray-400 uppercase tracking-wider mb-1">الطلاب</span>
                    <div class="flex items-center text-amber-500">
                        <i class="fa-solid fa-users ml-2 text-xs"></i>
                        <span class="text-sm font-bold">{{ $course->enrollments_count }}</span>
                    </div>
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] text-gray-400 uppercase tracking-wider mb-1">السعر</span>
                    <div class="flex items-center text-green-500">
                        <i class="fa-solid fa-money-bill-wave ml-2 text-xs"></i>
                        <span class="text-sm font-bold">{{ number_format($course->price, 2) }} ج.م</span>
                    </div>
                </div>
            </div>

            <div class="mt-auto flex space-x-2 space-x-reverse">
                <a href="{{ route('course.show', $course->id) }}" target="_blank" class="flex-1 text-center py-3 bg-sky-500/10 hover:bg-sky-500 text-sky-500 hover:text-white transition rounded-xl font-bold text-sm">
                    <i class="fa-solid fa-eye ml-2"></i> معاينة
                </a>
                <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" data-confirm="هل أنت متأكد من حذف هذا الكورس نهائياً؟ سيتم حذف جميع الفيديوهات والاشتراكات التابعة له.">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-3 bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white transition rounded-xl font-bold text-sm">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full py-20 text-center card-glass rounded-3xl">
        <div class="w-20 h-20 bg-gray-100 dark:bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fa-solid fa-folder-open text-3xl text-gray-300"></i>
        </div>
        <h3 class="text-xl font-bold text-[var(--text-color)] dark:text-white mb-2">لا يوجد كورسات بعد</h3>
        <p class="text-gray-500">لم يتم إضافة أي كورسات لهذه المادة حتى الآن.</p>
    </div>
    @endforelse
</div>
@endsection
