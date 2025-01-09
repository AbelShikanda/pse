
@component('mail::message')
    # New user just signed up!

    @component('mail::button', ['url' => url('/users/' . $user_id)])
        View Profile
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
