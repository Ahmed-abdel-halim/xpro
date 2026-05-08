<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $payments = Payment::where('status', 'confirmed')->get();
        
        $stats = [
            'total_users' => User::count(),
            'total_teachers' => User::where('role', 'teacher')->count(),
            'total_students' => User::where('role', 'student')->count(),
            
            'total_sales' => $payments->sum('amount'),
            
            'commission_paid' => $payments->where('is_commission_paid', true)->sum(function($p) {
                return $p->commission_amount > 0 ? $p->commission_amount : ($p->amount * $p->teacher->getPlatformRate());
            }),
            
            'commission_pending' => $payments->where('is_commission_paid', false)->sum(function($p) {
                return $p->commission_amount > 0 ? $p->commission_amount : ($p->amount * $p->teacher->getPlatformRate());
            }),

            'active_subscriptions' => $payments->count(),
            'unread_messages' => \App\Models\ContactMessage::where('is_read', false)->count(),
        ];

        $recentPayments = Payment::with(['student', 'course', 'teacher'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentPayments'));
    }
}
