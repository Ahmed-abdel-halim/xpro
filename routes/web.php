<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboard;
use App\Http\Controllers\CourseController;

Route::get('/', [EducationController::class, 'index'])->name('home');
Route::view('/about', 'pages.about')->name('about');
Route::view('/services', 'pages.services')->name('services');
Route::view('/faq', 'pages.faq')->name('faq');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/privacy-policy', 'pages.privacy-policy')->name('privacy-policy');
Route::view('/terms-and-conditions', 'pages.terms-and-conditions')->name('terms-and-conditions');
Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');


Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->isAdmin()) return redirect()->route('admin.dashboard');
    if ($user->isTeacher()) return redirect()->route('teacher.dashboard');
    
    $latestPayments = $user->payments()->with(['course', 'teacher'])->latest()->take(5)->get();
    
    return view('dashboard', compact('latestPayments'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('faqs', \App\Http\Controllers\FaqController::class);
    Route::resource('stages', \App\Http\Controllers\Admin\StageController::class);
    Route::resource('grades', \App\Http\Controllers\Admin\GradeController::class);
    Route::resource('subjects', \App\Http\Controllers\Admin\SubjectController::class);
    Route::get('subjects/{subject}/courses', [\App\Http\Controllers\Admin\SubjectController::class, 'courses'])->name('subjects.courses');
    Route::delete('courses/{course}', [\App\Http\Controllers\Admin\CourseController::class, 'destroy'])->name('courses.destroy');

    
    // User Management
    Route::get('/teachers', [\App\Http\Controllers\Admin\UserController::class, 'teachers'])->name('teachers.index');
    Route::post('/teachers', [\App\Http\Controllers\Admin\UserController::class, 'storeTeacher'])->name('teachers.store');
    Route::put('/teachers/{user}', [\App\Http\Controllers\Admin\UserController::class, 'updateTeacher'])->name('teachers.update');
    
    Route::get('/students', [\App\Http\Controllers\Admin\UserController::class, 'students'])->name('students.index');
    Route::post('/students', [\App\Http\Controllers\Admin\UserController::class, 'storeStudent'])->name('students.store');
    Route::put('/students/{user}', [\App\Http\Controllers\Admin\UserController::class, 'updateStudent'])->name('students.update');

    Route::post('/users/{user}/approve', [\App\Http\Controllers\Admin\UserController::class, 'approveTeacher'])->name('users.approve');
    Route::patch('/users/{user}/settings', [\App\Http\Controllers\Admin\UserController::class, 'updateTeacherSettings'])->name('users.updateSettings');
    Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

    // Finance Management
    Route::get('/finance', [\App\Http\Controllers\Admin\FinanceController::class, 'index'])->name('finance.index');
    Route::post('/finance/settle-teacher/{teacher}', [\App\Http\Controllers\Admin\FinanceController::class, 'settleTeacherCommission'])->name('finance.settleTeacher');

    // Withdrawals Management (DELETED - Moved to direct payments)
    // Route::get('/withdrawals', [\App\Http\Controllers\Admin\WithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::post('/withdrawals/{withdrawal}/approve', [\App\Http\Controllers\Admin\WithdrawalController::class, 'approve'])->name('withdrawals.approve');
    Route::post('/withdrawals/{withdrawal}/reject', [\App\Http\Controllers\Admin\WithdrawalController::class, 'reject'])->name('withdrawals.reject');

    // Settings Management
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings/update', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

    // Contact Messages
    Route::get('/messages', [\App\Http\Controllers\Admin\ContactMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [\App\Http\Controllers\Admin\ContactMessageController::class, 'show'])->name('messages.show');
    Route::delete('/messages/{message}', [\App\Http\Controllers\Admin\ContactMessageController::class, 'destroy'])->name('messages.destroy');

    // Subscription Codes
    Route::get('/subscription-codes', [\App\Http\Controllers\Admin\SubscriptionCodeController::class, 'index'])->name('subscription-codes.index');
    Route::post('/subscription-codes/generate', [\App\Http\Controllers\Admin\SubscriptionCodeController::class, 'generate'])->name('subscription-codes.generate');
    Route::get('/subscription-codes/export', [\App\Http\Controllers\Admin\SubscriptionCodeController::class, 'export'])->name('subscription-codes.export');
    Route::delete('/subscription-codes/{subscriptionCode}', [\App\Http\Controllers\Admin\SubscriptionCodeController::class, 'destroy'])->name('subscription-codes.destroy');

    // Lesson Video & Lectures Management (Any subject, upload or delete)
    Route::get('/lectures', [\App\Http\Controllers\Admin\LessonVideoController::class, 'allLectures'])->name('lectures.index');
    Route::post('/lectures', [\App\Http\Controllers\Admin\LessonVideoController::class, 'storeQuickLecture'])->name('lectures.store');
    Route::delete('/lectures/{lesson}', [\App\Http\Controllers\Admin\LessonVideoController::class, 'destroyLesson'])->name('lectures.destroy');
    Route::get('/subjects/{subject}/videos', [\App\Http\Controllers\Admin\LessonVideoController::class, 'index'])->name('lessons.videos');
    Route::post('/subjects/{subject}/videos/store-for-teacher', [\App\Http\Controllers\Admin\LessonVideoController::class, 'storeForTeacher'])->name('lessons.store-for-teacher');
    Route::post('/lessons/{lesson}/upload', [\App\Http\Controllers\Admin\LessonVideoController::class, 'upload'])->name('lessons.upload');
    Route::post('/courses/{course}/lessons', [\App\Http\Controllers\Admin\LessonVideoController::class, 'storeLesson'])->name('lessons.store-lesson');
    Route::delete('/lessons/{lesson}', [\App\Http\Controllers\Admin\LessonVideoController::class, 'destroyLesson'])->name('lessons.destroy-lesson');

    // Payments Management (Company receives, Admin confirms)
    Route::get('/payments', [\App\Http\Controllers\Admin\PaymentsController::class, 'index'])->name('payments.index');
    Route::post('/payments/{payment}/confirm', [\App\Http\Controllers\Admin\PaymentsController::class, 'confirm'])->name('payments.confirm');
    Route::post('/payments/{payment}/reject', [\App\Http\Controllers\Admin\PaymentsController::class, 'reject'])->name('payments.reject');
});





// Teacher Routes
Route::prefix('teacher')->middleware(['auth', 'role:teacher'])->name('teacher.')->group(function () {
    Route::get('/pending', function () {
        $user = auth()->user();
        if ($user->is_approved) {
            return redirect()->route('teacher.dashboard');
        }
        return view('teacher.pending');
    })->name('pending');

    Route::middleware(['teacher.approved'])->group(function () {
        Route::get('/', [TeacherDashboard::class, 'index'])->name('dashboard');
        Route::resource('courses', \App\Http\Controllers\Teacher\CourseController::class);
        Route::resource('courses.lessons', \App\Http\Controllers\Teacher\LessonController::class);

        // Quick lecture link upload & management
        Route::post('/lectures/store', [\App\Http\Controllers\Teacher\LessonController::class, 'storeQuickLecture'])->name('lectures.store');
        Route::delete('/lectures/{lesson}', [\App\Http\Controllers\Teacher\LessonController::class, 'destroyQuickLecture'])->name('lectures.destroy');

        Route::get('/enrollments/create', [\App\Http\Controllers\Teacher\EnrollmentController::class, 'create'])->name('enrollments.create');
        Route::post('/enrollments', [\App\Http\Controllers\Teacher\EnrollmentController::class, 'store'])->name('enrollments.store');

        Route::get('/earnings', [\App\Http\Controllers\Teacher\EarningsController::class, 'index'])->name('earnings.index');
        Route::post('/earnings/settle', [\App\Http\Controllers\Teacher\EarningsController::class, 'settleCommission'])->name('earnings.settle');
        Route::post('/withdrawals', [\App\Http\Controllers\Teacher\WithdrawalController::class, 'store'])->name('withdrawals.store');
    });
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Payments
Route::middleware('auth')->group(function () {
    Route::get('/course/{course}/checkout', [\App\Http\Controllers\PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::post('/course/{course}/payment', [\App\Http\Controllers\PaymentController::class, 'process'])->name('payment.process');
    Route::get('/payment/kiosk/{bill_reference}', [\App\Http\Controllers\PaymentController::class, 'kiosk'])->name('payment.kiosk');
    Route::get('/payment/callback', [\App\Http\Controllers\PaymentController::class, 'callback'])->name('payment.callback');
    
    // Traditional Payment Routes
    Route::get('/course/{course}/traditional-payment', [\App\Http\Controllers\PaymentController::class, 'traditionalPayment'])->name('payment.traditional');
    Route::post('/course/{course}/traditional-payment', [\App\Http\Controllers\PaymentController::class, 'processTraditionalPayment'])->name('payment.traditional.process');
    Route::get('/payment/success/{payment}', [\App\Http\Controllers\PaymentController::class, 'paymentSuccess'])->name('payment.success');
    
    // Payment Dashboards
    Route::get('/teacher/payments', [\App\Http\Controllers\PaymentController::class, 'teacherPayments'])->name('payments.teacher')->middleware('teacher.approved');
    Route::post('/payment/{payment}/confirm', [\App\Http\Controllers\PaymentController::class, 'confirmPayment'])->name('payment.confirm')->middleware('teacher.approved');
    Route::get('/student/payments', [\App\Http\Controllers\PaymentController::class, 'studentPayments'])->name('payments.student');
});

// Webhook (Excempt from CSRF)
Route::post('/payment/webhook', [\App\Http\Controllers\PaymentController::class, 'webhook'])->name('payment.webhook');

// Educational Hierarchy
Route::get('/stage/{id}', [EducationController::class, 'stage'])->name('stage.show');
Route::get('/grade/{id}', [EducationController::class, 'grade'])->name('grade.show');
Route::get('/subject/{id}', [EducationController::class, 'subject'])->name('subject.show');
Route::get('/subject/{subject}/teacher/{teacher}', [EducationController::class, 'teacherCourses'])->name('subject.teacher');

// Subject Access (Subscription Code Verification)
Route::post('/subject/{gradeId}/{subjectId}/verify', [\App\Http\Controllers\SubjectAccessController::class, 'verify'])->name('subject.verify');
Route::get('/grade/{gradeId}/subject/{subjectId}/videos', [\App\Http\Controllers\SubjectAccessController::class, 'videos'])->name('subject.videos');

// Courses
Route::get('/course/{id}', [CourseController::class, 'show'])->name('course.show');
// Remove old enroll route
// Route::post('/course/{id}/enroll', [CourseController::class, 'enroll'])->middleware('auth')->name('course.enroll');

require __DIR__.'/auth.php';
