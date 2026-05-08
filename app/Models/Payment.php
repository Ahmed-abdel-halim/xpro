<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'teacher_id',
        'course_id',
        'amount',
        'payment_method',
        'transaction_id',
        'bank_name',
        'account_number',
        'sender_number',
        'proof_image',
        'notes',
        'status',
        'payment_date',
        'confirmed_at',
        'commission_amount',
        'teacher_amount',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    protected $casts = [
        'payment_date' => 'datetime',
        'confirmed_at' => 'datetime',
        'amount' => 'decimal:2'
    ];

    // Scopes
    public function scopeForTeacher($query, $teacherId)
    {
        return $query->where('teacher_id', $teacherId);
    }

    public function scopeForStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
