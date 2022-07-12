@component('mail::message')
# Visitor Message

Some visitor left a message.
<br><br>
    First Name: {{$first_name}}
<br>
    Last Name: {{$last_name}}
<br>
    Email: {{$email}}
<br>
    Subject: {{$subject}}
<br>
   Message: {{$message}}

@component('mail::button', ['url' => ''])
View Message
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
