@component('mail::message')
    # Forgot Password

    Your verification code is: **{{ $code }}**

    Thanks,
    {{ config('app.name') }}
@endcomponent
