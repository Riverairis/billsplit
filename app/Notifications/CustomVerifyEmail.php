<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;

class CustomVerifyEmail extends VerifyEmailBase
{
    use Queueable; // Keep this for potential future use, but no ShouldQueue

    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verify Your BillSplit Account')
            ->markdown('vendor.notifications.email', [
                'greeting' => 'Hello ' . ($notifiable->nickname ?? $notifiable->email) . ',',
                'introLines' => [
                    'Thank you for registering with BillSplit!',
                    'Please click the button below to verify your email address.',
                ],
                'actionText' => 'Verify Email Address',
                'actionUrl' => $verificationUrl,
                'outroLines' => [
                    'If you did not create an account, no further action is required.',
                ],
            ]);
    }
}