@component('mail::message')
# Hello! {{$data->user['name']}}

Thank you for your offer! Your offer has been accepted.
You can now proceed to cart and purchase care.

@component('mail::table')
    | Treatment       | Avg Cost         | Counter offer  |
    | -------------   |:-------------:| --------:|
    | {{$data->data['treatment']}}      | {{$data->data['avg_cost']}}      | {{$data->data['counter_offer']}}      |
@endcomponent


Regards,<br>
{{ config('app.name') }}
@endcomponent
