@component('mail::message')
# Reset your Password

Please click the activation link to reset your password.


@component('mail::button', ['url' => $url])
    Reset
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
