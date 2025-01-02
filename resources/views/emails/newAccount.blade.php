
@component('mail::message')
    # Hello, {{ $first_name }} {{ $last_name }}

    Thank you for signing up!

    @component('mail::button', ['url' => url('/users/' . $user_id)])
        View Profile
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
