<x-mail::message>
# A New Account Created

Hi Printshopeld <br>
A new user by the name: ({{ $first_name }} {{ $last_name }}) has created an account with you. 
<br>
<br>
@if ( $gender == 'male' )
He resides in: {{ $location }}<br> 
@elseif ($gender == 'female')
She resides in: {{ $location }}<br> 
@else
They reside in: {{ $location }}<br> 
@endif
<br>
<br>
If you wish to see more information click on the button below. <br>

<x-mail::button :url="url('/users/' . $user_id)">
View Customer
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
