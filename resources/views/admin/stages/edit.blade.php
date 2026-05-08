@extends('layouts.dashboard')

@section('title', 'تعديل المرحلة')
@section('page-title', 'تعديل ' . $stage->name)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.stages.index') }}" class="text-sky-400 hover:underline text-sm mb-2 inline-block">← العودة لقائمة المراحل</a>
        <h1 class="text-3xl font-bold text-white">تعديل المرحلة</h1>
    </div>

    <div class="card-glass p-8 rounded-3xl">
        <form action="{{ route('admin.stages.update', $stage->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div>
                    <label class="block mb-2 text-sm text-gray-400">اسم المرحلة</label>
                    <input type="text" name="name" value="{{ old('name', $stage->name) }}" required
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:border-sky-500 transition text-white">
                    @error('name') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm text-gray-400">وصف قصير</label>
                    <textarea name="description" rows="4"
                              class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:border-sky-500 transition text-white">{{ old('description', $stage->description) }}</textarea>
                    @error('description') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                @if($stage->image)
                    <div class="mb-2">
                        <p class="text-sm text-gray-400 mb-2">الصورة الحالية:</p>
                        <img src="{{ $stage->image }}" class="h-20 w-auto rounded-lg border border-white/10">
                    </div>
                @endif

                <div>
                    <label class="block mb-2 text-sm text-gray-400">تغيير الصورة</label>
                    <input type="file" name="image"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:border-sky-500 transition text-gray-400">
                    @error('image') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 rounded-xl bg-sky-500 hover:bg-sky-600 transition text-white font-bold text-lg shadow-lg shadow-sky-500/20">
                        تحديث المرحلة
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
