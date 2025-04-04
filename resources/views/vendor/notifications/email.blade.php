@component('mail::message')
# Email Verification

Hello {{ $notifiable->nickname ?? $notifiable->email }},

Thank you for registering with {{ config('app.name') }}. Please click the button below to verify your email address.

@component('mail::button', ['url' => $verificationUrl])
Verify Email Address
@endcomponent

If you did not create an account, no further action is required.

Thanks,<br>
The {{ config('app.name') }} Team

@component('mail::subcopy')
If you're having trouble clicking the "Verify Email Address" button, copy and paste the URL below into your web browser:
[{{ $verificationUrl }}]({{ $verificationUrl }})
@endcomponent
@endcomponent