<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewPaymentReceived extends Notification implements ShouldQueue
{
    use Queueable;

    protected $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('دفع جديد - منصة Xpro')
            ->greeting('مرحباً ' . $notifiable->name)
            ->line('تم استلام طلب دفع جديد من الطالب: ' . $this->payment->student->name)
            ->line('الكورس: ' . $this->payment->course->title)
            ->line('المبلغ: ' . number_format($this->payment->amount, 2) . ' جنيه')
            ->line('طريقة الدفع: ' . ($this->payment->payment_method === 'bank_transfer' ? 'تحويل بنكي' : 'محفظة إلكترونية'))
            ->action('تأكيد الدفع', route('payments.teacher'))
            ->line('يرجى مراجعة طلب الدفع وتأكيده في أقرب وقت ممكن.');
    }

    public function toArray($notifiable)
    {
        return [
            'payment_id' => $this->payment->id,
            'student_name' => $this->payment->student->name,
            'course_title' => $this->payment->course->title,
            'amount' => $this->payment->amount,
            'payment_method' => $this->payment->payment_method,
            'status' => 'pending',
            'message' => 'دفع جديد من ' . $this->payment->student->name . ' لكورس ' . $this->payment->course->title
        ];
    }
}
