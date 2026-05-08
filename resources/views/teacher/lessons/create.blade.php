@extends('layouts.dashboard')

@section('title', 'إضافة درس')
@section('page-title', 'إضافة درس جديد لـ ' . $course->title)

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-10">
        <a href="{{ route('teacher.courses.lessons.index', $course->id) }}" class="text-amber-500 hover:text-amber-600 dark:text-sky-400 dark:hover:text-sky-300 transition text-sm flex items-center mb-2 font-bold">
            <i class="fa-solid fa-arrow-right ml-2"></i>
            العودة لقائمة الدروس
        </a>
        <h1 class="text-3xl font-bold text-[var(--text-color)] dark:text-white">إضافة درس جديد</h1>
        <p class="text-gray-500 font-medium mt-2">كورس: <span class="text-amber-600 dark:text-sky-400">{{ $course->title }}</span></p>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-2xl">
            <ul class="list-disc list-inside text-red-400 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('teacher.courses.lessons.store', $course->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-glass p-8 rounded-3xl space-y-6 border border-gray-100 dark:border-white/5 shadow-xl shadow-gray-200/40 dark:shadow-none">
            <div>
                <label class="block text-gray-500 dark:text-gray-400 text-sm font-bold mb-2">عنوان الدرس</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       class="w-full bg-gray-50 border border-gray-200 dark:bg-white/5 dark:border-white/10 rounded-xl px-4 py-3 text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition"
                       placeholder="مثال: مقدمة في علم الفيزياء">
            </div>

            <div>
                <label class="block text-gray-500 dark:text-gray-400 text-sm font-bold mb-2">وصف الدرس (اختياري)</label>
                <textarea name="description" rows="4"
                          class="w-full bg-gray-50 border border-gray-200 dark:bg-white/5 dark:border-white/10 rounded-xl px-4 py-3 text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition"
                          placeholder="ماذا سيتم شرحه في هذا الدرس بالتفصيل؟">{{ old('description') }}</textarea>
            </div>

            <div class="space-y-4">
                <label class="block text-gray-500 dark:text-gray-400 text-sm font-bold mb-2">نوع الفيديو</label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="cursor-pointer">
                        <input type="radio" name="video_type" value="upload" checked class="hidden peer" onchange="toggleVideoSource()">
                        <div class="p-4 rounded-xl border-2 border-gray-100 dark:border-white/5 bg-gray-50 dark:bg-white/5 peer-checked:border-amber-500 dark:peer-checked:border-sky-500 peer-checked:bg-amber-50 dark:peer-checked:bg-sky-500/10 transition text-center font-bold text-sm">
                            <i class="fa-solid fa-cloud-arrow-up block mb-2 text-lg"></i>
                            رفع ملف فيديو
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="video_type" value="url" class="hidden peer" onchange="toggleVideoSource()">
                        <div class="p-4 rounded-xl border-2 border-gray-100 dark:border-white/5 bg-gray-50 dark:bg-white/5 peer-checked:border-amber-500 dark:peer-checked:border-sky-500 peer-checked:bg-amber-50 dark:peer-checked:bg-sky-500/10 transition text-center font-bold text-sm">
                            <i class="fa-solid fa-link block mb-2 text-lg"></i>
                            رابط خارجي (يوتيوب/سيرفر آخر)
                        </div>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div id="video_upload_container">
                    <label class="block text-gray-500 dark:text-gray-400 text-sm font-bold mb-2">رفع ملف الفيديو (MP4, MOV)</label>
                    <input type="file" name="video" id="video_file_input" accept="video/*"
                           class="w-full bg-gray-50 border border-gray-200 dark:bg-white/5 dark:border-white/10 rounded-xl px-4 py-3 text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition file:bg-amber-100 file:text-amber-600 dark:file:bg-sky-500/10 dark:file:text-sky-400 file:border-0 file:rounded-lg file:px-4 file:py-1 file:mr-4 file:cursor-pointer file:font-bold">
                </div>
                <div id="video_url_container" style="display: none;">
                    <label class="block text-gray-500 dark:text-gray-400 text-sm font-bold mb-2">رابط الفيديو (URL)</label>
                    <input type="url" name="video_url" id="video_url_input" value="{{ old('video_url') }}"
                           class="w-full bg-gray-50 border border-gray-200 dark:bg-white/5 dark:border-white/10 rounded-xl px-4 py-3 text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition"
                           placeholder="https://www.youtube.com/watch?v=...">
                    <p class="mt-1 text-[10px] text-gray-400">يدعم يوتيوب، فيميو، أو أي رابط مباشر لملف فيديو.</p>
                </div>
                <div>
                    <label class="block text-gray-500 dark:text-gray-400 text-sm font-bold mb-2">ترتيب العرض</label>
                    <input type="number" name="order" value="{{ old('order', $course->lessons->count() + 1) }}" required
                           class="w-full bg-gray-50 border border-gray-200 dark:bg-white/5 dark:border-white/10 rounded-xl px-4 py-3 text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                </div>
            </div>

            <div class="flex items-center p-4 bg-gray-50 border border-gray-200 dark:bg-white/5 rounded-2xl dark:border-white/10">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_free" value="1" class="sr-only peer" {{ old('is_free') ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-300 dark:bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500 dark:peer-checked:bg-sky-500"></div>
                    <span class="ms-3 text-sm font-bold text-gray-600 dark:text-gray-300">درس مجاني (تجريبي للطلاب غير المشتركين)</span>
                </label>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full py-4 bg-amber-500 hover:bg-amber-600 dark:bg-sky-500 dark:hover:bg-sky-600 transition rounded-xl text-white font-bold shadow-lg shadow-amber-500/20 dark:shadow-sky-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-cloud-arrow-up ml-2"></i>
                    حفظ ونشر الدرس
                </button>
            </div>
        </div>
    </form>
</div>

<script>
function toggleVideoSource() {
    const type = document.querySelector('input[name="video_type"]:checked').value;
    const uploadContainer = document.getElementById('video_upload_container');
    const urlContainer = document.getElementById('video_url_container');
    const fileInput = document.getElementById('video_file_input');
    const urlInput = document.getElementById('video_url_input');

    if (type === 'upload') {
        uploadContainer.style.display = 'block';
        urlContainer.style.display = 'none';
        fileInput.setAttribute('required', 'required');
        urlInput.removeAttribute('required');
    } else {
        uploadContainer.style.display = 'none';
        urlContainer.style.display = 'block';
        fileInput.removeAttribute('required');
        urlInput.setAttribute('required', 'required');
    }
}

// Run once on load
document.addEventListener('DOMContentLoaded', toggleVideoSource);
</script>
@endsection
