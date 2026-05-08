@extends('layouts.dashboard')

@section('title', 'إدارة الأسئلة الشائعة')
@section('page-title', 'الأسئلة الشائعة')

@section('content')
<div x-data="{ 
    showAddModal: false, 
    showEditModal: false,
    editFaq: { id: '', question: '', answer: '', sort_order: 0, is_active: true },
    openEditModal(faq) {
        this.editFaq = { ...faq };
        this.showEditModal = true;
    }
}">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-[var(--text-color)] dark:text-white mb-2">الأسئلة الشائعة</h1>
            <p class="text-gray-500">من هنا يمكنك إضافة وتعديل الأسئلة التي تظهر للمستخدمين.</p>
        </div>
        <button @click="showAddModal = true" class="px-6 py-2 bg-sky-500 hover:bg-sky-600 transition rounded-xl text-white font-bold text-sm shadow-lg shadow-sky-500/20">
            + إضافة سؤال جديد
        </button>
    </div>

    <div class="card-glass rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-white/5 text-gray-500">
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent">السؤال</th>
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent">الإجابة</th>
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent text-center">الترتيب</th>
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent text-center">الحالة</th>
                        <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent text-center">العمليات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @foreach($faqs as $faq)
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                        <td class="p-4 font-bold text-[var(--text-color)] dark:text-white">{{ $faq->question }}</td>
                        <td class="p-4 text-gray-500 dark:text-gray-400 font-medium max-w-xs truncate">{{ $faq->answer }}</td>
                        <td class="p-4 text-center">{{ $faq->sort_order }}</td>
                        <td class="p-4 text-center">
                            @if($faq->is_active)
                                <span class="bg-green-500/10 text-green-500 px-2 py-1 rounded-lg text-xs">نشط</span>
                            @else
                                <span class="bg-red-500/10 text-red-500 px-2 py-1 rounded-lg text-xs">معطل</span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center space-x-2 space-x-reverse">
                                <button @click="openEditModal({ id: '{{ $faq->id }}', question: '{{ $faq->question }}', answer: '{{ addslashes($faq->answer) }}', sort_order: {{ $faq->sort_order }}, is_active: {{ $faq->is_active ? 'true' : 'false' }} })" 
                                        class="p-2 hover:bg-sky-500/10 rounded-lg text-sky-400 transition" title="تعديل">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" data-confirm="هل أنت متأكد من حذف هذا السؤال؟">
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

    <!-- Add FAQ Modal -->
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
                        <h3 class="text-xl font-bold text-[var(--text-color)] dark:text-white">إضافة سؤال جديد</h3>
                        <button @click="showAddModal = false" class="text-gray-400 hover:text-gray-900 dark:text-gray-500 dark:hover:text-white transition">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <form action="{{ route('admin.faqs.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block mb-1 text-xs text-gray-500 dark:text-gray-400 font-bold">السؤال</label>
                                <input type="text" name="question" required class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition text-[var(--text-color)] dark:text-white" placeholder="مثال: كيف يمكنني الاشتراك؟">
                            </div>

                            <div>
                                <label class="block mb-1 text-xs text-gray-500 dark:text-gray-400 font-bold">الإجابة</label>
                                <textarea name="answer" rows="3" required class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition text-[var(--text-color)] dark:text-white"></textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-1 text-xs text-gray-500 dark:text-gray-400 font-bold">الترتيب</label>
                                    <input type="number" name="sort_order" value="0" class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2 focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition text-[var(--text-color)] dark:text-white text-sm">
                                </div>
                                <div class="flex items-center pt-5">
                                    <label class="flex items-center cursor-pointer">
                                        <div class="relative">
                                            <input type="checkbox" name="is_active" value="1" checked class="sr-only">
                                            <div class="block bg-gray-200 dark:bg-white/10 w-12 h-7 rounded-full transition-colors duration-200"></div>
                                            <div class="dot absolute left-1 top-1 bg-white w-5 h-5 rounded-full transition-transform duration-200"></div>
                                        </div>
                                        <div class="mr-3 text-gray-500 dark:text-gray-400 font-bold text-xs uppercase">نشط</div>
                                    </label>
                                </div>
                            </div>

                            <div class="pt-2 flex space-x-3 space-x-reverse">
                                <button type="submit" class="flex-1 py-3 rounded-xl bg-amber-500 hover:bg-amber-600 dark:bg-sky-500 dark:hover:bg-sky-600 transition text-white font-bold text-base shadow-lg shadow-amber-500/20 dark:shadow-sky-500/20">حفظ السؤال</button>
                                <button type="button" @click="showAddModal = false" class="flex-1 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-white/5 dark:hover:bg-white/10 transition text-gray-700 dark:text-white font-bold text-base">إلغاء</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>

    <!-- Edit FAQ Modal -->
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
                        <h3 class="text-xl font-bold text-[var(--text-color)] dark:text-white">تعديل السؤال</h3>
                        <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-900 dark:text-gray-500 dark:hover:text-white transition">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <form :action="'{{ url('admin/faqs') }}/' + editFaq.id" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label class="block mb-1 text-xs text-gray-500 dark:text-gray-400 font-bold">السؤال</label>
                                <input type="text" name="question" x-model="editFaq.question" required class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition text-[var(--text-color)] dark:text-white">
                            </div>

                            <div>
                                <label class="block mb-1 text-xs text-gray-500 dark:text-gray-400 font-bold">الإجابة</label>
                                <textarea name="answer" x-model="editFaq.answer" rows="3" required class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2.5 focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition text-[var(--text-color)] dark:text-white"></textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-1 text-xs text-gray-500 dark:text-gray-400 font-bold">الترتيب</label>
                                    <input type="number" name="sort_order" x-model="editFaq.sort_order" class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-2 focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition text-[var(--text-color)] dark:text-white text-sm">
                                </div>
                                <div class="flex items-center pt-5">
                                    <label class="flex items-center cursor-pointer">
                                        <div class="relative">
                                            <input type="checkbox" name="is_active" value="1" x-model="editFaq.is_active" class="sr-only">
                                            <div class="block bg-gray-200 dark:bg-white/10 w-12 h-7 rounded-full transition-colors duration-200"></div>
                                            <div class="dot absolute left-1 top-1 bg-white w-5 h-5 rounded-full transition-transform duration-200" :class="editFaq.is_active ? 'translate-x-5' : ''"></div>
                                        </div>
                                        <div class="mr-3 text-gray-500 dark:text-gray-400 font-bold text-xs uppercase">نشط</div>
                                    </label>
                                </div>
                            </div>

                            <div class="pt-2 flex space-x-3 space-x-reverse">
                                <button type="submit" class="flex-1 py-3 rounded-xl bg-amber-500 hover:bg-amber-600 dark:bg-sky-500 dark:hover:bg-sky-600 transition text-white font-bold text-base shadow-lg shadow-amber-500/20 dark:shadow-sky-500/20">تحديث السؤال</button>
                                <button type="button" @click="showEditModal = false" class="flex-1 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-white/5 dark:hover:bg-white/10 transition text-gray-700 dark:text-white font-bold text-base">إلغاء</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>
</div>

<style>
    input[type="checkbox"]:checked ~ .block {
        background-color: #10b981;
    }
</style>
@endsection
