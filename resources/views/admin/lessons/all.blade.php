@extends('layouts.dashboard')

@section('title', 'روابط ومحاضرات المواد')
@section('page-title', 'إدارة روابط ومحاضرات المواد')

@section('content')
<div x-data="{ 
    showAddModal: false,
    selectedStage: '',
    selectedGrade: ''
}">
    <!-- Header -->
    <div class="mb-8 flex flex-wrap justify-between items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-[var(--text-color)] dark:text-white mb-2">روابط ومحاضرات المواد</h1>
            <p class="text-gray-500">إمكانية رفع، إدارة، وحذف أي رابط محاضرة أو فيديو لأي مادة دراسية وأي أستاذ.</p>
        </div>
        <button @click="showAddModal = true" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-2xl transition flex items-center gap-2 shadow-xl shadow-emerald-600/20 hover:-translate-y-0.5">
            <i class="fa-solid fa-plus-circle"></i>
            <span>+ رفع رابط محاضرة لأي مادة</span>
        </button>
    </div>

    <!-- Filters Card -->
    <div class="card-glass p-6 mb-8 rounded-3xl border border-gray-100 dark:border-white/5">
        <form action="{{ route('admin.lectures.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-gray-500 dark:text-gray-400 text-xs mb-1 font-bold">المادة الدراسية</label>
                <select name="subject_id" class="w-full bg-white dark:bg-[#161b22] border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                    <option value="">كل المواد</option>
                    @foreach($subjects as $sub)
                        <option value="{{ $sub->id }}" {{ request('subject_id') == $sub->id ? 'selected' : '' }}>
                            {{ $sub->name }} ({{ $sub->grade->name }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-gray-500 dark:text-gray-400 text-xs mb-1 font-bold">الأستاذ</label>
                <select name="teacher_id" class="w-full bg-white dark:bg-[#161b22] border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                    <option value="">كل الأساتذة</option>
                    @foreach($teachers as $t)
                        <option value="{{ $t->id }}" {{ request('teacher_id') == $t->id ? 'selected' : '' }}>
                            {{ $t->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-gray-500 dark:text-gray-400 text-xs mb-1 font-bold">بحث بالعنوان</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث باسم المحاضرة..."
                       class="w-full bg-white dark:bg-[#161b22] border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 py-2.5 bg-sky-500 hover:bg-sky-600 text-white font-bold text-sm rounded-xl transition shadow-md shadow-sky-500/20">
                    <i class="fa-solid fa-filter ml-1"></i> تصفية
                </button>
                @if(request()->hasAny(['subject_id', 'teacher_id', 'search']))
                    <a href="{{ route('admin.lectures.index') }}" class="px-4 py-2.5 bg-gray-100 dark:bg-white/5 hover:bg-gray-200 dark:hover:bg-white/10 text-gray-700 dark:text-white font-bold text-sm rounded-xl transition">
                        إلغاء
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Lectures Table -->
    <div class="card-glass rounded-3xl overflow-hidden shadow-sm border border-gray-100 dark:border-white/5">
        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-white/5 text-gray-500">
                        <th class="p-4 font-bold">#</th>
                        <th class="p-4 font-bold">عنوان المحاضرة</th>
                        <th class="p-4 font-bold">المادة والصف</th>
                        <th class="p-4 font-bold">الأستاذ</th>
                        <th class="p-4 font-bold text-center">رابط الفيديو</th>
                        <th class="p-4 font-bold text-center">النوع</th>
                        <th class="p-4 font-bold text-center">حذف الرابط</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse($lessons as $lesson)
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                        <td class="p-4 text-gray-400 font-bold">{{ $lesson->id }}</td>
                        <td class="p-4">
                            <div class="font-bold text-[var(--text-color)] dark:text-white">{{ $lesson->title }}</div>
                            @if($lesson->description)
                                <div class="text-xs text-gray-400 mt-0.5">{{ Str::limit($lesson->description, 60) }}</div>
                            @endif
                        </td>
                        <td class="p-4">
                            <div class="font-bold text-amber-600 dark:text-sky-400">
                                {{ $lesson->course->subject->name ?? '---' }}
                            </div>
                            <div class="text-xs text-gray-400 font-medium">
                                {{ $lesson->course->subject->grade->name ?? '' }} - {{ $lesson->course->subject->grade->stage->name ?? '' }}
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-user-tie text-gray-400 text-xs"></i>
                                <span class="font-bold text-[var(--text-color)] dark:text-white">{{ $lesson->course->teacher->name ?? 'المنصة' }}</span>
                            </div>
                        </td>
                        <td class="p-4 text-center">
                            @if($lesson->video_url)
                                <a href="{{ $lesson->video_url }}" target="_blank" class="px-3 py-1.5 rounded-xl bg-red-500/10 hover:bg-red-500 hover:text-white text-red-500 text-xs font-bold inline-flex items-center gap-1.5 transition" title="فتح الرابط">
                                    <i class="fa-brands fa-youtube"></i>
                                    <span>مشاهدة الرابط</span>
                                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                </a>
                            @elseif($lesson->video_path)
                                <a href="{{ asset('storage/' . $lesson->video_path) }}" target="_blank" class="px-3 py-1.5 rounded-xl bg-blue-500/10 hover:bg-blue-500 hover:text-white text-blue-500 text-xs font-bold inline-flex items-center gap-1.5 transition">
                                    <i class="fa-solid fa-file-video"></i>
                                    <span>فيديو مرفوع</span>
                                </a>
                            @else
                                <span class="text-gray-400 text-xs">لا يوجد</span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            @if($lesson->is_free)
                                <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-[11px] font-bold">مجاني</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-400 text-[11px] font-bold">للمشتركين</span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            <form action="{{ route('admin.lectures.destroy', $lesson->id) }}" method="POST" data-confirm="هل أنت متأكد من رغبتك في حذف هذا الرابط والمحاضرة؟">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 hover:bg-red-500/10 text-red-500 rounded-lg transition" title="حذف الرابط نهائياً">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-12 text-center text-gray-400 font-bold">
                            لا توجد محاضرات أو روابط مطابقة. يمكنك رفع رابط جديد بالضغط على الزر أعلاه.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($lessons->hasPages())
        <div class="p-4 border-t border-gray-100 dark:border-white/5">
            {{ $lessons->links() }}
        </div>
        @endif
    </div>

    <!-- Modal إضافة / رفع رابط محاضرة جديد -->
    <template x-teleport="body">
        <div x-show="showAddModal" 
             class="fixed inset-0 z-[100] overflow-y-auto bg-black/60 backdrop-blur-sm"
             x-transition
             x-cloak>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="bg-white dark:bg-[#161b22] border border-gray-200 dark:border-white/10 w-full max-w-xl rounded-3xl p-7 shadow-2xl" @click.away="showAddModal = false">
                    <div class="flex justify-between items-center mb-6 border-b border-gray-100 dark:border-white/5 pb-4">
                        <h3 class="text-xl font-bold text-[var(--text-color)] dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-video text-emerald-500"></i>
                            <span>رفع رابط محاضرة جديدة</span>
                        </h3>
                        <button @click="showAddModal = false" class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <form action="{{ route('admin.lectures.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- اختيار المادة -->
                        <div>
                            <label class="block mb-1 text-xs text-gray-500 font-bold">المادة الدراسية والصف *</label>
                            <select name="subject_id" required class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-emerald-500 transition font-bold">
                                <option value="">-- اختر المادة --</option>
                                @foreach($stages as $stg)
                                    <optgroup label="=== {{ $stg->name }} ===">
                                        @foreach($stg->grades as $grd)
                                            @foreach($grd->subjects as $subj)
                                                <option value="{{ $subj->id }}">
                                                    {{ $subj->name }} ({{ $grd->name }})
                                                </option>
                                            @endforeach
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>

                        <!-- اختيار الأستاذ -->
                        <div>
                            <label class="block mb-1 text-xs text-gray-500 font-bold">الأستاذ القائم على الشرح *</label>
                            <select name="teacher_id" required class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-emerald-500 transition font-bold">
                                <option value="">-- اختر الأستاذ --</option>
                                @foreach($teachers as $tch)
                                    <option value="{{ $tch->id }}">
                                        {{ $tch->name }} {{ $tch->specialization ? '(' . $tch->specialization . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- عنوان المحاضرة -->
                        <div>
                            <label class="block mb-1 text-xs text-gray-500 font-bold">عنوان المحاضرة *</label>
                            <input type="text" name="title" required placeholder="مثال: المحاضرة 1 - الفصل الأول: الأساسيات"
                                   class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-emerald-500 transition">
                        </div>

                        <!-- رابط الفيديو / المحاضرة -->
                        <div>
                            <label class="block mb-1 text-xs text-gray-500 font-bold">رابط المحاضرة (يوتيوب أو رابط مباشر) *</label>
                            <input type="url" name="video_url" required placeholder="https://www.youtube.com/watch?v=..."
                                   class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-emerald-500 transition font-mono dir-ltr">
                        </div>

                        <!-- وصف مختصر -->
                        <div>
                            <label class="block mb-1 text-xs text-gray-500 font-bold">وصف المحاضرة (اختياري)</label>
                            <textarea name="description" rows="2" placeholder="نبذة عما يتضمنه هذا الدرس..."
                                      class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-emerald-500 transition"></textarea>
                        </div>

                        <div class="flex items-center gap-2 pt-2">
                            <input type="checkbox" name="is_free" id="admin_is_free" value="1" checked class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                            <label for="admin_is_free" class="text-xs font-bold text-gray-700 dark:text-gray-300">متاحة للمشتركين وأصحاب كود الاشتراك</label>
                        </div>

                        <div class="flex gap-3 pt-4 border-t border-gray-100 dark:border-white/5">
                            <button type="submit" class="flex-1 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl transition shadow-lg shadow-emerald-600/20">
                                <i class="fa-solid fa-cloud-arrow-up ml-1"></i> حفظ ورفع الرابط
                            </button>
                            <button type="button" @click="showAddModal = false" class="px-5 py-3 bg-gray-100 dark:bg-white/5 hover:bg-gray-200 dark:hover:bg-white/10 text-gray-700 dark:text-white font-bold text-sm rounded-xl transition">
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
