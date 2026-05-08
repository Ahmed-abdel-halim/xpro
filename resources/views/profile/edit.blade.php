@extends('layouts.dashboard')

@section('title', 'تعديل الملف الشخصي')
@section('page-title', 'إعدادات الحساب')

@section('content')
<div class="mb-10">
    <h1 class="text-3xl font-bold text-[var(--text-color)] dark:text-white mb-2">الملف الشخصي</h1>
    <p class="text-gray-500 font-medium">إدارة معلومات حسابك، تغيير كلمة المرور، وإعدادات الأمان.</p>
</div>

<div class="space-y-8 max-w-3xl">
    <!-- Profile Info -->
    <div class="card-glass p-8 rounded-3xl border border-gray-100 dark:border-white/5 shadow-xl shadow-gray-200/40 dark:shadow-none">
        <div class="max-w-xl">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <!-- Update Password -->
    <div class="card-glass p-8 rounded-3xl border border-gray-100 dark:border-white/5 shadow-xl shadow-gray-200/40 dark:shadow-none">
        <div class="max-w-xl">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <!-- Delete Account -->
    <div class="card-glass p-8 rounded-3xl border border-red-400 dark:border-red-500/20 shadow-xl shadow-red-200/40 dark:shadow-none">
        <div class="max-w-xl">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>

<style>
    /* Styling for Breeze forms into our theme */
    .card-glass input, .card-glass select, .card-glass textarea {
        background: #f9fafb !important;
        border: 1px solid #e5e7eb !important;
        color: var(--text-color) !important;
        border-radius: 0.75rem !important;
        padding: 0.75rem 1rem !important;
    }
    html.dark .card-glass input, html.dark .card-glass select, html.dark .card-glass textarea {
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: white !important;
    }
    .card-glass input:focus {
        border-color: #f59e0b !important;
        outline: none !important;
        box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.2) !important;
    }
    html.dark .card-glass input:focus {
        border-color: #38bdf8 !important;
        box-shadow: 0 0 0 2px rgba(56, 189, 248, 0.2) !important;
    }
    .card-glass label {
        color: #6b7280 !important;
        font-size: 0.875rem !important;
        margin-bottom: 0.5rem !important;
        display: block !important;
        font-weight: bold !important;
    }
    html.dark .card-glass label {
        color: #94a3b8 !important;
    }
    .card-glass h2 {
        color: var(--text-color) !important;
        font-size: 1.25rem !important;
        font-weight: 700 !important;
        margin-bottom: 0.5rem !important;
    }
    html.dark .card-glass h2 {
        color: white !important;
    }
    .card-glass p {
        color: #6b7280 !important;
        font-size: 0.875rem !important;
        margin-bottom: 1.5rem !important;
    }
    html.dark .card-glass p {
        color: #64748b !important;
    }
    .card-glass button[type="submit"] {
        background-color: #f59e0b !important;
        color: white !important;
        padding: 0.625rem 1.5rem !important;
        border-radius: 0.75rem !important;
        font-weight: 600 !important;
        transition: all 0.2s !important;
    }
    html.dark .card-glass button[type="submit"] {
        background-color: #0ea5e9 !important;
    }
    .card-glass button[type="submit"]:hover {
        background-color: #d97706 !important;
    }
    html.dark .card-glass button[type="submit"]:hover {
        background-color: #0284c7 !important;
    }
</style>
@endsection
