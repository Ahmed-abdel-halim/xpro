<section>
    <header>
        <h2 class="text-lg font-medium text-[var(--text-color)] dark:text-white">
            بيانات الحساب
        </h2>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            قم بتحديث معلومات ملفك الشخصي وصورتك الشخصية.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- الصورة الشخصية -->
        <div class="flex flex-col items-center sm:items-start gap-4 mb-6">
            <x-input-label value="الصورة الشخصية" />
            <div x-data="{ photoPreview: null }" class="flex items-center gap-6">
                <div class="relative group">
                    <div class="w-24 h-24 rounded-2xl overflow-hidden border-2 border-gray-200 dark:border-white/10 group-hover:border-amber-500/50 dark:group-hover:border-sky-500/50 transition shadow-xl bg-gray-50 dark:bg-white/5">
                        <template x-if="!photoPreview">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 dark:text-gray-500">
                                    <i class="fa-solid fa-user text-3xl"></i>
                                </div>
                            @endif
                        </template>
                        <template x-if="photoPreview">
                            <img :src="photoPreview" class="w-full h-full object-cover">
                        </template>
                    </div>
                    <button type="button" @click="$refs.avatarInput.click()" 
                            class="absolute -bottom-2 -right-2 w-8 h-8 bg-amber-500 dark:bg-sky-500 rounded-lg text-white shadow-lg flex items-center justify-center hover:bg-amber-600 dark:hover:bg-sky-600 transition">
                        <i class="fa-solid fa-camera text-xs"></i>
                    </button>
                </div>
                
                <input type="file" name="avatar" class="hidden" x-ref="avatarInput" 
                       @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result; }; reader.readAsDataURL(file); }">
                
                <div class="text-xs text-gray-500">
                    <p>صيغ الملفات المدعومة: JPG, PNG, GIF</p>
                    <p>الحد الأقصى للحجم: 2MB</p>
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div>
            <x-input-label for="name" value="الاسم الكامل" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="البريد الإلكتروني" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="phone" value="رقم الهاتف" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" required />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>حفظ التغييرات</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-bold text-emerald-600 dark:text-emerald-400"
                >تم الحفظ.</p>
            @endif
        </div>
    </form>
</section>
