<x-mail::message>
    # New message

    Hi, {{ $lead->name }}

    Thanks for contacting me! I will answer to you as soon as possible!
    In the meantime you can check some projects from my website!
    Have a wonderful day!



    Thanks,
    {{ config('app.name') }}
</x-mail::message>
