@component('mail::message')
# Hi {{$member->name}}!<br>

{{$provider->name}} assign you as {{$member->roles->first()->name}}.<br>

Use these credentials for login.<br><br>
Email: {{$member->email}}<br>
Password: {{$otp}}
<br>
Use this link <a href="{{config('app.frontend_impact_analysis')}}/login">Impact Analysis</a>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
