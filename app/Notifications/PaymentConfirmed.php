<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentConfirmed extends Notification implements ShouldQueue
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
            ->subject('تم تأكيد الدفع - منصة Xpro')
            ->greeting('مرحباً ' . $notifiable->name)
            ->line('تم تأكيد دفعك بنجاح!')
            ->line('الكورس: ' . $this->payment->course->title)
            ->line('المبلغ: ' . number_format($this->payment->amount, 2) . ' جنيه')
            ->line('المدرس: ' . $this->payment->teacher->name)
            ->action('عرض الكورس', route('course.show', $this->payment->course_id))
            ->line('يمكنك الآن الوصول إلى جميع محتويات الكورس.');
    }

    public function toArray($notifiable)
    {
        return [
            'payment_id' => $this->payment->id,
            'teacher_name' => $this->payment->teacher->name,
            'course_title' => $this->payment->course->title,
            'amount' => $this->payment->amount,
            'status' => 'confirmed',
            'message' => 'تم تأكيد دفعك لكورس ' . $this->payment->course->title . ' بنجاح!'
        ];
    }
}
