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
