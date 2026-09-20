@extends('layouts.dashboard')

@section('title', 'فيديوهات مادة ' . $subject->name)
@section('page-title', 'إدارة فيديوهات المادة')

@section('content')
<div x-data="{ showTeacherModal: false }">

    <!-- Breadcrumb + Header -->
    <div class="mb-8 flex flex-wrap justify-between items-start gap-4">
        <div>
            <div class="flex items-center gap-2 text-sm text-gray-400 mb-2">
                <a href="{{ route('admin.subjects.index') }}" class="hover:text-amber-500 dark:hover:text-sky-400 transition">المواد الدراسية</a>
                <i class="fa-solid fa-chevron-left text-xs"></i>
                <span class="text-[var(--text-color)] dark:text-white font-bold">{{ $subject->name }} - {{ $subject->grade->name }}</span>
            </div>
            <h1 class="text-3xl font-bold text-[var(--text-color)] dark:text-white mb-1">
                فيديوهات مادة {{ $subject->name }}
            </h1>
            <p class="text-gray-500">{{ $subject->grade->name }} - {{ $subject->grade->stage->name }}</p>
        </div>

        <!-- Add Video for Teacher Button -->
        <button @click="showTeacherModal = true" 
                class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-2xl transition flex items-center gap-2 shadow-xl shadow-emerald-600/20 hover:-translate-y-0.5">
            <i class="fa-solid fa-video"></i>
            <span>إضافة فيديو لمدرس معين</span>
        </button>
    </div>

    <!-- Courses List -->
    @forelse($courses as $course)
        <div class="card-glass rounded-3xl overflow-hidden mb-8 shadow-sm">
            <!-- Course Header -->
            <div class="p-6 border-b border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/5 flex justify-between items-center flex-wrap gap-4">
                <div>
                    <h2 class="text-xl font-bold text-[var(--text-color)] dark:text-white flex items-center gap-2">
                        <span>{{ $course->title }}</span>
                    </h2>
                    <p class="text-sm text-gray-500 mt-1 flex items-center gap-4 flex-wrap">
                        <span class="flex items-center gap-1.5 font-semibold text-amber-600 dark:text-amber-400">
                            <i class="fa-solid fa-user-tie"></i>
                            المدرس: {{ $course->teacher->name }}
                        </span>
                        <span class="text-sky-500 flex items-center gap-1.5 font-semibold">
                            <i class="fa-solid fa-list-ol"></i>
                            {{ $course->lessons->count() }} درس
                        </span>
                    </p>
                </div>
                <!-- Add Lesson Form Button -->
                <button onclick="document.getElementById('add-lesson-{{ $course->id }}').classList.toggle('hidden')"
                        class="px-4 py-2 bg-amber-500 hover:bg-amber-600 dark:bg-sky-500 dark:hover:bg-sky-600 text-white font-bold text-sm rounded-xl transition flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> إضافة درس لهذا الكورس
                </button>
            </div>

            <!-- Add Lesson Form (hidden by default) -->
            <div id="add-lesson-{{ $course->id }}" class="hidden p-6 bg-amber-500/5 dark:bg-sky-500/5 border-b border-gray-100 dark:border-white/5">
                <form action="{{ route('admin.lessons.store-lesson', $course->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">عنوان الدرس *</label>
                            <input type="text" name="title" required placeholder="مثال: الدرس الأول - المقدمة"
                                   class="w-full bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">رابط الفيديو (يوتيوب أو رابط مباشر)</label>
                            <input type="url" name="video_url" placeholder="https://youtube.com/..."
                                   class="w-full bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">أو رفع ملف فيديو (MP4)</label>
                            <input type="file" name="video" accept="video/mp4,video/avi,video/webm"
                                   class="w-full bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">وصف الدرس</label>
                            <input type="text" name="description" placeholder="ملخص سريع عن محتوى الدرس"
                                   class="w-full bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_free" id="is_free_{{ $course->id }}" value="1" class="rounded">
                        <label for="is_free_{{ $course->id }}" class="text-sm font-bold text-gray-600 dark:text-gray-300">درس مجاني (معاينة)</label>
                    </div>
                    <button type="submit" class="px-6 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-sm rounded-xl transition">
                        <i class="fa-solid fa-floppy-disk ml-1"></i> حفظ الدرس
                    </button>
                </form>
            </div>

            <!-- Lessons Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-right text-sm">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-white/5 text-gray-500">
                            <th class="p-4 font-bold">#</th>
                            <th class="p-4 font-bold">عنوان الدرس</th>
                            <th class="p-4 font-bold text-center">نوع الفيديو</th>
                            <th class="p-4 font-bold text-center">رفع فيديو جديد</th>
                            <th class="p-4 font-bold text-center">حذف</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                        @forelse($course->lessons->sortBy('order') as $lesson)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                            <td class="p-4 text-gray-400 font-bold">{{ $lesson->order }}</td>
                            <td class="p-4">
                                <div class="font-bold text-[var(--text-color)] dark:text-white">{{ $lesson->title }}</div>
                                @if($lesson->description)
                                    <div class="text-xs text-gray-400 mt-0.5">{{ Str::limit($lesson->description, 60) }}</div>
                                @endif
                                @if($lesson->is_free)
                                    <span class="text-[10px] bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 px-2 py-0.5 rounded-full font-bold mt-1 inline-block">مجاني</span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                @if($lesson->video_path)
                                    <span class="px-2.5 py-1 rounded-lg bg-blue-100 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400 text-xs font-black">
                                        <i class="fa-solid fa-file-video ml-1"></i> ملف مرفوع
                                    </span>
                                @elseif($lesson->video_url && str_contains($lesson->video_url, 'youtube'))
                                    <span class="px-2.5 py-1 rounded-lg bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400 text-xs font-black">
                                        <i class="fa-brands fa-youtube ml-1"></i> يوتيوب
                                    </span>
                                @elseif($lesson->video_url)
                                    <span class="px-2.5 py-1 rounded-lg bg-purple-100 text-purple-700 dark:bg-purple-500/10 dark:text-purple-400 text-xs font-black">
                                        <i class="fa-solid fa-link ml-1"></i> رابط خارجي
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs">لا يوجد</span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <form action="{{ route('admin.lessons.upload', $lesson->id) }}" method="POST" enctype="multipart/form-data" class="flex items-center justify-center gap-2">
                                    @csrf
                                    <input type="file" name="video" accept="video/mp4,video/avi,video/webm"
                                           class="text-xs text-gray-500 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-amber-500/10 file:text-amber-600 dark:file:bg-sky-500/10 dark:file:text-sky-400 file:font-bold file:cursor-pointer hover:file:bg-amber-500/20 dark:hover:file:bg-sky-500/20 transition"
                                           required>
                                    <button type="submit" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 dark:bg-sky-500 dark:hover:bg-sky-600 text-white font-bold text-xs rounded-lg transition">
                                        <i class="fa-solid fa-upload"></i>
                                    </button>
                                </form>
                            </td>
                            <td class="p-4 text-center">
                                <form action="{{ route('admin.lessons.destroy-lesson', $lesson->id) }}" method="POST" data-confirm="هل تريد حذف هذا الدرس وفيديوه؟">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 hover:bg-red-500/10 rounded-lg text-red-500 transition">
                                        <i class="fa-solid fa-trash-can text-sm"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-400 font-bold">لا توجد دروس لهذا الكورس بعد. اضغط على "إضافة درس لهذا الكورس".</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="text-center py-20 card-glass rounded-3xl p-8">
            <div class="w-20 h-20 mx-auto rounded-3xl bg-amber-500/10 dark:bg-sky-500/10 flex items-center justify-center text-4xl text-amber-500 dark:text-sky-400 mb-4">
                <i class="fa-solid fa-video"></i>
            </div>
            <h2 class="text-2xl font-black text-[var(--text-color)] dark:text-white mb-2">لا توجد كورسات أو فيديوهات بعد</h2>
            <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-6">
                لم يقم المعلمون برفع أي محتوى لهذه المادة حتى الآن. يمكنك كمسؤول إضافة كورس وفيديو لأي معلم الآن مباشرة!
            </p>
            <button @click="showTeacherModal = true" class="px-6 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-2xl transition inline-flex items-center gap-2 shadow-xl shadow-emerald-600/25">
                <i class="fa-solid fa-plus"></i>
                <span>إضافة أول فيديو لمدرس في مادة {{ $subject->name }}</span>
            </button>
        </div>
    @endforelse

    <!-- Modal إضافة فيديو لمدرس معين -->
    <template x-teleport="body">
        <div x-show="showTeacherModal" 
             class="fixed inset-0 z-[100] overflow-y-auto bg-black/60 backdrop-blur-sm"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-cloak>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="bg-white dark:bg-[#161b22] border border-gray-200 dark:border-white/10 w-full max-w-xl rounded-3xl p-7 shadow-2xl" @click.away="showTeacherModal = false">
                    <div class="flex justify-between items-center mb-6 border-b border-gray-100 dark:border-white/5 pb-4">
                        <div>
                            <h3 class="text-xl font-bold text-[var(--text-color)] dark:text-white">إضافة فيديو لمدرس معين</h3>
                            <p class="text-xs text-gray-500 mt-1">مادة {{ $subject->name }} ({{ $subject->grade->name }})</p>
                        </div>
                        <button @click="showTeacherModal = false" class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <form action="{{ route('admin.lessons.store-for-teacher', $subject->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label class="block mb-1 text-xs text-gray-500 font-bold">المدرس *</label>
                            <select name="teacher_id" required class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                                <option value="">-- اختر المدرس --</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }} ({{ $teacher->email }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block mb-1 text-xs text-gray-500 font-bold">عنوان الكورس / الدورة (اختياري)</label>
                            <input type="text" name="course_title" placeholder="اختياري: مثلاً دورة مادة {{ $subject->name }} الشاملة (يُترك فارغاً للإنشاء التلقائي)"
                                   class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                        </div>

                        <div>
                            <label class="block mb-1 text-xs text-gray-500 font-bold">عنوان الدرس *</label>
                            <input type="text" name="title" required placeholder="مثال: الدرس الأول - مراجعة أساسيات المنهج"
                                   class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-1 text-xs text-gray-500 font-bold">رابط يوتيوب أو رابط خارجي</label>
                                <input type="url" name="video_url" placeholder="https://youtube.com/..."
                                       class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                            </div>

                            <div>
                                <label class="block mb-1 text-xs text-gray-500 font-bold">أو رفع ملف فيديو (MP4)</label>
                                <input type="file" name="video" accept="video/mp4,video/avi,video/webm"
                                       class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                            </div>
                        </div>

                        <div>
                            <label class="block mb-1 text-xs text-gray-500 font-bold">وصف الدرس (اختياري)</label>
                            <textarea name="description" rows="2" placeholder="وصف محتوى الدرس"
                                      class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition"></textarea>
                        </div>

                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="is_free" id="modal_is_free" value="1" class="rounded">
                            <label for="modal_is_free" class="text-sm font-bold text-gray-600 dark:text-gray-300">درس مجاني (معاينة)</label>
                        </div>

                        <div class="pt-4 flex gap-3 border-t border-gray-100 dark:border-white/5">
                            <button type="submit" class="flex-1 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 transition text-white font-bold text-sm shadow-lg shadow-emerald-600/20">
                                <i class="fa-solid fa-cloud-arrow-up ml-1"></i> حفظ ورفع الفيديو
                            </button>
                            <button type="button" @click="showTeacherModal = false" class="flex-1 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-white/5 dark:hover:bg-white/10 transition text-[var(--text-color)] dark:text-white font-bold text-sm">
                                إلغاء
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>

</div>
@endsection
