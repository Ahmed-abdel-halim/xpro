@extends('layouts.dashboard')

@section('title', 'إدارة الطلاب')
@section('page-title', 'قائمة الطلاب')

@section('content')
<div x-data="{ 
    showAddModal: false, 
    showEditModal: false,
    editStudent: { id: '', name: '', email: '', phone: '' },
    openEdit(s) {
        this.editStudent = { ...s };
        this.showEditModal = true;
    }
}">
    <!-- Header -->
    <div class="mb-8 flex flex-wrap justify-between items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-[var(--text-color)] dark:text-white mb-2">الطلاب</h1>
            <p class="text-gray-500">متابعة الطلاب المسجلين، إضافة طلاب جدد، وتعديل بياناتهم.</p>
        </div>
        <button @click="showAddModal = true" class="px-6 py-3 bg-amber-500 hover:bg-amber-600 dark:bg-sky-500 dark:hover:bg-sky-600 text-white font-bold text-sm rounded-2xl transition flex items-center gap-2 shadow-lg shadow-amber-500/20 dark:shadow-sky-500/20">
            <i class="fa-solid fa-user-plus"></i>
            <span>إضافة طالب جديد</span>
        </button>
    </div>

    <!-- Table -->
    <div class="card-glass rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-white/5 text-gray-500">
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent">الطالب</th>
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent">رقم الهاتف</th>
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent">البريد الإلكتروني</th>
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent">تاريخ التسجيل</th>
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent text-center">الكورسات المشترك بها</th>
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse($students as $student)
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                        <td class="p-4">
                            <div class="flex items-center space-x-3 space-x-reverse">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-sky-500 to-indigo-600 flex items-center justify-center text-white font-bold text-xs">
                                    {{ mb_substr($student->name, 0, 1) }}
                                </div>
                                <span class="font-bold text-[var(--text-color)] dark:text-white">{{ $student->name }}</span>
                            </div>
                        </td>
                        <td class="p-4 text-gray-500 dark:text-gray-400 font-medium">{{ $student->phone ?? '---' }}</td>
                        <td class="p-4 text-gray-500 dark:text-gray-400 font-medium">{{ $student->email }}</td>
                        <td class="p-4 text-gray-500 dark:text-gray-400 font-medium">{{ $student->created_at->format('Y/m/d') }}</td>
                        <td class="p-4 text-center">
                            <span class="bg-sky-50 text-sky-600 border border-sky-100 dark:bg-blue-500/10 dark:text-blue-400 dark:border-transparent px-2.5 py-1 rounded-lg text-xs font-bold">{{ $student->enrollments_count ?? $student->enrolledCourses()->count() }} كورسات</span>
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center space-x-2 space-x-reverse">
                                <!-- زر التعديل -->
                                <button type="button" 
                                        @click="openEdit({
                                            id: {{ $student->id }},
                                            name: '{{ addslashes($student->name) }}',
                                            email: '{{ addslashes($student->email) }}',
                                            phone: '{{ addslashes($student->phone ?? '') }}'
                                        })" 
                                        class="p-2 hover:bg-sky-500/10 text-sky-500 rounded-lg transition" title="تعديل بيانات الطالب">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>

                                <!-- زر الحذف -->
                                <form action="{{ route('admin.users.destroy', $student->id) }}" method="POST" data-confirm="هل أنت متأكد من حذف هذا الطالب؟ سيتم إلغاء جميع اشتراكاته.">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 hover:bg-red-500/10 rounded-lg text-red-500 transition" title="حذف">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-400 font-bold">لا يوجد طلاب مسجلون حتى الآن.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal إضافة طالب جديد -->
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
                            <span>إضافة طالب جديد</span>
                        </h3>
                        <button @click="showAddModal = false" class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <form action="{{ route('admin.students.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block mb-1 text-xs text-gray-500 font-bold">اسم الطالب *</label>
                            <input type="text" name="name" required placeholder="مثال: محمد أحمد"
                                   class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                        </div>

                        <div>
                            <label class="block mb-1 text-xs text-gray-500 font-bold">البريد الإلكتروني *</label>
                            <input type="email" name="email" required placeholder="student@example.com"
                                   class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-1 text-xs text-gray-500 font-bold">رقم الهاتف</label>
                                <input type="text" name="phone" placeholder="077xxxxxxxx"
                                       class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                            </div>
                            <div>
                                <label class="block mb-1 text-xs text-gray-500 font-bold">كلمة المرور *</label>
                                <input type="password" name="password" required placeholder="لا تقل عن 6 أحرف"
                                       class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                            </div>
                        </div>

                        <div class="flex gap-3 pt-4 border-t border-gray-100 dark:border-white/5">
                            <button type="submit" class="flex-1 py-3 bg-amber-500 hover:bg-amber-600 dark:bg-sky-500 dark:hover:bg-sky-600 text-white font-bold text-sm rounded-xl transition">
                                <i class="fa-solid fa-check ml-1"></i> حفظ وإضافة الطالب
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

    <!-- Modal تعديل بيانات الطالب -->
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
                            <span>تعديل بيانات الطالب</span>
                        </h3>
                        <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <form :action="'/admin/students/' + editStudent.id" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block mb-1 text-xs text-gray-500 font-bold">اسم الطالب *</label>
                            <input type="text" name="name" required x-model="editStudent.name"
                                   class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-sky-500 transition">
                        </div>

                        <div>
                            <label class="block mb-1 text-xs text-gray-500 font-bold">البريد الإلكتروني *</label>
                            <input type="email" name="email" required x-model="editStudent.email"
                                   class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-sky-500 transition">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-1 text-xs text-gray-500 font-bold">رقم الهاتف</label>
                                <input type="text" name="phone" x-model="editStudent.phone"
                                       class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-sky-500 transition">
                            </div>
                            <div>
                                <label class="block mb-1 text-xs text-gray-500 font-bold">كلمة المرور الجديدة</label>
                                <input type="password" name="password" placeholder="اتركها فارغة لعدم التغيير"
                                       class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-sm text-[var(--text-color)] dark:text-white focus:outline-none focus:border-sky-500 transition">
                            </div>
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
