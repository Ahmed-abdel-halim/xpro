@extends('layouts.dashboard')

@section('title', 'إدارة الأساتذة')
@section('page-title', 'قائمة الأساتذة')

@section('content')
<div x-data="{ 
    showAddModal: false, 
    showEditModal: false,
    editTeacher: { id: '', name: '', email: '', phone: '', specialization: '', commission: 20, is_approved: true },
    openEdit(t) {
        this.editTeacher = { ...t };
        this.showEditModal = true;
    }
}">
    <!-- Header -->
    <div class="mb-8 flex flex-wrap justify-between items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-[var(--text-color)] dark:text-white mb-2">الأساتذة</h1>
            <p class="text-gray-500">إدارة أساتذة المنصة، وتحديد اختصاصاتهم، وإضافة أساتذة جدد وتعديل بياناتهم.</p>
        </div>
        <button @click="showAddModal = true" class="px-6 py-3 bg-amber-500 hover:bg-amber-600 dark:bg-sky-500 dark:hover:bg-sky-600 text-white font-bold text-sm rounded-2xl transition flex items-center gap-2 shadow-lg shadow-amber-500/20 dark:shadow-sky-500/20">
            <i class="fa-solid fa-user-plus"></i>
            <span>إضافة أستاذ جديد</span>
        </button>
    </div>

    <!-- Table -->
    <div class="card-glass rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-white/5 text-gray-500">
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent">الأستاذ</th>
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent">الاختصاص (المادة)</th>
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent">رقم الهاتف</th>
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent">البريد الإلكتروني</th>
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent text-center">نسبة العمولة</th>
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent text-center">الحالة</th>
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse($teachers as $teacher)
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                        <td class="p-4">
                            <div class="flex items-center space-x-3 space-x-reverse">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-amber-500 to-orange-600 dark:from-sky-500 dark:to-indigo-600 flex items-center justify-center text-white font-bold">
                                    {{ mb_substr($teacher->name, 0, 1) }}
                                </div>
                                <div>
                                    <span class="font-bold text-[var(--text-color)] dark:text-white block">{{ $teacher->name }}</span>
                                    <span class="text-xs text-gray-400">انضم: {{ $teacher->created_at->format('Y/m/d') }}</span>
                                </div>
                            </div>
                        </td>

                        <td class="p-4 font-bold">
                            @if($teacher->specialization)
                                <span class="px-2.5 py-1 rounded-lg bg-amber-500/10 text-amber-600 dark:bg-sky-500/10 dark:text-sky-400 text-xs inline-flex items-center gap-1">
                                    <i class="fa-solid fa-book-open text-[10px]"></i>
                                    {{ $teacher->specialization }}
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">غير محدد</span>
                            @endif
                        </td>
                        
                        <td class="p-4 text-gray-500 dark:text-gray-400 font-medium">
                            {{ $teacher->phone ?? '---' }}
                        </td>
                        <td class="p-4 text-gray-500 dark:text-gray-400 font-medium">
                            {{ $teacher->email }}
                        </td>
                        
                        <td class="p-4 text-center font-bold text-amber-600 dark:text-sky-400">
                            {{ (float)$teacher->commission_percentage }}%
                        </td>

                        <td class="p-4 text-center">
                            @if($teacher->is_approved)
                                <span class="bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 px-3 py-1 rounded-full text-xs font-bold">معتمد</span>
                            @else
                                <span class="bg-amber-500/10 text-amber-600 dark:text-amber-400 px-3 py-1 rounded-full text-xs font-bold">قيد المراجعة</span>
                            @endif
                        </td>

                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center space-x-2 space-x-reverse">
                                @if(!$teacher->is_approved)
                                    <button type="button" onclick="document.getElementById('approve-form-{{ $teacher->id }}').submit()" class="px-2.5 py-1.5 bg-emerald-500/10 hover:bg-emerald-500 text-emerald-600 hover:text-white rounded-lg text-xs font-bold transition" title="اعتماد الأستاذ">
                                        <i class="fa-solid fa-check ml-1"></i> اعتماد
                                    </button>
                                @endif

                                <!-- زر التعديل -->
                                <button type="button" 
                                        @click="openEdit({
                                            id: {{ $teacher->id }},
                                            name: '{{ addslashes($teacher->name) }}',
                                            email: '{{ addslashes($teacher->email) }}',
                                            phone: '{{ addslashes($teacher->phone ?? '') }}',
                                            specialization: '{{ addslashes($teacher->specialization ?? '') }}',
                                            commission: {{ (float)$teacher->commission_percentage }},
                                            is_approved: {{ $teacher->is_approved ? 'true' : 'false' }}
                                        })" 
                                        class="p-2 hover:bg-sky-500/10 text-sky-500 rounded-lg transition" title="تعديل بيانات الأستاذ">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>

                                <!-- زر الحذف -->
                                <button type="button" onclick="if(confirm('هل أنت متأكد من حذف هذا الأستاذ؟ سيتم حذف دوراته أيضاً.')) document.getElementById('delete-form-{{ $teacher->id }}').submit()" class="p-2 hover:bg-red-500/10 rounded-lg text-red-500 transition" title="حذف">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>

                        <form id="approve-form-{{ $teacher->id }}" action="{{ route('admin.users.approve', $teacher->id) }}" method="POST" class="hidden">@csrf</form>
                        <form id="delete-form-{{ $teacher->id }}" action="{{ route('admin.users.destroy', $teacher->id) }}" method="POST" class="hidden">@csrf @method('DELETE')</form>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-gray-400 font-bold">لا يوجد أساتذة مسجلون حتى الآن.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal إضافة أستاذ جديد -->
    <template x-teleport="body">
        <div x-show="showAddModal" 
             class="fixed inset-0 z-[100] overflow-y-auto bg-black/60 backdrop-blur-sm"
             x-transition
             x-cloak>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="bg-white dark:bg-[#161b22] border border-gray-200 dark:border-white/10 w-full max-w-lg rounded-3xl p-7 shadow-2xl" @click.away="showAddModal = false">
                    <div class="flex justify-between items-center mb-6 border-b border-gray-100 dark:border-white/5 pb-4">
                        <h3 class="text-xl font-bold text-[var(--text-color)] dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-user-plus text-amber-500 dark:text-sky-400"></i>
                            <span>إضافة أستاذ جديد</span>
                        </h3>
                        <button @click="showAddModal = false" class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <form action="{{ route('admin.teachers.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block mb-1 text-xs text-gray-500 font-bold">اسم الأستاذ *</label>
                            <input type="text" name="name" required placeholder="مثال: الأستاذ علي محمد"
                                   class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                        </div>

                        <div>
                            <label class="block mb-1 text-xs text-gray-500 font-bold">الاختصاص (المادة الدراسية)</label>
                            <input type="text" name="specialization" placeholder="مثال: رياضيات، كيمياء، فيزياء، إنكليزي"
                                   class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-1 text-xs text-gray-500 font-bold">البريد الإلكتروني *</label>
                                <input type="email" name="email" required placeholder="teacher@example.com"
                                       class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                            </div>
                            <div>
                                <label class="block mb-1 text-xs text-gray-500 font-bold">رقم الهاتف</label>
                                <input type="text" name="phone" placeholder="077xxxxxxxx"
                                       class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-1 text-xs text-gray-500 font-bold">كلمة المرور *</label>
                                <input type="password" name="password" required placeholder="لا تقل عن 6 أحرف"
                                       class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                            </div>
                            <div>
                                <label class="block mb-1 text-xs text-gray-500 font-bold">نسبة العمولة (%)</label>
                                <input type="number" step="0.5" min="0" max="100" name="commission_percentage" value="20"
                                       class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                            </div>
                        </div>

                        <div class="flex items-center gap-2 pt-2">
                            <input type="checkbox" name="is_approved" id="add_is_approved" value="1" checked class="rounded border-gray-300 text-amber-500 focus:ring-amber-500">
                            <label for="add_is_approved" class="text-xs font-bold text-gray-700 dark:text-gray-300">اعتماد الأستاذ فوراً وتفعيل حسابه</label>
                        </div>

                        <div class="flex gap-3 pt-4 border-t border-gray-100 dark:border-white/5">
                            <button type="submit" class="flex-1 py-3 bg-amber-500 hover:bg-amber-600 dark:bg-sky-500 dark:hover:bg-sky-600 text-white font-bold text-sm rounded-xl transition">
                                <i class="fa-solid fa-check ml-1"></i> حفظ وإضافة الأستاذ
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

    <!-- Modal تعديل بيانات الأستاذ -->
    <template x-teleport="body">
        <div x-show="showEditModal" 
             class="fixed inset-0 z-[100] overflow-y-auto bg-black/60 backdrop-blur-sm"
             x-transition
             x-cloak>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="bg-white dark:bg-[#161b22] border border-gray-200 dark:border-white/10 w-full max-w-lg rounded-3xl p-7 shadow-2xl" @click.away="showEditModal = false">
                    <div class="flex justify-between items-center mb-6 border-b border-gray-100 dark:border-white/5 pb-4">
                        <h3 class="text-xl font-bold text-[var(--text-color)] dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-user-pen text-sky-500"></i>
                            <span>تعديل بيانات الأستاذ</span>
                        </h3>
                        <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <form :action="'/admin/teachers/' + editTeacher.id" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block mb-1 text-xs text-gray-500 font-bold">اسم الأستاذ *</label>
                            <input type="text" name="name" required x-model="editTeacher.name"
                                   class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-sky-500 transition">
                        </div>

                        <div>
                            <label class="block mb-1 text-xs text-gray-500 font-bold">الاختصاص (المادة الدراسية)</label>
                            <input type="text" name="specialization" x-model="editTeacher.specialization" placeholder="مثال: رياضيات، فيزياء..."
                                   class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-sky-500 transition">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-1 text-xs text-gray-500 font-bold">البريد الإلكتروني *</label>
                                <input type="email" name="email" required x-model="editTeacher.email"
                                       class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-sky-500 transition">
                            </div>
                            <div>
                                <label class="block mb-1 text-xs text-gray-500 font-bold">رقم الهاتف</label>
                                <input type="text" name="phone" x-model="editTeacher.phone"
                                       class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-sky-500 transition">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-1 text-xs text-gray-500 font-bold">كلمة المرور الجديدة</label>
                                <input type="password" name="password" placeholder="اتركها فارغة لعدم التغيير"
                                       class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-sky-500 transition">
                            </div>
                            <div>
                                <label class="block mb-1 text-xs text-gray-500 font-bold">نسبة العمولة (%)</label>
                                <input type="number" step="0.5" min="0" max="100" name="commission_percentage" x-model="editTeacher.commission"
                                       class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-sky-500 transition">
                            </div>
                        </div>

                        <div class="flex items-center gap-2 pt-2">
                            <input type="checkbox" name="is_approved" id="edit_is_approved" value="1" x-model="editTeacher.is_approved" class="rounded border-gray-300 text-sky-500 focus:ring-sky-500">
                            <label for="edit_is_approved" class="text-xs font-bold text-gray-700 dark:text-gray-300">حساب معتمد ومفعّل</label>
                        </div>

                        <div class="flex gap-3 pt-4 border-t border-gray-100 dark:border-white/5">
                            <button type="submit" class="flex-1 py-3 bg-sky-500 hover:bg-sky-600 text-white font-bold text-sm rounded-xl transition">
                                <i class="fa-solid fa-save ml-1"></i> حفظ التعديلات
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
