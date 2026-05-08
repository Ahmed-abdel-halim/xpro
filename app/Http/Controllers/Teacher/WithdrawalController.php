<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    /**
     * Store a new withdrawal request
     */
    public function store(Request $request)
    {
        $teacher = auth()->user();
        $amount = $request->input('amount');
        $available = $teacher->availableBalance();

        if ($amount > $available) {
            return back()->with('error', 'الرصيد غير كافٍ لإتمام العملية.');
        }

        if ($amount < 100) {
            return back()->with('error', 'الحد الأدنى للسحب هو 100 ج.م');
        }

        if (!$teacher->payout_method || !$teacher->payout_details) {
            return back()->with('error', 'يرجى إكمال بيانات التحويل أولاً.');
        }

        Withdrawal::create([
            'teacher_id' => $teacher->id,
            'amount' => $amount,
            'status' => 'pending',
            'payout_method' => $teacher->payout_method,
            'payout_details' => $teacher->payout_details,
        ]);

        return back()->with('success', 'تم إرسال طلب السحب بنجاح. سيتم مراجعته من قبل الإدارة.');
    }
}
