@extends('layouts.dashboard')

@section('title', 'رسائل التواصل')
@section('page-title', 'إدارة رسائل التواصل')

@section('content')
<div class="card-glass rounded-2xl overflow-hidden">
    <div class="p-6 border-b border-gray-100 dark:border-white/5 flex justify-between items-center">
        <h3 class="font-bold text-[var(--text-color)] dark:text-white">صندوق الوارد</h3>
        <span class="text-xs text-gray-500 font-bold bg-gray-100 dark:bg-white/5 px-3 py-1 rounded-full">إجمالي الرسائل: <span class="text-[var(--text-color)] dark:text-white">{{ $messages->total() }}</span></span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-right text-sm">
            <thead>
                <tr class="bg-gray-50 dark:bg-white/5 text-gray-500">
                    <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent">المرسل</th>
                    <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent">الموضوع</th>
                    <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent">التاريخ</th>
                    <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent">الحالة</th>
                    <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                @forelse($messages as $message)
                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition {{ $message->is_read ? 'opacity-70 dark:opacity-60' : 'font-bold' }}">
                    <td class="p-4">
                        <div class="text-[var(--text-color)] dark:text-white">{{ $message->name }}</div>
                        <div class="text-xs text-gray-400 font-medium mt-1">{{ $message->email }}</div>
                    </td>
                    <td class="p-4 text-gray-600 dark:text-gray-300">{{ Str::limit($message->subject, 40) }}</td>
                    <td class="p-4 text-gray-500 dark:text-gray-400 text-xs font-bold">{{ $message->created_at->diffForHumans() }}</td>
                    <td class="p-4">
                        @if($message->is_read)
                            <span class="bg-gray-100 dark:bg-gray-500/10 text-gray-500 px-2 py-1 rounded-lg text-[10px] font-bold">مقروءة</span>
                        @else
                            <span class="bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 px-2 py-1 rounded-lg text-[10px] font-bold">جديدة</span>
                        @endif
                    </td>
                    <td class="p-4">
                        <div class="flex items-center space-x-2 space-x-reverse">
                            <a href="{{ route('admin.messages.show', $message) }}" class="w-8 h-8 rounded-lg bg-sky-500/10 text-sky-400 flex items-center justify-center hover:bg-sky-500 hover:text-white transition">
                                <i class="fa-solid fa-eye text-xs"></i>
                            </a>
                            <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" data-confirm="هل أنت متأكد من حذف هذه الرسالة؟">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg bg-red-500/10 text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-10 text-center text-gray-500">لا توجد رسائل تواصل حالياً.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    </div>
    @if($messages->hasPages())
    <div class="p-4 border-t border-gray-100 dark:border-white/5 mt-auto">
        {{ $messages->links() }}
    </div>
    @endif
</div>
@endsection
