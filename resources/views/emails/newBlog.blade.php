<<<<<<< HEAD
{{-- @component('mail::message')
    # Hello, {{ $first_name }} {{ $last_name }}

    Thank you for signing up!

    @component('mail::button', ['url' => url('/users/' . $user_id)])
        View Profile
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent --}}



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Your existing styles here... */
    </style>
</head>

<body>
    @component('mail::message')
    <section class="info">
        <img src="https://www.printshopeld.com/img/logo/logo.png">
        <h1>PrintShopEld &mdash; <a href="{{ url('/blogs/') }}" target="_blank">Shop</a></h1>
    </section>
    
    <section class="cards-wrapper">
        <div class="card-grid-space">
            <div class="num">01</div>
            <a class="card" href="{{ url('/blog/single/' . $blogImages->id) }}">
                <div>
                    <h1>{{ $user->first_name }}</h1>
                    <p>{{ $blog->sub_title }}</p>
                    <div class="tags">
                        <!-- Add tags or other dynamic content here -->
                    </div>
                </div>
            </a>
        </div>
    </section>

    @component('mail::button', ['url' => url('/blogs/' . $user_id)])
        View Profile
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
    @endcomponent
</body>

</html>
=======
<x-mail::message>
# New Story Alert!
 
Hi {{ $user->first_name }} !
<br>
<br>
{{ $blog->sub_title}}
<br>
<br>

<x-mail::button :url="url('/blog/single/' . $blogImages->id)">
Read More ...
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
>>>>>>> 13b75d815679ffd73381c0dfde26250cc365014e
