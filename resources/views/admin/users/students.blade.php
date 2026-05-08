@extends('layouts.dashboard')

@section('title', 'إدارة الطلاب')
@section('page-title', 'قائمة الطلاب')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-[var(--text-color)] dark:text-white mb-2">الطلاب</h1>
    <p class="text-gray-500">متابعة الطلاب المسجلين، إدارة حساباتهم والاطلاع على نشاطهم.</p>
</div>



<div class="card-glass rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-right text-sm">
            <thead>
                <tr class="bg-gray-50 dark:bg-white/5 text-gray-500">
                    <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent">الطالب</th>
                    <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent">البريد الإلكتروني</th>
                    <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent">تاريخ التسجيل</th>
                    <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent text-center">الكورسات المشترك بها</th>
                    <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent text-center">العمليات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                @foreach($students as $student)
                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                    <td class="p-4">
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <div class="w-10 h-10 rounded-full bg-slate-700 flex items-center justify-center text-white font-bold text-xs">
                                {{ substr($student->name, 0, 1) }}
                            </div>
                            <span class="font-bold text-[var(--text-color)] dark:text-white">{{ $student->name }}</span>
                        </div>
                    </td>
                    <td class="p-4 text-gray-500 dark:text-gray-400 font-medium">{{ $student->email }}</td>
                    <td class="p-4 text-gray-500 dark:text-gray-400 font-medium">{{ $student->created_at->format('Y/m/d') }}</td>
                    <td class="p-4 text-center">
                        <span class="bg-sky-50 text-sky-600 border border-sky-100 dark:bg-blue-500/10 dark:text-blue-400 dark:border-transparent px-2 py-1 rounded-lg text-xs font-bold">{{ $student->enrollments_count ?? 0 }} كورسات</span>
                    </td>
                    <td class="p-4 text-center">
                        <form action="{{ route('admin.users.destroy', $student->id) }}" method="POST" data-confirm="هل أنت متأكد من حذف هذا الطالب؟ سيتم إلغاء جميع اشتراكاته.">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 hover:bg-red-500/10 rounded-lg text-red-500 transition" title="حذف">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>

                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
