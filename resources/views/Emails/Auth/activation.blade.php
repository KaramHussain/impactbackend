@component('mail::message')
# Activation Email

Thanks for Registeration. Please click the activation link to activate your account.

@component('mail::button', ['url' => $url])
    Activate
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
