<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = auth()->user();
        $courseIds = $teacher->courses()->pluck('id');
        
        // Sum of teacher_amount from confirmed payments for their courses (with fallback)
        $totalRevenue = \App\Models\Payment::whereIn('course_id', $courseIds)
            ->where('status', 'confirmed')
            ->get()
            ->sum(function($p) {
                return $p->teacher_amount > 0 ? $p->teacher_amount : ($p->amount * $p->teacher->getTeacherRate());
            });

        // Sum of commission_amount that is NOT yet paid to platform (with fallback)
        $pendingCommission = 0;
        if (\Illuminate\Support\Facades\Schema::hasColumn('payments', 'is_commission_paid')) {
            $pendingCommission = \App\Models\Payment::whereIn('course_id', $courseIds)
                ->where('status', 'confirmed')
                ->where('is_commission_paid', false)
                ->get()
                ->sum(function($p) {
                    return $p->commission_amount > 0 ? $p->commission_amount : ($p->amount * $p->teacher->getPlatformRate());
                });
        }
        
        $stats = [
            'total_students' => \App\Models\Payment::whereIn('course_id', $courseIds)
                ->where('status', 'confirmed')
                ->distinct('student_id')
                ->count(),
            'total_courses' => $courseIds->count(),
            'total_revenue' => $totalRevenue,
            'pending_commission' => $pendingCommission,
        ];
        
        $recentEnrollments = \App\Models\Enrollment::whereIn('course_id', $courseIds)
            ->with(['student', 'course'])
            ->latest()
            ->take(5)
            ->get();

        return view('teacher.dashboard', compact('stats', 'recentEnrollments'));
    }
}
