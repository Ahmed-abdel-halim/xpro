<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Course;
use Illuminate\Http\Request;

class EarningsController extends Controller
{
    public function index()
    {
        $teacher = auth()->user();
        $courseIds = $teacher->courses()->pluck('id');
        
        // Confirmed payments for this teacher's courses
        $payments = \App\Models\Payment::whereIn('course_id', $courseIds)
            ->where('status', 'confirmed')
            ->get();
            
        $grossRevenue = $payments->sum('amount');
        
        $netEarnings = $payments->sum(function($p) {
            return $p->teacher_amount > 0 ? $p->teacher_amount : ($p->amount * $p->teacher->getTeacherRate());
        });
        
        // Commission that is NOT yet paid
        $pendingCommission = 0;
        $paidCommission = 0;
        if (\Illuminate\Support\Facades\Schema::hasColumn('payments', 'is_commission_paid')) {
            $pendingCommission = $payments->where('is_commission_paid', false)->sum(function($p) {
                return $p->commission_amount > 0 ? $p->commission_amount : ($p->amount * $p->teacher->getPlatformRate());
            });
            
            $paidCommission = $payments->where('is_commission_paid', true)->sum(function($p) {
                return $p->commission_amount > 0 ? $p->commission_amount : ($p->amount * $p->teacher->getPlatformRate());
            });
        }
        
        // Count unique students
        $totalStudents = $payments->unique('student_id')->count();

        $courses = Course::whereIn('id', $courseIds)
            ->withCount(['payments' => function($query) {
                $query->where('status', 'confirmed');
            }])
            ->get();
            
        foreach($courses as $course) {
            $course->total_sales = $course->payments->where('status', 'confirmed')->sum('amount');
            
            $course->teacher_profit = $course->payments->where('status', 'confirmed')->sum(function($p) {
                return $p->teacher_amount > 0 ? $p->teacher_amount : ($p->amount * $p->teacher->getTeacherRate());
            });
        }
            
        return view('teacher.earnings.index', compact(
            'courses', 
            'totalStudents', 
            'grossRevenue', 
            'netEarnings', 
            'pendingCommission',
            'paidCommission'
        ));
    }

    public function settleCommission()
    {
        $teacher = auth()->user();
        $courseIds = $teacher->courses()->pluck('id');

        // Mark all confirmed commissions as paid for this teacher
        \App\Models\Payment::whereIn('course_id', $courseIds)
            ->where('status', 'confirmed')
            ->where('is_commission_paid', false)
            ->update(['is_commission_paid' => true]);

        return back()->with('success', 'تم تصفير مستحقات المنصة بنجاح.');
    }
}
