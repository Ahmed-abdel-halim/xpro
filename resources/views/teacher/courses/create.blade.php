@extends('layouts.dashboard')

@section('title', 'إضافة كورس')
@section('page-title', 'إنشاء محتوى تعليمي جديد')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-10">
        <a href="{{ route('teacher.courses.index') }}" class="text-amber-500 hover:text-amber-600 dark:text-sky-400 dark:hover:text-sky-300 transition text-sm flex items-center mb-2 font-bold">
            <i class="fa-solid fa-arrow-right ml-2"></i>
            العودة لكورساتي
        </a>
        <h1 class="text-3xl font-bold text-[var(--text-color)] dark:text-white">إضافة كورس جديد</h1>
        <p class="text-gray-500 font-medium mt-2">قم بملء البيانات التالية لإنشاء الكورس الخاص بك.</p>
    </div>

    <form action="{{ route('teacher.courses.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Basic Info -->
            <div class="lg:col-span-2 space-y-6">
                <div class="card-glass p-8 rounded-3xl border border-gray-100 dark:border-white/5">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-gray-500 dark:text-gray-400 text-sm font-bold mb-2">عنوان الكورس</label>
                            <input type="text" name="title" value="{{ old('title') }}" required
                                   class="w-full bg-gray-50 border border-gray-200 dark:bg-white/5 dark:border-white/10 rounded-xl px-4 py-3 text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition"
                                   placeholder="مثال: شرح منهج الفيزياء للصف الأول الثانوي">
                        </div>

                        <div>
                            <label class="block text-gray-500 dark:text-gray-400 text-sm font-bold mb-2">وصف الكورس</label>
                            <textarea name="description" rows="6" required
                                      class="w-full bg-gray-50 border border-gray-200 dark:bg-white/5 dark:border-white/10 rounded-xl px-4 py-3 text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition"
                                      placeholder="اكتب وصفاً مفصلاً عما سيتعلمه الطالب في هذا الكورس...">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card-glass p-8 rounded-3xl border border-gray-100 dark:border-white/5">
                    <h3 class="text-[var(--text-color)] dark:text-white font-bold mb-6 flex items-center">
                        <i class="fa-solid fa-graduation-cap ml-2 text-amber-500 dark:text-sky-400"></i>
                        التصنيف التعليمي
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-500 dark:text-gray-400 text-sm font-bold mb-2">المادة الدراسية</label>
                            <select name="subject_id" required class="w-full bg-gray-50 border border-gray-200 dark:bg-white/5 dark:border-white/10 rounded-xl px-4 py-3 text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition [&>option]:text-black dark:[&>option]:text-black">
                                <option value="" disabled selected>اختر المادة والصف</option>
                                @foreach($stages as $stage)
                                    <optgroup label="{{ $stage->name }}">
                                        @foreach($stage->grades as $grade)
                                            @foreach($grade->subjects as $subject)
                                                <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                                    {{ $subject->name }} ({{ $grade->name }})
                                                </option>
                                            @endforeach
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-500 dark:text-gray-400 text-sm font-bold mb-2">سعر الكورس (ج.م)</label>
                            <input type="number" name="price" value="{{ old('price', '0') }}" step="0.01" required
                                   class="w-full bg-gray-50 border border-gray-200 dark:bg-white/5 dark:border-white/10 rounded-xl px-4 py-3 text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 transition">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Media / Thumbnail -->
            <div class="lg:col-span-1 space-y-6">
                <div class="card-glass p-8 rounded-3xl h-full border border-gray-100 dark:border-white/5">
                    <h3 class="text-[var(--text-color)] dark:text-white font-bold mb-6 flex items-center">
                        <i class="fa-solid fa-image ml-2 text-amber-500 dark:text-sky-400"></i>
                        غلاف الكورس
                    </h3>
                    
                    <div class="relative group cursor-pointer">
                        <div id="preview-container" class="aspect-video bg-gray-50 border-gray-200 dark:bg-white/5 rounded-2xl border-2 border-dashed dark:border-white/10 flex flex-col items-center justify-center transition group-hover:border-amber-500/50 dark:group-hover:border-sky-500/50 overflow-hidden">
                            <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 dark:text-gray-600 mb-2"></i>
                            <span class="text-xs text-gray-500 font-bold">انقر لرفع صورة</span>
                            <img id="image-preview" src="#" class="hidden absolute inset-0 w-full h-full object-cover">
                        </div>
                        <input type="file" name="thumbnail" onchange="previewImage(this)" class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                    
                    <ul class="text-[10px] text-gray-500 font-medium space-y-2 mt-6">
                        <li><i class="fa-solid fa-circle-info ml-1 text-amber-500 dark:text-sky-500"></i> الحجم الأقصى 2MB</li>
                        <li><i class="fa-solid fa-circle-info ml-1 text-amber-500 dark:text-sky-500"></i> الأبعاد المفضلة 1280x720</li>
                        <li><i class="fa-solid fa-circle-info ml-1 text-amber-500 dark:text-sky-500"></i> الصيغ المدعومة JPG, PNG, WEBP</li>
                    </ul>

                    <div class="mt-10">
                        <button type="submit" class="w-full py-4 bg-amber-500 hover:bg-amber-600 dark:bg-sky-500 dark:hover:bg-sky-600 transition rounded-xl text-white font-bold shadow-lg shadow-amber-500/20 dark:shadow-sky-500/20 group hover:-translate-y-1">
                            حفظ ونشر الكورس
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').src = e.target.result;
                document.getElementById('image-preview').classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
