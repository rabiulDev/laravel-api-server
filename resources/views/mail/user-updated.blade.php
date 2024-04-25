@component("mail::message")
# Hello {{$name}}!!
@component('mail::panel')
Your profile is updated successfully.
@endcomponent

@component('mail::subcopy')
Thanks for stay with us.
@endcomponent

Thanks, <br>
{{ config('app.name') }}

@endcomponent
