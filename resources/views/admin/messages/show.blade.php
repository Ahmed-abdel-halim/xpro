@extends('layouts.dashboard')

@section('title', 'عرض الرسالة')
@section('page-title', 'تفاصيل رسالة التواصل')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('admin.messages.index') }}" class="flex items-center text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition font-bold">
            <i class="fa-solid fa-arrow-right ml-2 text-xs"></i> عودة لصندوق الوارد
        </a>
        <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" data-confirm="هل أنت متأكد من حذف هذه الرسالة؟">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-xs text-red-500 hover:underline flex items-center">
                <i class="fa-solid fa-trash-can ml-1"></i> حذف الرسالة
            </button>
        </form>
    </div>

    <div class="card-glass bg-white dark:bg-white/5 rounded-3xl overflow-hidden p-8 border border-gray-100 dark:border-white/5 shadow-xl">
        <div class="flex flex-col md:flex-row items-start justify-between mb-8 border-b border-gray-100 dark:border-white/5 pb-8 gap-4">
            <div class="flex items-center">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-sky-500 to-indigo-600 flex items-center justify-center text-white font-bold text-2xl uppercase ml-6 shadow-xl shadow-sky-500/10 shrink-0">
                    {{ substr($message->name, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-[var(--text-color)] dark:text-white mb-1">{{ $message->name }}</h2>
                    <div class="flex flex-col sm:flex-row sm:items-center text-gray-500 dark:text-gray-400 text-sm gap-2 sm:gap-4 font-medium">
                        <span class="flex items-center"><i class="fa-solid fa-envelope ml-2 text-amber-500 dark:text-sky-400"></i> {{ $message->email }}</span>
                        @if($message->phone)
                            <span class="flex items-center"><i class="fa-solid fa-phone ml-2 text-amber-500 dark:text-sky-400"></i> {{ $message->phone }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="text-right md:text-left self-start">
                <div class="text-gray-500 text-xs mb-1 font-bold">تاريخ الإرسال</div>
                <div class="text-[var(--text-color)] dark:text-white text-sm font-bold bg-gray-50 dark:bg-white/5 px-3 py-1.5 rounded-lg">{{ $message->created_at->format('Y/m/d - h:i A') }}</div>
            </div>
        </div>

        <div class="mb-8">
            <div class="text-gray-500 text-xs tracking-widest mb-2 font-bold">الموضوع</div>
            <h3 class="text-xl font-bold text-amber-600 dark:text-sky-400">{{ $message->subject }}</h3>
        </div>

        <div class="bg-gray-50 dark:bg-white/5 p-6 rounded-2xl border border-gray-100 dark:border-white/5 whitespace-pre-line text-gray-600 dark:text-gray-300 leading-relaxed text-base font-medium shadow-inner">
            {{ $message->message }}
        </div>

        <div class="mt-8 pt-8 border-t border-gray-100 dark:border-white/5 flex justify-end">
            <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}" class="px-8 py-3 bg-amber-500 hover:bg-amber-600 dark:bg-sky-500 dark:hover:bg-sky-600 transition rounded-xl text-white font-bold shadow-lg shadow-amber-500/20 dark:shadow-sky-500/20 flex items-center">
                <i class="fa-solid fa-reply ml-3"></i> الرد عبر البريد الإلكتروني
            </a>
        </div>
    </div>
</div>
@endsection
