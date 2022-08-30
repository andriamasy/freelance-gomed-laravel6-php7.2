@component('mail::message')
# Forgot your password ?

That's OK, it happens! Click on the button bellow to reset your password.

@component('mail::button', ['url' => 'http://127.0.0.1:8000/reset/'. $token])
RESET YOUR PASSWORD
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
