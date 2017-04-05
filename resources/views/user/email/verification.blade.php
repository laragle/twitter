@component('mail::message')
# Final step...

Confirm your email address to complete your Twitter account {{ $user->username }}. It's easy — just click the button below.

@component('mail::button', ['url' => $user->email_verification_url])
Confirm now
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
