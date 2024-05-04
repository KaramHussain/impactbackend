@component('mail::message')
# Support Request Received

@component('mail::panel')
Dear Recipient,
You have got support request from the following prospect.
Name: {{$data->full_name}}
Email: {{$data->email}}
Contact: {{$data->contact_number}}
Description: {{$data->description}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
