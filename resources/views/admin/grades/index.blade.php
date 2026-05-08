@extends('layouts.dashboard')

@section('title', 'إدارة الصفوف الدراسية')
@section('page-title', 'إدارة الصفوف')

@section('content')
<div x-data="{ 
    showAddModal: false, 
    showEditModal: false,
    editGrade: { id: '', name: '', stage_id: '' },
    openEditModal(grade) {
        this.editGrade = { ...grade };
        this.showEditModal = true;
    }
}">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-[var(--text-color)] dark:text-white mb-2">الصفوف الدراسية</h1>
            <p class="text-gray-500">إدارة الصفوف التابعة للمراحل التعليمية المختلفة.</p>
        </div>
        <button @click="showAddModal = true" class="px-6 py-2 bg-sky-500 hover:bg-sky-600 transition rounded-xl text-white font-bold text-sm shadow-lg shadow-sky-500/20">
            + إضافة صف جديد
        </button>
    </div>



    <div class="card-glass p-6 mb-8 rounded-2xl">
        <form action="{{ route('admin.grades.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div class="md:col-span-3">
                <label class="block text-gray-500 dark:text-gray-400 text-xs mb-1 font-bold">تصفية حسب المرحلة التعليمية</label>
                <select name="stage_id" class="w-full bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition cursor-pointer">
                    <option value="">كل المراحل التعليمية</option>
                    @foreach($stages as $stage)
                        <option value="{{ $stage->id }}" {{ request('stage_id') == $stage->id ? 'selected' : '' }}>{{ $stage->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="w-full py-3 bg-sky-500 hover:bg-sky-600 text-white font-bold rounded-xl transition shadow-lg shadow-sky-500/20">
                    <i class="fa-solid fa-filter ml-2"></i> تصفية
                </button>
            </div>
        </form>
    </div>

    <div class="card-glass rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-white/5 text-gray-500">
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent">الصف الدراسي</th>
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent">المرحلة التعليمية</th>
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent text-center">عدد المواد</th>
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent text-center">العمليات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @foreach($grades as $grade)
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                        <td class="p-4 font-bold text-[var(--text-color)] dark:text-white">{{ $grade->name }}</td>
                        <td class="p-4 text-gray-500 dark:text-gray-400 font-medium">{{ $grade->stage->name }}</td>
                        <td class="p-4 text-center">
                            <span class="bg-sky-500/10 text-sky-400 px-2 py-1 rounded-lg text-xs">{{ $grade->subjects_count }} مواد</span>
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center space-x-2 space-x-reverse">
                                <button @click="openEditModal({ id: '{{ $grade->id }}', name: '{{ $grade->name }}', stage_id: '{{ $grade->stage_id }}' })" 
                                        class="p-2 hover:bg-sky-500/10 rounded-lg text-sky-400 transition" title="تعديل">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <form action="{{ route('admin.grades.destroy', $grade->id) }}" method="POST" data-confirm="هل أنت متأكد من حذف هذا الصف والمواد التابعة له؟">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 hover:bg-red-500/10 rounded-lg text-red-500 transition" title="حذف">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Grade Modal -->
    <template x-teleport="body">
        <div x-show="showAddModal" 
             class="fixed inset-0 z-[100] overflow-y-auto bg-black/60 backdrop-blur-sm"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="bg-white dark:bg-[#161b22] border border-gray-200 dark:border-white/10 w-full max-w-lg rounded-3xl p-6 shadow-2xl scale-up" @click.away="showAddModal = false">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-[var(--text-color)] dark:text-white">إضافة صف جديد</h3>
                        <button @click="showAddModal = false" class="text-gray-400 hover:text-gray-900 dark:text-gray-500 dark:hover:text-white transition">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <form action="{{ route('admin.grades.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block mb-1 text-xs text-gray-500 dark:text-gray-400 font-bold">المرحلة التعليمية</label>
                                <select name="stage_id" required class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                                    <option value="" disabled selected>اختر المرحلة</option>
                                    @foreach($stages as $stage)
                                        <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block mb-1 text-xs text-gray-500 dark:text-gray-400 font-bold">اسم الصف</label>
                                <input type="text" name="name" required class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition text-[var(--text-color)] dark:text-white" placeholder="مثال: الصف الأول الثانوي">
                            </div>

                            <div class="pt-2 flex space-x-3 space-x-reverse">
                                <button type="submit" class="flex-1 py-3 rounded-xl bg-amber-500 hover:bg-amber-600 dark:bg-sky-500 dark:hover:bg-sky-600 transition text-white font-bold text-base shadow-lg shadow-amber-500/20 dark:shadow-sky-500/20">حفظ الصف</button>
                                <button type="button" @click="showAddModal = false" class="flex-1 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-white/5 dark:hover:bg-white/10 transition text-gray-700 dark:text-white font-bold text-base">إلغاء</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>

    <!-- Edit Grade Modal -->
    <template x-teleport="body">
        <div x-show="showEditModal" 
             class="fixed inset-0 z-[100] overflow-y-auto bg-black/60 backdrop-blur-sm"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="bg-white dark:bg-[#161b22] border border-gray-200 dark:border-white/10 w-full max-w-lg rounded-3xl p-6 shadow-2xl scale-up" @click.away="showEditModal = false">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-[var(--text-color)] dark:text-white">تعديل الصف الدراسي</h3>
                        <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-900 dark:text-gray-500 dark:hover:text-white transition">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <form :action="'{{ url('admin/grades') }}/' + editGrade.id" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label class="block mb-1 text-xs text-gray-500 dark:text-gray-400 font-bold">المرحلة التعليمية</label>
                                <select name="stage_id" x-model="editGrade.stage_id" required class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                                    @foreach($stages as $stage)
                                        <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block mb-1 text-xs text-gray-500 dark:text-gray-400 font-bold">اسم الصف</label>
                                <input type="text" name="name" x-model="editGrade.name" required class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition text-[var(--text-color)] dark:text-white">
                            </div>

                            <div class="pt-2 flex space-x-3 space-x-reverse">
                                <button type="submit" class="flex-1 py-3 rounded-xl bg-amber-500 hover:bg-amber-600 dark:bg-sky-500 dark:hover:bg-sky-600 transition text-white font-bold text-base shadow-lg shadow-amber-500/20 dark:shadow-sky-500/20">تعديل الصف</button>
                                <button type="button" @click="showEditModal = false" class="flex-1 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-white/5 dark:hover:bg-white/10 transition text-gray-700 dark:text-white font-bold text-base">إلغاء</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>
@endsection
