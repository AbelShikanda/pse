<<<<<<< HEAD
@component('mail::message')
    # Hello, {{ $first_name }} {{ $last_name }}

    Thank you for signing up!

    @component('mail::button', ['url' => url('/users/' . $user_id)])
        View Profile
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
=======
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
>>>>>>> 13b75d815679ffd73381c0dfde26250cc365014e
