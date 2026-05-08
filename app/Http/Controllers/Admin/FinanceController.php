<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index()
    {
        $payments = Payment::where('status', 'confirmed')->get();
        
        $stats = [
            'total_sales' => $payments->sum('amount'),
            'total_commission_paid' => $payments->where('is_commission_paid', true)->sum(function($p) {
                return $p->commission_amount > 0 ? $p->commission_amount : ($p->amount * $p->teacher->getPlatformRate());
            }),
            'total_commission_pending' => $payments->where('is_commission_paid', false)->sum(function($p) {
                return $p->commission_amount > 0 ? $p->commission_amount : ($p->amount * $p->teacher->getPlatformRate());
            }),
        ];

        // Fetch teachers and calculate their pending commission
        $teachers = \App\Models\User::where('role', 'teacher')->get();
        foreach($teachers as $teacher) {
            $teacherCourseIds = $teacher->courses()->pluck('id');
            $teacher->pending_commission = Payment::whereIn('course_id', $teacherCourseIds)
                ->where('status', 'confirmed')
                ->where('is_commission_paid', false)
                ->get()
                ->sum(function($p) {
                    return $p->commission_amount > 0 ? $p->commission_amount : ($p->amount * $p->teacher->getPlatformRate());
                });
            
            $teacher->paid_commission = Payment::whereIn('course_id', $teacherCourseIds)
                ->where('status', 'confirmed')
                ->where('is_commission_paid', true)
                ->get()
                ->sum(function($p) {
                    return $p->commission_amount > 0 ? $p->commission_amount : ($p->amount * $p->teacher->getPlatformRate());
                });
        }
        
        $recentPayments = Payment::with(['student', 'course', 'teacher'])->latest()->take(50)->get();

        return view('admin.finance.index', compact('stats', 'teachers', 'recentPayments'));
    }

    public function settleTeacherCommission(\App\Models\User $teacher)
    {
        $teacherCourseIds = $teacher->courses()->pluck('id');
        
        Payment::whereIn('course_id', $teacherCourseIds)
            ->where('status', 'confirmed')
            ->where('is_commission_paid', false)
            ->update(['is_commission_paid' => true]);

        return back()->with('success', "تم تسوية حساب المدرس {$teacher->name} بنجاح.");
    }
}
