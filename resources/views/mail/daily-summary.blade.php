<div>
    <h1>Hi, {{ $user_name }}</h1>
    <p>Here is your daily summary:</p>
    <ul>
        @foreach($tasks as $task)
            <li>{{ $task->title }}</li>
        @endforeach
    </ul>
    <p>Have a great day!</p>
    <p>Best regards, <br> {{ config('app.name') }}</p>
</div>