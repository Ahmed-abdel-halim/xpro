@extends('layouts.dashboard')

@section('title', 'إدارة المعلمين')
@section('page-title', 'قائمة المعلمين')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-[var(--text-color)] dark:text-white mb-2">المعلمون</h1>
    <p class="text-gray-500">إدارة المعلمين، مراجعة طلبات الانضمام، والتحكم في صلاحياتهم.</p>
</div>



<div class="card-glass rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-right text-sm">
            <thead>
                <tr class="bg-gray-50 dark:bg-white/5 text-gray-500">
                    <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent">المعلم</th>
                    <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent">رقم الهاتف</th>
                    <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent">البريد الإلكتروني</th>
                    <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent text-center">نسبة العمولة</th>
                    <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent text-center">الحالة</th>
                    <th class="p-4 font-bold border-b border-gray-100 dark:border-transparent text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                @foreach($teachers as $teacher)
                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition" x-data="{ editing: false, commission: {{ (float)$teacher->commission_percentage }} }">
                    <td class="p-4">
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-sky-500 to-indigo-600 flex items-center justify-center text-white font-bold">
                                {{ substr($teacher->name, 0, 1) }}
                            </div>
                            <span class="font-bold text-[var(--text-color)] dark:text-white">{{ $teacher->name }}</span>
                        </div>
                    </td>
                    
                    <td class="p-4 text-gray-500 dark:text-gray-400 font-medium">
                        {{ $teacher->phone ?? '---' }}
                    </td>
                    <td class="p-4 text-gray-500 dark:text-gray-400 font-medium">
                        {{ $teacher->email }}
                    </td>
                    
                    <td class="p-4 text-center">
                        <div class="flex items-center justify-center space-x-1 space-x-reverse">
                            <input type="number" x-model="commission" 
                                   class="w-16 bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-lg px-2 py-1 text-center text-[var(--text-color)] dark:text-white focus:outline-none focus:border-amber-500 dark:focus:border-sky-500"
                                   @input="editing = true">
                            <span class="text-gray-500 font-bold">%</span>
                        </div>
                        @error('commission_percentage') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </td>

                    <td class="p-4 text-center">
                        @if($teacher->is_approved)
                            <span class="bg-green-500/10 text-green-500 px-3 py-1 rounded-full text-[10px]">معتمد</span>
                        @else
                            <span class="bg-yellow-500/10 text-yellow-500 px-3 py-1 rounded-full text-[10px]">قيد المراجعة</span>
                        @endif
                    </td>

                    <td class="p-4 text-center">
                        <div class="flex items-center justify-center space-x-2 space-x-reverse">
                            <form action="{{ route('admin.users.updateSettings', $teacher->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="commission_percentage" x-bind:value="commission">
                                
                                <button type="submit" x-show="editing" class="p-2 bg-sky-500 hover:bg-sky-600 text-white rounded-lg transition shadow-lg shadow-sky-500/20" title="حفظ التغييرات">
                                    <i class="fa-solid fa-floppy-disk"></i>
                                </button>
                            </form>
                            
                            <template x-if="!editing">
                                <div class="flex items-center space-x-2 space-x-reverse">
                                    @if(!$teacher->is_approved)
                                        <button type="button" onclick="document.getElementById('approve-form-{{ $teacher->id }}').submit()" class="px-3 py-1 bg-emerald-500/20 text-emerald-400 hover:bg-emerald-500 hover:text-white rounded-lg text-[10px] transition border border-emerald-500/30">
                                            اعتماد
                                        </button>
                                    @endif
                                    <button type="button" onclick="if(confirm('هل أنت متأكد من حذف هذا المعلم؟')) document.getElementById('delete-form-{{ $teacher->id }}').submit()" class="p-2 hover:bg-red-500/10 rounded-lg text-red-500 transition" title="حذف">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </td>

                    <!-- Separate hidden forms for simple actions -->
                    <form id="approve-form-{{ $teacher->id }}" action="{{ route('admin.users.approve', $teacher->id) }}" method="POST" class="hidden">@csrf</form>
                    <form id="delete-form-{{ $teacher->id }}" action="{{ route('admin.users.destroy', $teacher->id) }}" method="POST" class="hidden">@csrf @method('DELETE')</form>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
