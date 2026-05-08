@extends('layouts.dashboard')

@section('title', 'تعديل الصف')
@section('page-title', 'تعديل الصف')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.grades.index') }}" class="text-sky-400 hover:underline text-sm mb-2 inline-block">← العودة لقائمة الصفوف</a>
        <h1 class="text-3xl font-bold text-white">تعديل الصف الدراسي</h1>
    </div>

    <div class="card-glass p-8 rounded-3xl">
        <form action="{{ route('admin.grades.update', $grade->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div>
                    <label class="block mb-2 text-sm text-gray-400">المرحلة التعليمية</label>
                    <select name="stage_id" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-sky-500 transition">
                        @foreach($stages as $stage)
                            <option value="{{ $stage->id }}" {{ $grade->stage_id == $stage->id ? 'selected' : '' }}>{{ $stage->name }}</option>
                        @endforeach
                    </select>
                    @error('stage_id') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm text-gray-400">اسم الصف</label>
                    <input type="text" name="name" value="{{ old('name', $grade->name) }}" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:border-sky-500 transition text-white">
                    @error('name') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 rounded-xl bg-sky-500 hover:bg-sky-600 transition text-white font-bold text-lg shadow-lg shadow-sky-500/20">
                        تحديث الصف
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
