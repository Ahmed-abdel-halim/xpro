<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Withdrawal::with('teacher')->latest()->get();
        return view('admin.finance.withdrawals', compact('withdrawals'));
    }

    public function approve(Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'هذا الطلب تمت معالجته بالفعل.');
        }

        $withdrawal->update(['status' => 'completed']);
        return back()->with('success', 'تم تأكيد تحويل المبلغ بنجاح.');
    }

    public function reject(Request $request, Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'هذا الطلب تمت معالجته بالفعل.');
        }

        $withdrawal->update([
            'status' => 'rejected',
            'admin_note' => $request->input('admin_note')
        ]);

        return back()->with('success', 'تم رفض الطلب.');
    }
}
