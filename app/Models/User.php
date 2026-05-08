<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_approved',
        'phone',
        'avatar',
        'commission_percentage',
        'is_free_trial_enabled',
        'payout_method',
        'payout_details',
    ];

    public function isAdmin() { return $this->role === 'admin'; }
    public function isTeacher() { return $this->role === 'teacher'; }
    public function isStudent() { return $this->role === 'student'; }

    public function courses()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }

    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'enrollments', 'student_id', 'course_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'student_id');
    }

    public function receivedPayments()
    {
        return $this->hasMany(Payment::class, 'teacher_id');
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getTeacherRate()
    {
        if ($this->role !== 'teacher') return 0;
        
        // The value in DB (e.g. 20) is the Teacher's percentage
        return ($this->commission_percentage ?? 0) / 100;
    }

    public function getPlatformRate()
    {
        if ($this->role !== 'teacher') return 0;
        
        // Platform gets the rest (e.g. 80%)
        return 1 - $this->getTeacherRate();
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class, 'teacher_id');
    }

    public function availableBalance()
    {
        if ($this->role !== 'teacher') return 0;

        // Sum of all completed payments linked to this teacher's courses
        $totalEarned = Payment::whereIn('course_id', $this->courses()->pluck('id'))
            ->where('status', 'completed')
            ->sum('teacher_amount');
        
        // Subtract already withdrawn or pending amounts
        $totalWithdrawn = $this->withdrawals()->whereIn('status', ['completed', 'pending'])->sum('amount');
        
        return $totalEarned - $totalWithdrawn;
    }
}

