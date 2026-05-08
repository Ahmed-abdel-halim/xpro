@extends('layouts.dashboard')

@section('title', 'إضافة مرحلة جديدة')
@section('page-title', 'إضافة مرحلة ثعلب')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.stages.index') }}" class="text-sky-400 hover:underline text-sm mb-2 inline-block">← العودة لقائمة المراحل</a>
        <h1 class="text-3xl font-bold text-white">إضافة مرحلة تعليمية جديدة</h1>
    </div>

    <div class="card-glass p-8 rounded-3xl">
        <form action="{{ route('admin.stages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label class="block mb-2 text-sm text-gray-400">اسم المرحلة</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:border-sky-500 transition text-white">
                    @error('name') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm text-gray-400">وصف قصير</label>
                    <textarea name="description" rows="4"
                              class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:border-sky-500 transition text-white">{{ old('description') }}</textarea>
                    @error('description') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm text-gray-400">أيقونة / صورة المرحلة</label>
                    <input type="file" name="image"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:border-sky-500 transition text-gray-400">
                    @error('image') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                    <p class="text-xs text-gray-500 mt-2">يفضل استخدام صور شفافة PNG أو بصيغة SVG.</p>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 rounded-xl bg-sky-500 hover:bg-sky-600 transition text-white font-bold text-lg shadow-lg shadow-sky-500/20">
                        حفظ المرحلة
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
