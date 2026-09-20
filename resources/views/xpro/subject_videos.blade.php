@extends('layouts.app')

@section('title', $subject->name . ' - الفيديوهات')

@section('content')
<div class="py-12 relative min-h-screen">
    <!-- Header -->
    <div class="relative bg-gray-50/50 dark:bg-white/5 border border-gray-100 dark:border-white/10 rounded-[2.5rem] p-8 md:p-12 mb-10 overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-sky-500/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2 pointer-events-none"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row-reverse justify-between items-start gap-6">
            <div class="text-right flex-1">
                <div class="flex items-center justify-start gap-3 mb-4 flex-wrap">
                    <span class="px-4 py-2 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-600 dark:text-amber-500 text-sm font-black flex items-center gap-2">
                        <i class="fa-solid fa-book-open"></i> {{ $subject->name }}
                    </span>
                    <span class="px-4 py-2 rounded-2xl bg-sky-500/10 border border-sky-500/20 text-sky-600 dark:text-sky-400 text-sm font-black flex items-center gap-2">
                        <i class="fa-solid fa-layer-group"></i> {{ $subject->grade->name }}
                    </span>
                    <span class="px-4 py-2 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 text-sm font-black flex items-center gap-2">
                        <i class="fa-solid fa-video"></i> {{ $lessons->count() }} درس
                    </span>
                    @if(isset($teacher) && $teacher)
                    <span class="px-4 py-2 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-600 dark:text-indigo-400 text-sm font-black flex items-center gap-2">
                        <i class="fa-solid fa-user-tie"></i> المدرس: {{ $teacher->name }}
                    </span>
                    @endif
                </div>
                <h1 class="text-4xl md:text-5xl font-black text-[var(--text-color)] dark:text-white mb-3 leading-tight">
                    محاضرات {{ $subject->name }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400 font-medium text-lg">
                    جميع الدروس والفيديوهات الخاصة بمادة {{ $subject->name }} - {{ $subject->grade->name }}
                </p>
            </div>
            
            <div class="shrink-0">
                <a href="{{ route('grade.show', $gradeId) }}" class="group inline-flex items-center gap-3 px-6 py-3 rounded-2xl bg-white dark:bg-white/10 hover:bg-amber-500 text-[#0f1524] dark:text-white hover:text-white transition-all duration-300 font-black shadow-xl border border-gray-100 dark:border-white/10">
                    <i class="fa-solid fa-arrow-right"></i>
                    <span>العودة للمواد</span>
                </a>
            </div>
        </div>
    </div>

    @if($lessons->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($lessons as $index => $lesson)
                <div class="group relative bg-white dark:bg-[#141c2f] rounded-3xl border border-gray-100 dark:border-white/10 overflow-hidden hover:border-amber-500/50 dark:hover:border-sky-500/50 hover:shadow-2xl hover:shadow-amber-500/10 dark:hover:shadow-sky-500/10 transition-all duration-500 hover:-translate-y-1 flex flex-col">
                    
                    <!-- Video Thumbnail/Player -->
                    <div class="relative bg-gray-900 aspect-video overflow-hidden">
                        @php
                            $videoUrl  = $lesson->video_path ?? $lesson->video_url;
                            $isYoutube = str_contains($videoUrl, 'youtube') || str_contains($videoUrl, 'youtu.be');
                            $isLocal   = $lesson->video_path && !str_contains($lesson->video_path, 'http');
                        @endphp

                        @if($isYoutube)
                            @php
                                preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $videoUrl, $m);
                                $ytId = $m[1] ?? '';
                            @endphp
                            <iframe src="https://www.youtube.com/embed/{{ $ytId }}" 
                                    class="w-full h-full" 
                                    allowfullscreen 
                                    loading="lazy"
                                    title="{{ $lesson->title }}">
                            </iframe>
                        @elseif($isLocal)
                            <video class="w-full h-full object-cover" controls preload="none">
                                <source src="{{ asset('storage/' . $lesson->video_path) }}" type="video/mp4">
                            </video>
                        @elseif($videoUrl && str_contains($videoUrl, 'http'))
                            <video class="w-full h-full object-cover" controls preload="none">
                                <source src="{{ $videoUrl }}" type="video/mp4">
                            </video>
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-500">
                                <i class="fa-solid fa-video-slash text-4xl opacity-40"></i>
                            </div>
                        @endif

                        <!-- Lesson Number Badge -->
                        <div class="absolute top-3 right-3 w-8 h-8 rounded-full bg-amber-500 dark:bg-sky-500 text-white text-xs font-black flex items-center justify-center shadow-lg">
                            {{ $index + 1 }}
                        </div>

                        @if($lesson->is_free)
                            <div class="absolute top-3 left-3 px-2 py-0.5 rounded-lg bg-emerald-500 text-white text-[10px] font-black">
                                مجاني
                            </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="p-5 flex-1 flex flex-col">
                        <h3 class="text-base font-black text-[var(--text-color)] dark:text-white mb-2 leading-tight group-hover:text-amber-600 dark:group-hover:text-sky-400 transition-colors">
                            {{ $lesson->title }}
                        </h3>
                        
                        @if($lesson->description)
                            <p class="text-gray-500 dark:text-gray-400 text-sm font-medium line-clamp-2 mb-3 flex-1">
                                {{ $lesson->description }}
                            </p>
                        @endif

                        <div class="flex items-center justify-between mt-auto pt-3 border-t border-gray-100 dark:border-white/5">
                            <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">
                                <i class="fa-solid fa-chalkboard-user ml-1 text-amber-500/60"></i>
                                {{ $lesson->course->teacher->name }}
                            </span>
                            <span class="text-xs font-black text-amber-500 dark:text-sky-400">
                                الدرس {{ $index + 1 }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-24 bg-white/50 dark:bg-white/5 rounded-3xl border border-gray-100 dark:border-white/5">
            <div class="w-24 h-24 mx-auto bg-amber-500/10 rounded-3xl flex items-center justify-center mb-6">
                <i class="fa-solid fa-video text-4xl text-amber-500/40"></i>
            </div>
            <h2 class="text-2xl font-black text-[var(--text-color)] dark:text-white mb-2">لا توجد فيديوهات بعد</h2>
            <p class="text-gray-500 dark:text-gray-400 font-medium">لم يتم إضافة أي دروس لهذه المادة حتى الآن.</p>
        </div>
    @endif
</div>
@endsection
