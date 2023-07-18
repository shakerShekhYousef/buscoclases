@component('mail::message')
# Contact Us

Un nuevo mensaje de {{$first_name}} {{$last_name}}<br><br>

E-mail : {{$email}}<br>
Número de teléfono : {{$phone}}<br>
Razón : {{$reason}} <br>
Message : {{$message}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
