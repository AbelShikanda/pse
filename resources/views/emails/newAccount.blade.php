
@component('mail::message')
# New user just signed up!
{{$user->first_name}} {{$user->last_name}} from {{$user->location}} just signed up to the platform on {{ $user->created_at }}. 
You can view their profile by clicking the button below.

@component('mail::button', ['url' => url('/users/' . $user_id)])
    View Profile
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
