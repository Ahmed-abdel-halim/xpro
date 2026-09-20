<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionCode;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\Stage;
use Illuminate\Http\Request;

class SubscriptionCodeController extends Controller
{
    /** عرض جميع الرموز */
    public function index(Request $request)
    {
        $query = SubscriptionCode::with(['subject', 'teacher', 'grade', 'usedBy', 'createdBy'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('grade_id')) {
            $query->where('grade_id', $request->grade_id);
        }
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }
        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        $codes    = $query->paginate(20)->withQueryString();
        $stages   = Stage::with('grades.subjects')->get();
        $grades   = Grade::with('stage')->get();
        $subjects = Subject::with('grade.stage')->orderBy('name')->get();
        $teachers = \App\Models\User::where('role', 'teacher')->orderBy('name')->get();

        $stats = [
            'active' => SubscriptionCode::where('status', 'active')->count(),
            'used'   => SubscriptionCode::where('status', 'used')->count(),
            'total'  => SubscriptionCode::count(),
        ];

        return view('admin.subscription_codes.index', compact('codes', 'stages', 'grades', 'subjects', 'teachers', 'stats'));
    }

    /** توليد رمز/رموز جديدة */
    public function generate(Request $request)
    {
        $request->validate([
            'subject_id'  => 'nullable|exists:subjects,id',
            'teacher_id'  => 'nullable|exists:users,id',
            'grade_id'    => 'nullable|exists:grades,id',
            'quantity'    => 'required|integer|min:1|max:100',
            'expires_at'  => 'nullable|date|after:today',
            'notes'       => 'nullable|string|max:500',
        ]);

        $gradeId = $request->grade_id;
        if (!$gradeId && $request->subject_id) {
            $gradeId = Subject::find($request->subject_id)?->grade_id;
        }

        $generated = [];
        for ($i = 0; $i < $request->quantity; $i++) {
            $code = SubscriptionCode::create([
                'code'        => SubscriptionCode::generateCode(),
                'subject_id'  => $request->subject_id,
                'teacher_id'  => $request->teacher_id,
                'grade_id'    => $gradeId,
                'expires_at'  => $request->expires_at,
                'notes'       => $request->notes,
                'created_by'  => auth()->id(),
                'status'      => 'active',
            ]);
            $generated[] = $code->code;
        }

        return redirect()->route('admin.subscription-codes.index')
            ->with('success', 'تم توليد ' . count($generated) . ' رمز اشتراك بنجاح.');
    }

    /** تصدير الرموز كـ CSV */
    public function export(Request $request)
    {
        $codes = SubscriptionCode::with(['subject', 'teacher', 'grade'])->where('status', 'active')->get();

        $csv = "الرمز,المادة,المدرس,الصف,الحالة,تاريخ الانتهاء\n";
        foreach ($codes as $code) {
            $csv .= implode(',', [
                $code->code,
                '"' . ($code->subject?->name ?? 'كل المواد') . '"',
                '"' . ($code->teacher?->name ?? 'كل المدرسين') . '"',
                '"' . ($code->grade?->name   ?? 'كل الصفوف') . '"',
                $code->status,
                $code->expires_at?->format('Y-m-d') ?? 'لا يوجد',
            ]) . "\n";
        }

        return response($csv, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="subscription_codes.csv"',
        ]);
    }

    /** حذف رمز */
    public function destroy(SubscriptionCode $subscriptionCode)
    {
        if ($subscriptionCode->status === 'used') {
            return back()->with('error', 'لا يمكن حذف رمز مستخدم.');
        }
        $subscriptionCode->delete();
        return back()->with('success', 'تم حذف الرمز بنجاح.');
    }
}
