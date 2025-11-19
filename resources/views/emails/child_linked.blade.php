@component('mail::message')
# Child Linked to Your Account

Hello {{ $parent->first_name }},

A child called **{{ $child->first_name }} {{ $child->last_name }}** has been linked to your account.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
