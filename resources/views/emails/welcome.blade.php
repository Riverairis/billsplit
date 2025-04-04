@component('mail::message')
# Welcome to BillSplit!

Hello {{ $user->nickname }},

Thank you for registering with BillSplit. We're excited to have you on board!

Click the button below to log in and start splitting bills:

@component('mail::button', ['url' => route('login')])
Login to Your Account
@endcomponent

If you have any questions, feel free to reply to this email.

Happy splitting!<br>
The BillSplit Team

@component('mail::subcopy')
If you didn’t register, please ignore this email.
@endcomponent
@endcomponent