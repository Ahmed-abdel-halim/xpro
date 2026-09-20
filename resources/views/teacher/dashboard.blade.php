@extends('layouts.dashboard')

@section('title', 'لوحة الأستاذ')
@section('page-title', 'لوحة التحكم وإدارة المحاضرات')

@section('content')
<div x-data="{ showUploadModal: false }">
    <!-- Welcome Header -->
    <div class="mb-10 flex flex-wrap justify-between items-center gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2 flex-wrap">
                <h1 class="text-3xl font-black text-[var(--text-color)] dark:text-white">
                    أهلاً بك يا أستاذ/ {{ explode(' ', auth()->user()->name)[0] }}
                </h1>
                @if(auth()->user()->specialization)
                    <span class="px-3 py-1 bg-amber-500/10 text-amber-600 dark:bg-sky-500/10 dark:text-sky-400 font-bold rounded-xl text-xs flex items-center gap-1.5 border border-amber-500/20 dark:border-sky-500/20">
                        <i class="fa-solid fa-book-open"></i>
                        اختصاصك: {{ auth()->user()->specialization }}
                    </span>
                @endif
            </div>
            <p class="text-gray-500 font-medium">يمكنك من هنا رفع روابط محاضراتك ومتابعة تفاعل الطلاب مع مقرراتك.</p>
        </div>

        <div class="flex items-center gap-3 flex-wrap">
            <!-- الزر الرئيسي لرفع رابط المحاضرة -->
            <button @click="showUploadModal = true" 
                    class="px-6 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-2xl transition flex items-center gap-2 shadow-xl shadow-emerald-600/25 hover:-translate-y-0.5">
                <i class="fa-solid fa-video text-base"></i>
                <span>+ رفع رابط محاضرة جديدة</span>
            </button>

            <a href="{{ route('teacher.courses.create') }}" class="px-5 py-3.5 bg-gray-100 hover:bg-gray-200 dark:bg-white/5 dark:hover:bg-white/10 text-[var(--text-color)] dark:text-white font-bold text-sm rounded-2xl transition flex items-center gap-2 border border-gray-200 dark:border-white/10">
                <i class="fa-solid fa-folder-plus"></i>
                <span>إضافة كورس</span>
            </a>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="card-glass p-6 rounded-2xl border-r-4 border-sky-500">
            <div class="text-gray-500 text-[10px] font-bold mb-1 uppercase tracking-wider">إجمالي الطلاب</div>
            <div class="text-2xl font-black text-[var(--text-color)] dark:text-white">{{ number_format($stats['total_students']) }}</div>
        </div>

        <div class="card-glass p-6 rounded-2xl border-r-4 border-green-500">
            <div class="text-gray-500 text-[10px] font-bold mb-1 uppercase tracking-wider">صافي الأرباح</div>
            <div class="text-2xl font-black text-green-600 dark:text-green-400">{{ number_format($stats['total_revenue']) }} <span class="text-xs">د.ع</span></div>
        </div>

        <div class="card-glass p-6 rounded-2xl border-r-4 border-amber-500">
            <div class="text-gray-500 text-[10px] font-bold mb-1 uppercase tracking-wider">نسبة المنصة (مستحقة)</div>
            <div class="text-2xl font-black text-amber-600 dark:text-amber-400">{{ number_format($stats['pending_commission']) }} <span class="text-xs">د.ع</span></div>
        </div>

        <div class="card-glass p-6 rounded-2xl border-r-4 border-purple-500">
            <div class="text-gray-500 text-[10px] font-bold mb-1 uppercase tracking-wider">كورساتي المرفوعة</div>
            <div class="text-2xl font-black text-[var(--text-color)] dark:text-white">{{ $stats['total_courses'] }}</div>
        </div>
    </div>

    <!-- My Uploaded Lectures Section -->
    <div class="card-glass rounded-3xl p-8 mb-10 border border-gray-100 dark:border-white/5 shadow-sm">
        <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
            <div>
                <h3 class="text-xl font-bold text-[var(--text-color)] dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-play-circle text-emerald-500"></i>
                    <span>محاضراتي وروابطي المرفوعة</span>
                </h3>
                <p class="text-xs text-gray-400 mt-1">قائمة بآخر المحاضرات التي قمت برفعها ومشاركتها مع الطلاب في مادتك.</p>
            </div>
            <button @click="showUploadModal = true" class="text-sm font-bold text-emerald-600 dark:text-emerald-400 hover:underline flex items-center gap-1">
                <span>رفع محاضرة إضافية</span>
                <i class="fa-solid fa-arrow-left text-xs"></i>
            </button>
        </div>

        @if(isset($myLessons) && $myLessons->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-right text-sm">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-white/5 text-gray-500">
                            <th class="p-3 font-bold">عنوان المحاضرة</th>
                            <th class="p-3 font-bold">المادة والصف</th>
                            <th class="p-3 font-bold text-center">رابط الفيديو</th>
                            <th class="p-3 font-bold text-center">النوع</th>
                            <th class="p-3 font-bold text-center">تاريخ الإضافة</th>
                            <th class="p-3 font-bold text-center">حذف</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                        @foreach($myLessons as $l)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                            <td class="p-3 font-bold text-[var(--text-color)] dark:text-white">
                                {{ $l->title }}
                            </td>
                            <td class="p-3">
                                <span class="px-2.5 py-1 rounded-lg bg-amber-500/10 text-amber-600 dark:bg-sky-500/10 dark:text-sky-400 font-bold text-xs">
                                    {{ $l->course->subject->name ?? '---' }}
                                </span>
                                <span class="text-xs text-gray-400 mr-1">({{ $l->course->subject->grade->name ?? '' }})</span>
                            </td>
                            <td class="p-3 text-center">
                                @if($l->video_url)
                                    <a href="{{ $l->video_url }}" target="_blank" class="px-3 py-1.5 rounded-xl bg-red-500/10 hover:bg-red-500 hover:text-white text-red-500 text-xs font-bold inline-flex items-center gap-1.5 transition">
                                        <i class="fa-brands fa-youtube"></i>
                                        <span>مشاهدة</span>
                                        <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                                    </a>
                                @elseif($l->video_path)
                                    <a href="{{ asset('storage/' . $l->video_path) }}" target="_blank" class="px-3 py-1.5 rounded-xl bg-blue-500/10 hover:bg-blue-500 hover:text-white text-blue-500 text-xs font-bold inline-flex items-center gap-1.5 transition">
                                        <i class="fa-solid fa-file-video"></i>
                                        <span>فيديو مرفوع</span>
                                    </a>
                                @else
                                    <span class="text-gray-400 text-xs">لا يوجد رابط</span>
                                @endif
                            </td>
                            <td class="p-3 text-center">
                                @if($l->is_free)
                                    <span class="px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-[11px] font-bold">مجاني</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full bg-gray-100 dark:bg-white/10 text-gray-600 dark:text-gray-400 text-[11px] font-bold">للمشتركين</span>
                                @endif
                            </td>
                            <td class="p-3 text-center text-xs text-gray-400">
                                {{ $l->created_at ? $l->created_at->format('Y/m/d') : '---' }}
                            </td>
                            <td class="p-3 text-center">
                                <form action="{{ route('teacher.lectures.destroy', $l->id) }}" method="POST" data-confirm="هل أنت متأكد من حذف هذه المحاضرة؟">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 hover:bg-red-500/10 text-red-500 rounded-lg transition" title="حذف">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="py-10 text-center rounded-2xl bg-gray-50 dark:bg-white/5 border border-dashed border-gray-200 dark:border-white/10">
                <div class="w-16 h-16 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl">
                    <i class="fa-solid fa-video"></i>
                </div>
                <h4 class="font-bold text-gray-800 dark:text-white mb-1">لم تقم برفع أي روابط محاضرات حتى الآن</h4>
                <p class="text-gray-500 dark:text-gray-400 text-xs mb-4">اضغط على الزر أدناه لوضع رابط أول محاضرة لك في مادتك ليتمكن الطلاب من مشاهدتها فوراً.</p>
                <button @click="showUploadModal = true" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl transition shadow-md shadow-emerald-600/20">
                    + رفع رابط المحاضرة الأولى
                </button>
            </div>
        @endif
    </div>

    <!-- Bottom Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Quick Actions -->
        <div class="card-glass p-8 rounded-3xl border border-gray-100 dark:border-white/5">
            <h3 class="text-xl font-bold text-[var(--text-color)] dark:text-white mb-6">إجراءات سريعة</h3>
            <div class="grid grid-cols-2 gap-4">
                <button @click="showUploadModal = true" class="p-6 bg-gray-50 dark:bg-white/5 rounded-2xl border border-gray-100 dark:border-white/5 hover:border-emerald-500/50 hover:bg-emerald-50 dark:hover:bg-emerald-500/5 transition group text-center block shadow-sm">
                    <div class="w-12 h-12 bg-emerald-100 text-emerald-600 dark:bg-emerald-500/20 rounded-xl flex items-center justify-center dark:text-emerald-400 group-hover:bg-emerald-500 dark:group-hover:bg-white/20 group-hover:text-white mx-auto mb-4 transition-colors">
                        <i class="fa-solid fa-video text-xl"></i>
                    </div>
                    <span class="text-[var(--text-color)] dark:text-white font-bold block transition-colors">رفع رابط محاضرة</span>
                </button>
                <a href="{{ route('teacher.courses.index') }}" class="p-6 bg-gray-50 dark:bg-white/5 rounded-2xl border border-gray-100 dark:border-white/5 hover:border-purple-500/50 hover:bg-purple-50 dark:hover:bg-purple-500/5 transition group text-center block shadow-sm">
                    <div class="w-12 h-12 bg-purple-100 text-purple-600 dark:bg-purple-500/20 rounded-xl flex items-center justify-center dark:text-purple-400 group-hover:bg-purple-500 dark:group-hover:bg-white/20 group-hover:text-white mx-auto mb-4 transition-colors">
                        <i class="fa-solid fa-folder-tree text-xl"></i>
                    </div>
                    <span class="text-[var(--text-color)] dark:text-white font-bold block transition-colors">إدارة الكورسات</span>
                </a>
            </div>
        </div>

        <!-- Student Activity -->
        <div class="card-glass p-8 rounded-3xl border border-gray-100 dark:border-white/5">
            <h3 class="text-xl font-bold text-[var(--text-color)] dark:text-white mb-6">آخر الطلاب المنضمين</h3>
            <div class="space-y-4">
                @forelse($recentEnrollments as $enrollment)
                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-white/5 rounded-2xl border border-gray-100 dark:border-white/5 shadow-sm">
                    <div class="flex items-center space-x-4 space-x-reverse">
                        <div class="w-10 h-10 bg-amber-100 text-amber-600 dark:bg-sky-500/20 rounded-full flex items-center justify-center dark:text-sky-400">
                            <i class="fa-solid fa-user-graduate"></i>
                        </div>
                        <div>
                            <div class="font-bold text-[var(--text-color)] dark:text-white">{{ $enrollment->student->name }}</div>
                            <div class="text-[10px] text-gray-500 dark:text-gray-400 font-bold mt-1">اشترك في: {{ $enrollment->course->title }}</div>
                        </div>
                    </div>
                    <span class="text-[10px] text-gray-500 font-bold bg-white dark:bg-black/20 px-2 py-1 rounded-lg border border-gray-100 dark:border-white/5">{{ $enrollment->created_at ? $enrollment->created_at->diffForHumans() : 'غير محدد' }}</span>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center py-10 text-gray-500 dark:text-gray-600">
                    <i class="fa-solid fa-users-slash text-4xl mb-4"></i>
                    <p class="text-sm font-bold">لا يوجد طلاب مشتركين حالياً.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Modal رفع رابط المحاضرة السريعة -->
    <template x-teleport="body">
        <div x-show="showUploadModal" 
             class="fixed inset-0 z-[100] overflow-y-auto bg-black/60 backdrop-blur-sm"
             x-transition
             x-cloak>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="bg-white dark:bg-[#161b22] border border-gray-200 dark:border-white/10 w-full max-w-lg rounded-3xl p-7 shadow-2xl" @click.away="showUploadModal = false">
                    <div class="flex justify-between items-center mb-6 border-b border-gray-100 dark:border-white/5 pb-4">
                        <h3 class="text-xl font-bold text-[var(--text-color)] dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-video text-emerald-500"></i>
                            <span>رفع رابط محاضرة جديدة</span>
                        </h3>
                        <button @click="showUploadModal = false" class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <form action="{{ route('teacher.lectures.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- اختيار المادة -->
                        <div>
                            <label class="block mb-1 text-xs text-gray-500 font-bold">المادة الدراسية والصف *</label>
                            <select name="subject_id" required class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-emerald-500 transition font-bold">
                                <option value="">-- اختر المادة --</option>
                                @if(isset($subjects))
                                    @foreach($subjects as $sb)
                                        @php
                                            $isMatch = auth()->user()->specialization && (
                                                $sb->name === auth()->user()->specialization || 
                                                str_contains($sb->name, auth()->user()->specialization)
                                            );
                                        @endphp
                                        <option value="{{ $sb->id }}" {{ $isMatch ? 'selected' : '' }}>
                                            {{ $sb->name }} ({{ $sb->grade->name }} - {{ $sb->grade->stage->name }})
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <!-- عنوان المحاضرة -->
                        <div>
                            <label class="block mb-1 text-xs text-gray-500 font-bold">عنوان المحاضرة / الدرس *</label>
                            <input type="text" name="title" required placeholder="مثال: المحاضرة الأولى: مقدمة في المنهج"
                                   class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-emerald-500 transition">
                        </div>

                        <!-- رابط المحاضرة -->
                        <div>
                            <label class="block mb-1 text-xs text-gray-500 font-bold">رابط المحاضرة (يوتيوب أو رابط مباشر) *</label>
                            <input type="url" name="video_url" required placeholder="https://www.youtube.com/watch?v=..."
                                   class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-emerald-500 transition font-mono dir-ltr">
                        </div>

                        <!-- وصف مختصر -->
                        <div>
                            <label class="block mb-1 text-xs text-gray-500 font-bold">وصف المحاضرة (اختياري)</label>
                            <textarea name="description" rows="2" placeholder="اكتب نبذة سريعة عما سيتعلمه الطالب في هذا الدرس..."
                                      class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-emerald-500 transition"></textarea>
                        </div>

                        <div class="flex items-center gap-2 pt-2">
                            <input type="checkbox" name="is_free" id="teacher_is_free" value="1" checked class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                            <label for="teacher_is_free" class="text-xs font-bold text-gray-700 dark:text-gray-300">محاضرة متاحة للطلاب والمشتركين</label>
                        </div>

                        <div class="flex gap-3 pt-4 border-t border-gray-100 dark:border-white/5">
                            <button type="submit" class="flex-1 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl transition shadow-lg shadow-emerald-600/20">
                                <i class="fa-solid fa-cloud-arrow-up ml-1"></i> رفع ونشر الرابط
                            </button>
                            <button type="button" @click="showUploadModal = false" class="px-5 py-3 bg-gray-100 dark:bg-white/5 hover:bg-gray-200 dark:hover:bg-white/10 text-gray-700 dark:text-white font-bold text-sm rounded-xl transition">
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
