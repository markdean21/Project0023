<html>
    <head></head>
    <body>
        <h2>Ratings for {{ $tskmntr->fullName }}</h2>
        @foreach($ratings as $rate)
            <div style="border: 1px solid black; padding: 0.4em; margin-bottom: 0.4em;">
                <?php $client  = User::where('id', $rate->client_id)->first() ?>
                Reviewed by : <a target="_tab" href="/viewUserProfile/{{ $client->id }}">{{ $client->fullName }}</a><br/>
                Review : {{ $rate->message }}<br/>
                Star(s) : {{ $rate->stars }}
            </div>
        @endforeach
    </body>
</html>