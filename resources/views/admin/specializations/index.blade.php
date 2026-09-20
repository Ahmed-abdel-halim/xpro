@extends('layouts.dashboard')

@section('title', 'إدارة اختصاصات الأساتذة')
@section('page-title', 'إدارة الاختصاصات')

@section('content')
<div x-data="{ 
    showAddModal: false, 
    showEditModal: false,
    editSpec: { id: '', name: '' },
    openEdit(s) {
        this.editSpec = { ...s };
        this.showEditModal = true;
    }
}">
    <!-- Header -->
    <div class="mb-8 flex flex-wrap justify-between items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-[var(--text-color)] dark:text-white mb-2">اختصاصات الأساتذة</h1>
            <p class="text-gray-500">إضافة وحذف وتعديل الاختصاصات المتاحة للأساتذة للاختيار منها عند التسجيل في المنصة.</p>
        </div>
        <button @click="showAddModal = true" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-2xl transition flex items-center gap-2 shadow-xl shadow-emerald-600/20 hover:-translate-y-0.5">
            <i class="fa-solid fa-plus-circle"></i>
            <span>+ إضافة اختصاص جديد</span>
        </button>
    </div>

    <!-- Stats & Quick Add Card -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="card-glass p-6 rounded-2xl border-r-4 border-emerald-500 flex items-center justify-between">
            <div>
                <div class="text-xs text-gray-400 font-bold mb-1">إجمالي الاختصاصات المتاحة</div>
                <div class="text-3xl font-black text-[var(--text-color)] dark:text-white">{{ $specializations->count() }}</div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl">
                <i class="fa-solid fa-shapes"></i>
            </div>
        </div>

        <div class="card-glass p-6 rounded-2xl border-r-4 border-amber-500 flex items-center justify-between">
            <div>
                <div class="text-xs text-gray-400 font-bold mb-1">إجمالي الأساتذة الموزعين</div>
                <div class="text-3xl font-black text-[var(--text-color)] dark:text-white">
                    {{ $specializations->sum('teachers_count') }}
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xl">
                <i class="fa-solid fa-user-tie"></i>
            </div>
        </div>

        <!-- Quick inline add -->
        <div class="card-glass p-6 rounded-2xl border border-gray-100 dark:border-white/5 flex flex-col justify-center">
            <form action="{{ route('admin.specializations.store') }}" method="POST" class="flex gap-2">
                @csrf
                <input type="text" name="name" required placeholder="اسم اختصاص جديد..."
                       class="flex-1 bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-emerald-500 transition">
                <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl transition shadow-md shadow-emerald-600/20">
                    إضافة
                </button>
            </form>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card-glass rounded-3xl overflow-hidden shadow-sm border border-gray-100 dark:border-white/5">
        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-white/5 text-gray-500">
                        <th class="p-4 font-bold">#</th>
                        <th class="p-4 font-bold">اسم الاختصاص</th>
                        <th class="p-4 font-bold text-center">عدد الأساتذة المسجلين</th>
                        <th class="p-4 font-bold text-center">تاريخ الإضافة</th>
                        <th class="p-4 font-bold text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse($specializations as $index => $spec)
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                        <td class="p-4 text-gray-400 font-bold">{{ $index + 1 }}</td>
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-600 dark:bg-sky-500/10 dark:text-sky-400 flex items-center justify-center font-bold">
                                    <i class="fa-solid fa-book-open"></i>
                                </div>
                                <span class="font-black text-base text-[var(--text-color)] dark:text-white">{{ $spec->name }}</span>
                            </div>
                        </td>
                        <td class="p-4 text-center">
                            @if($spec->teachers_count > 0)
                                <span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-xs font-bold">
                                    {{ $spec->teachers_count }} أستاذ
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-gray-100 dark:bg-white/5 text-gray-400 text-xs font-medium">
                                    0 أستاذ
                                </span>
                            @endif
                        </td>
                        <td class="p-4 text-center text-xs text-gray-400 font-medium">
                            {{ $spec->created_at ? $spec->created_at->format('Y/m/d') : '---' }}
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <!-- تعديل -->
                                <button type="button" 
                                        @click="openEdit({ id: {{ $spec->id }}, name: '{{ addslashes($spec->name) }}' })"
                                        class="p-2 hover:bg-sky-500/10 text-sky-500 rounded-lg transition" title="تعديل اسم الاختصاص">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>

                                <!-- حذف -->
                                <form action="{{ route('admin.specializations.destroy', $spec->id) }}" method="POST" data-confirm="هل أنت متأكد من حذف اختصاص ({{ $spec->name }})؟">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 hover:bg-red-500/10 text-red-500 rounded-lg transition" title="حذف الاختصاص">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center text-gray-400 font-bold">
                            لا توجد أي اختصاصات مسجلة حالياً. يمكنك إضافة اختصاص بالضغط على الزر أعلاه.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal إضافة اختصاص جديد -->
    <template x-teleport="body">
        <div x-show="showAddModal" 
             class="fixed inset-0 z-[100] overflow-y-auto bg-black/60 backdrop-blur-sm"
             x-transition
             x-cloak>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="bg-white dark:bg-[#161b22] border border-gray-200 dark:border-white/10 w-full max-w-md rounded-3xl p-7 shadow-2xl" @click.away="showAddModal = false">
                    <div class="flex justify-between items-center mb-6 border-b border-gray-100 dark:border-white/5 pb-4">
                        <h3 class="text-xl font-bold text-[var(--text-color)] dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-plus-circle text-emerald-500"></i>
                            <span>إضافة اختصاص جديد</span>
                        </h3>
                        <button @click="showAddModal = false" class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <form action="{{ route('admin.specializations.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block mb-2 text-xs text-gray-500 font-bold">اسم الاختصاص الدراسي *</label>
                            <input type="text" name="name" required placeholder="مثال: رياضيات، فيزياء، حاسوب، تاريخ..."
                                   class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-emerald-500 transition font-bold">
                            <p class="text-[11px] text-gray-400 mt-2">
                                سيظهر هذا الاختصاص فوراً في قائمة الاختصاصات للأستاذ عند تسجيل حسابه في الموقع.
                            </p>
                        </div>

                        <div class="flex gap-3 pt-4 border-t border-gray-100 dark:border-white/5">
                            <button type="submit" class="flex-1 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl transition shadow-lg shadow-emerald-600/20">
                                <i class="fa-solid fa-check ml-1"></i> حفظ الاختصاص
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

    <!-- Modal تعديل اختصاص -->
    <template x-teleport="body">
        <div x-show="showEditModal" 
             class="fixed inset-0 z-[100] overflow-y-auto bg-black/60 backdrop-blur-sm"
             x-transition
             x-cloak>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="bg-white dark:bg-[#161b22] border border-gray-200 dark:border-white/10 w-full max-w-md rounded-3xl p-7 shadow-2xl" @click.away="showEditModal = false">
                    <div class="flex justify-between items-center mb-6 border-b border-gray-100 dark:border-white/5 pb-4">
                        <h3 class="text-xl font-bold text-[var(--text-color)] dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-pen-to-square text-sky-500"></i>
                            <span>تعديل اسم الاختصاص</span>
                        </h3>
                        <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <form :action="'/admin/specializations/' + editSpec.id" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block mb-2 text-xs text-gray-500 font-bold">اسم الاختصاص *</label>
                            <input type="text" name="name" required x-model="editSpec.name"
                                   class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-sky-500 transition font-bold">
                        </div>

                        <div class="flex gap-3 pt-4 border-t border-gray-100 dark:border-white/5">
                            <button type="submit" class="flex-1 py-3 bg-sky-500 hover:bg-sky-600 text-white font-bold text-sm rounded-xl transition shadow-lg shadow-sky-500/20">
                                <i class="fa-solid fa-save ml-1"></i> حفظ التعديل
                            </button>
                            <button type="button" @click="showEditModal = false" class="px-5 py-3 bg-gray-100 dark:bg-white/5 hover:bg-gray-200 dark:hover:bg-white/10 text-gray-700 dark:text-white font-bold text-sm rounded-xl transition">
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
