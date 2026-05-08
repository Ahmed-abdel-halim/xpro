@extends('layouts.dashboard')

@section('title', 'إضافة صف جديد')
@section('page-title', 'إضافة صف')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.grades.index') }}" class="text-sky-400 hover:underline text-sm mb-2 inline-block">← العودة لقائمة الصفوف</a>
        <h1 class="text-3xl font-bold text-white">إضافة صف دراسي جديد</h1>
    </div>

    <div class="card-glass p-8 rounded-3xl">
        <form action="{{ route('admin.grades.store') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label class="block mb-2 text-sm text-gray-400">المرحلة التعليمية</label>
                    <select name="stage_id" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-sky-500 transition">
                        <option value="" disabled selected>اختر المرحلة</option>
                        @foreach($stages as $stage)
                            <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                        @endforeach
                    </select>
                    @error('stage_id') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm text-gray-400">اسم الصف</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:border-sky-500 transition text-white"
                           placeholder="مثال: الصف الأول الثانوي">
                    @error('name') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 rounded-xl bg-sky-500 hover:bg-sky-600 transition text-white font-bold text-lg shadow-lg shadow-sky-500/20">
                        حفظ الصف
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
