<html>
    <head></head>
    <body>
        <h1>Notifications</h1>
        @foreach($notifications as $notif)
            <div style="border: 2px solid black; padding: 0.4em; margin-bottom: 0.4em; cursor: pointer;" onclick="location.href='{{$notif->notif_url}}'">
                {{ $notif->content }}<br/>
                <span style="color: #7F8C8D; font-size: 0.8em">{{ $notif->created_at }}</span>
            </div>
        @endforeach
        {{ $notifications->links() }}
    </body>
</html>