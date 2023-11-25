<x-mail::message>
    # New message

    From: {{ $lead->name }}
    Email: {{ $lead->email }}
    Phone: {{ $lead->phone }}

    Message:


    {{ $lead->message }}



</x-mail::message>
