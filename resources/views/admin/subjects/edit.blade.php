@extends('layouts.dashboard')

@section('title', 'تعديل المادة')
@section('page-title', 'تعديل مادة')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.subjects.index') }}" class="text-sky-400 hover:underline text-sm mb-2 inline-block">← العودة لقائمة المواد</a>
        <h1 class="text-3xl font-bold text-white">تعديل المادة الدراسية</h1>
    </div>

    <div class="card-glass p-8 rounded-3xl">
        <form action="{{ route('admin.subjects.update', $subject->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div>
                    <label class="block mb-2 text-sm text-gray-400">الصف الدراسي</label>
                    <select name="grade_id" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-sky-500 transition">
                        @foreach($stages as $stage)
                            <optgroup label="{{ $stage->name }}">
                                @foreach($stage->grades as $grade)
                                    <option value="{{ $grade->id }}" {{ $subject->grade_id == $grade->id ? 'selected' : '' }}>{{ $grade->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    @error('grade_id') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm text-gray-400">اسم المادة</label>
                    <input type="text" name="name" value="{{ old('name', $subject->name) }}" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:border-sky-500 transition text-white">
                    @error('name') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 rounded-xl bg-sky-500 hover:bg-sky-600 transition text-white font-bold text-lg shadow-lg shadow-sky-500/20">
                        تحديث المادة
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
