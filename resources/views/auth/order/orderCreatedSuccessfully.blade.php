@component('mail::message')
# Congratulations {{$order->user->first_name}} {{$order->user->last_name}}!

Your order {{$order->order_id}} has been placed successfully

@component('mail::button', ['url' => $url])
    View Details
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
