@extends('layouts.dashboard')

@section('title', 'رموز الاشتراك')
@section('page-title', 'إدارة رموز الاشتراك')

@section('content')
<div x-data="{ showGenModal: false }">

    <!-- Header -->
    <div class="mb-8 flex flex-wrap justify-between items-start gap-4">
        <div>
            <h1 class="text-3xl font-bold text-[var(--text-color)] dark:text-white mb-2">رموز الاشتراك</h1>
            <p class="text-gray-500">أنشئ رموز اشتراك للطلاب للوصول إلى المواد الدراسية.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.subscription-codes.export') }}" class="px-5 py-2.5 bg-gray-100 dark:bg-white/5 hover:bg-gray-200 dark:hover:bg-white/10 transition rounded-xl text-[var(--text-color)] dark:text-white font-bold text-sm flex items-center gap-2">
                <i class="fa-solid fa-file-csv"></i> تصدير CSV
            </a>
            <button @click="showGenModal = true" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 dark:bg-sky-500 dark:hover:bg-sky-600 transition rounded-xl text-white font-bold text-sm flex items-center gap-2 shadow-lg shadow-amber-500/20 dark:shadow-sky-500/20">
                <i class="fa-solid fa-plus"></i> توليد رموز جديدة
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="card-glass p-5 rounded-2xl border-r-4 border-emerald-500">
            <div class="text-xs text-gray-500 font-bold mb-1 uppercase tracking-wider">رموز نشطة</div>
            <div class="text-2xl font-black text-emerald-600 dark:text-emerald-400">{{ $stats['active'] }}</div>
        </div>
        <div class="card-glass p-5 rounded-2xl border-r-4 border-gray-400">
            <div class="text-xs text-gray-500 font-bold mb-1 uppercase tracking-wider">رموز مستخدمة</div>
            <div class="text-2xl font-black text-gray-600 dark:text-gray-400">{{ $stats['used'] }}</div>
        </div>
        <div class="card-glass p-5 rounded-2xl border-r-4 border-red-400">
            <div class="text-xs text-gray-500 font-bold mb-1 uppercase tracking-wider">إجمالي الرموز</div>
            <div class="text-2xl font-black text-[var(--text-color)] dark:text-white">{{ $stats['total'] }}</div>
        </div>
    </div>

    <!-- Filter -->
    <div class="card-glass p-5 mb-6 rounded-2xl">
        <form action="{{ route('admin.subscription-codes.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[130px]">
                <label class="block text-xs text-gray-500 font-bold mb-1">الحالة</label>
                <select name="status" class="w-full bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-3 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                    <option value="">كل الحالات</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>نشط</option>
                    <option value="used"   {{ request('status') === 'used'   ? 'selected' : '' }}>مستخدم</option>
                    <option value="expired"{{ request('status') === 'expired'? 'selected' : '' }}>منتهي</option>
                </select>
            </div>
            <div class="flex-1 min-w-[130px]">
                <label class="block text-xs text-gray-500 font-bold mb-1">الصف</label>
                <select name="grade_id" class="w-full bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-3 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                    <option value="">كل الصفوف</option>
                    @foreach($grades as $grade)
                        <option value="{{ $grade->id }}" {{ request('grade_id') == $grade->id ? 'selected' : '' }}>
                            {{ $grade->name }} - {{ $grade->stage->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-[130px]">
                <label class="block text-xs text-gray-500 font-bold mb-1">المادة</label>
                <select name="subject_id" class="w-full bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-3 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                    <option value="">كل المواد</option>
                    @foreach($subjects as $subj)
                        <option value="{{ $subj->id }}" {{ request('subject_id') == $subj->id ? 'selected' : '' }}>
                            {{ $subj->name }} ({{ $subj->grade->name }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-[130px]">
                <label class="block text-xs text-gray-500 font-bold mb-1">المدرس</label>
                <select name="teacher_id" class="w-full bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-3 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                    <option value="">كل المدرسين</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 dark:bg-sky-500 dark:hover:bg-sky-600 text-white font-bold rounded-xl transition text-sm">
                <i class="fa-solid fa-filter ml-1"></i> تصفية
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="card-glass rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-white/5 text-gray-500">
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent">الرمز</th>
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent">المادة والمدرس / الصف</th>
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent text-center">الحالة</th>
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent">استُخدم بواسطة</th>
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent">تاريخ الانتهاء</th>
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent text-center">حذف</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse($codes as $code)
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                        <td class="p-4">
                            <span class="font-black text-[var(--text-color)] dark:text-white tracking-widest text-base font-mono">{{ $code->code }}</span>
                        </td>
                        <td class="p-4">
                            <div class="font-bold text-[var(--text-color)] dark:text-white text-sm flex items-center gap-1.5">
                                <i class="fa-solid fa-book-open text-xs text-amber-500"></i>
                                <span>{{ $code->subject?->name ?? 'كل المواد' }}</span>
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center gap-1">
                                <i class="fa-solid fa-user-tie text-[10px] text-sky-500"></i>
                                <span>{{ $code->teacher ? $code->teacher->name : 'كل المدرسين' }}</span>
                            </div>
                            <div class="text-[11px] text-gray-400 mt-0.5">{{ $code->grade?->name ?? 'كل الصفوف' }}</div>
                        </td>
                        <td class="p-4 text-center">
                            @if($code->status === 'active')
                                <span class="px-2.5 py-1 rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400 text-xs font-black">نشط</span>
                            @elseif($code->status === 'used')
                                <span class="px-2.5 py-1 rounded-lg bg-gray-100 text-gray-600 dark:bg-white/5 dark:text-gray-400 text-xs font-black">مستخدم</span>
                            @else
                                <span class="px-2.5 py-1 rounded-lg bg-red-100 text-red-600 dark:bg-red-500/10 dark:text-red-400 text-xs font-black">منتهي</span>
                            @endif
                        </td>
                        <td class="p-4 text-gray-500 dark:text-gray-400 text-sm">
                            {{ $code->usedBy?->name ?? '---' }}
                            @if($code->used_at)
                                <div class="text-xs text-gray-400">{{ $code->used_at->format('Y-m-d') }}</div>
                            @endif
                        </td>
                        <td class="p-4 text-gray-500 text-sm">
                            {{ $code->expires_at?->format('Y-m-d') ?? 'لا يوجد' }}
                        </td>
                        <td class="p-4 text-center">
                            @if($code->status !== 'used')
                            <form action="{{ route('admin.subscription-codes.destroy', $code->id) }}" method="POST" data-confirm="هل تريد حذف هذا الرمز؟">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 hover:bg-red-500/10 rounded-lg text-red-500 transition">
                                    <i class="fa-solid fa-trash-can text-sm"></i>
                                </button>
                            </form>
                            @else
                                <span class="text-gray-300 dark:text-gray-600 text-xs">---</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-10 text-center text-gray-400 font-bold">لا توجد رموز بعد. اضغط على "توليد رموز جديدة" لإنشاء رموز.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($codes->hasPages())
        <div class="px-6 py-4 bg-gray-50/50 dark:bg-white/5">
            {{ $codes->links() }}
        </div>
        @endif
    </div>

    <!-- Modal توليد الرموز -->
    <template x-teleport="body">
        <div x-show="showGenModal" 
             class="fixed inset-0 z-[100] overflow-y-auto bg-black/60 backdrop-blur-sm"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-cloak>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="bg-white dark:bg-[#161b22] border border-gray-200 dark:border-white/10 w-full max-w-lg rounded-3xl p-7 shadow-2xl" @click.away="showGenModal = false">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-[var(--text-color)] dark:text-white">توليد رموز اشتراك جديدة</h3>
                        <button @click="showGenModal = false" class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <form action="{{ route('admin.subscription-codes.generate') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label class="block mb-1 text-xs text-gray-500 font-bold">الصف الدراسي (اختياري)</label>
                            <select name="grade_id" class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                                <option value="">كل الصفوف</option>
                                @foreach($stages as $stage)
                                    <optgroup label="{{ $stage->name }}">
                                        @foreach($stage->grades as $grade)
                                            <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block mb-1 text-xs text-gray-500 font-bold">المادة الدراسية (اختياري / مخصص لمادة)</label>
                            <select name="subject_id" class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                                <option value="">كل المواد</option>
                                @foreach($stages as $stage)
                                    @foreach($stage->grades as $grade)
                                        @foreach($grade->subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->name }} - {{ $grade->name }}</option>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block mb-1 text-xs text-gray-500 font-bold">المدرس (اختياري / مخصص لمدرس معين)</label>
                            <select name="teacher_id" class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                                <option value="">كل المدرسين (غير مقيد بمدرس)</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block mb-1 text-xs text-gray-500 font-bold">عدد الرموز المطلوب توليدها</label>
                            <input type="number" name="quantity" value="1" min="1" max="100" required
                                   class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                        </div>

                        <div>
                            <label class="block mb-1 text-xs text-gray-500 font-bold">تاريخ الانتهاء (اختياري)</label>
                            <input type="date" name="expires_at"
                                   class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                        </div>

                        <div>
                            <label class="block mb-1 text-xs text-gray-500 font-bold">ملاحظات (اختياري)</label>
                            <input type="text" name="notes" placeholder="مثال: للمجموعة أ - سبتمبر 2026"
                                   class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                        </div>

                        <div class="pt-2 flex gap-3">
                            <button type="submit" class="flex-1 py-3 rounded-xl bg-amber-500 hover:bg-amber-600 dark:bg-sky-500 dark:hover:bg-sky-600 transition text-white font-bold text-sm shadow-lg">
                                <i class="fa-solid fa-wand-magic-sparkles ml-1"></i> توليد الرموز
                            </button>
                            <button type="button" @click="showGenModal = false" class="flex-1 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-white/5 dark:hover:bg-white/10 transition text-[var(--text-color)] dark:text-white font-bold text-sm">
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
