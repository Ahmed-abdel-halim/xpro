@extends('layouts.app')

@section('title', 'إنشاء حساب جديد')

@section('content')
<div class="flex justify-center items-center min-h-[80vh] py-10">
    <div class="bg-white dark:bg-white/5 p-10 rounded-[2.5rem] w-full max-w-lg shadow-2xl shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-white/10 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-amber-500/10 dark:bg-sky-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none animate-blob"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-emerald-500/10 dark:bg-purple-500/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2 pointer-events-none animate-blob animation-delay-2000"></div>
        
        <h2 class="text-3xl font-black mb-8 text-center text-[var(--text-color)] dark:text-transparent dark:bg-clip-text dark:bg-gradient-to-l dark:from-sky-400 dark:to-emerald-400 relative z-10">إنشاء حساب جديد</h2>
        
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" x-data="{ role: '{{ old('role', 'student') }}' }">
            @csrf
            
            <div class="space-y-6 relative z-10">
                <!-- اختيار نوع الحساب -->
                <div class="flex p-1 bg-gray-50 dark:bg-white/5 rounded-2xl border border-gray-200 dark:border-white/10">
                    <label class="flex-1 cursor-pointer group relative">
                        <input type="radio" name="role" value="student" x-model="role" class="hidden peer">
                        <div :class="role === 'student' ? 'bg-emerald-500 text-white dark:bg-sky-500 shadow-md' : 'text-gray-500 dark:text-gray-400'"
                             class="py-3 text-center rounded-xl font-bold transition">
                            <i class="fa-solid fa-user-graduate ml-2"></i> طالب
                        </div>
                    </label>
                    <label class="flex-1 cursor-pointer group relative">
                        <input type="radio" name="role" value="teacher" x-model="role" class="hidden peer">
                        <div :class="role === 'teacher' ? 'bg-amber-500 text-white dark:bg-purple-500 shadow-md' : 'text-gray-500 dark:text-gray-400'"
                             class="py-3 text-center rounded-xl font-bold transition">
                            <i class="fa-solid fa-chalkboard-user ml-2"></i> أستاذ
                        </div>
                    </label>
                </div>
                @error('role') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block text-center font-bold">{{ $message }}</span> @enderror

                <!-- تحديد اختصاص الأستاذ (يظهر فقط عند اختيار أستاذ) -->
                <div x-show="role === 'teacher'" x-transition class="p-4 bg-amber-500/5 dark:bg-purple-500/10 rounded-2xl border border-amber-500/20 dark:border-purple-500/20">
                    <label class="block mb-2 text-sm font-bold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                        <i class="fa-solid fa-book-open text-amber-500 dark:text-purple-400"></i>
                        <span>تحديد الاختصاص (المادة التي تدرسها) <span class="text-red-500">*</span></span>
                    </label>
                    <select name="specialization"
                            class="w-full bg-white dark:bg-[#141c2f] border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-purple-500 focus:ring-2 focus:ring-amber-500/20 transition shadow-sm font-bold">
                        <option value="">-- اختر مادة الاختصاص المحددة من الإدارة --</option>
                        @php
                            $specs = isset($specializations) && $specializations->count() 
                                ? $specializations 
                                : \App\Models\Specialization::orderBy('name')->get();
                        @endphp
                        @foreach($specs as $spec)
                            <option value="{{ $spec->name }}" {{ old('specialization') == $spec->name ? 'selected' : '' }}>
                                {{ $spec->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('specialization') <span class="text-red-500 dark:text-red-400 text-xs mt-1.5 block font-bold">{{ $message }}</span> @enderror
                    <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-2">
                        سيتم ربط حسابك بالمادة تلقائياً وإتاحة رفع المحاضرات ومشاركتها مع الطلاب فور إتمام التسجيل.
                    </p>
                </div>

                <!-- الصورة الشخصية -->
                <div x-data="{ photoName: null, photoPreview: null }" class="flex flex-col items-center justify-center p-4 bg-gray-50 dark:bg-white/5 rounded-2xl border border-dashed border-gray-300 dark:border-white/20 hover:border-amber-500/50 dark:hover:border-sky-500/50 transition relative overflow-hidden group">
                    <div class="text-center">
                        <input type="file" name="avatar" class="hidden" x-ref="photo"
                            @change="
                                if ($refs.photo.files.length > 0) {
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => { photoPreview = e.target.result; };
                                    reader.readAsDataURL($refs.photo.files[0]);
                                }
                            ">
                        
                        <!-- Placeholder -->
                        <div x-show="!photoPreview" @click="$refs.photo.click()" class="cursor-pointer">
                            <div class="w-16 h-16 bg-white dark:bg-white/10 rounded-full flex items-center justify-center text-gray-400 dark:text-gray-400 mx-auto mb-2 border border-gray-200 dark:border-transparent group-hover:bg-amber-50 dark:group-hover:bg-white/20 group-hover:text-amber-500 dark:group-hover:text-white transition shadow-sm">
                                <i class="fa-solid fa-camera text-2xl"></i>
                            </div>
                            <span class="text-xs font-bold text-gray-500 dark:text-gray-400">اختر صورة شخصية</span>
                        </div>

                        <!-- Preview -->
                        <div x-show="photoPreview" class="mt-2 relative" x-cloak>
                            <img :src="photoPreview" class="w-20 h-20 rounded-full object-cover border-2 border-amber-500 dark:border-sky-500 mx-auto shadow-md">
                            <button @click.prevent="photoPreview = null; $refs.photo.value = ''" 
                                    class="absolute -top-1 -right-1 w-6 h-6 bg-red-500 rounded-full text-white text-[10px] flex items-center justify-center shadow-lg hover:bg-red-600 transition">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </div>
                    @error('avatar') <span class="text-red-500 dark:text-red-400 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                </div>

                <!-- الاسم -->
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700 dark:text-gray-400">الاسم الكامل</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                           class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 focus:ring-2 focus:ring-amber-500/20 dark:focus:ring-sky-500/20 transition shadow-sm dark:shadow-inner">
                    @error('name') <span class="text-red-500 dark:text-red-400 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                </div>

                <!-- البريد الإلكتروني -->
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700 dark:text-gray-400">البريد الإلكتروني</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 focus:ring-2 focus:ring-amber-500/20 dark:focus:ring-sky-500/20 transition shadow-sm dark:shadow-inner">
                    @error('email') <span class="text-red-500 dark:text-red-400 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                </div>

                <!-- رقم الهاتف -->
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700 dark:text-gray-400">رقم الهاتف</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required
                           class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 focus:ring-2 focus:ring-amber-500/20 dark:focus:ring-sky-500/20 transition shadow-sm dark:shadow-inner"
                           placeholder="077xxxxxxxx أو 00962xxxxxxxx">
                    @error('phone') <span class="text-red-500 dark:text-red-400 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- كلمة المرور -->
                    <div>
                        <label class="block mb-2 text-sm font-bold text-gray-700 dark:text-gray-400">كلمة المرور</label>
                        <input type="password" name="password" required
                               class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 focus:ring-2 focus:ring-amber-500/20 dark:focus:ring-sky-500/20 transition shadow-sm dark:shadow-inner">
                        @error('password') <span class="text-red-500 dark:text-red-400 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <!-- تأكيد كلمة المرور -->
                    <div>
                        <label class="block mb-2 text-sm font-bold text-gray-700 dark:text-gray-400">تأكيد كلمة المرور</label>
                        <input type="password" name="password_confirmation" required
                               class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-xl px-4 py-3 text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500 focus:ring-2 focus:ring-amber-500/20 dark:focus:ring-sky-500/20 transition shadow-sm dark:shadow-inner">
                    </div>
                </div>

                <button type="submit" class="w-full py-4 rounded-xl bg-amber-500 hover:bg-amber-600 dark:bg-sky-500 dark:hover:bg-sky-600 transition text-white font-bold text-lg shadow-lg shadow-amber-500/30 dark:shadow-sky-500/20 hover:-translate-y-1">
                    إنشاء الحساب
                </button>

                <p class="text-center text-gray-600 dark:text-gray-400 font-medium mt-6 pt-6 border-t border-gray-100 dark:border-white/10">
                    لديك حساب بالفعل؟ <a href="{{ route('login') }}" class="text-amber-500 hover:text-amber-600 dark:text-sky-400 dark:hover:text-sky-300 font-bold transition mr-1">تسجيل الدخول</a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection
