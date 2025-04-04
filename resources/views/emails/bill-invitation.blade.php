@component('mail::message')
# You've been invited to join "{{ $bill->name }}"

@if($invitation->user_type === 'guest')
Hello {{ $invitation->nickname }},

You've been invited as a guest to view and participate in the bill "{{ $bill->name }}".
@else
Hello,

You've been invited to join the bill "{{ $bill->name }}".
@endif

@component('mail::button', [
    'url' => route('login', ['code' => $bill->invitation_code]),
    'color' => 'primary'
])
View Bill Now
@endcomponent

@if($invitation->user_type === 'guest')
**Want to become a member?**  
[Register here]({{ route('register', ['invite' => $invitation->token]) }}) to join permanently.
@endif

Thanks,  
{{ config('app.name') }}
@endcomponent