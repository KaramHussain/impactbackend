@component('mail::message')
# Verify your email

Hi {{$provider->name}}!<br>
Please click to verify your email

@component('mail::button', ['url' => $url])
Verify
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
