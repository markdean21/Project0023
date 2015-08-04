<html>
    <head></head>
    <body>
        <a href="{{URL::previous()}}">Back</a>
        <h3>Taskminator Details</h3>
        {{ $tm->fullName }}<br/>
        Address : {{ $tm->address }}<br/>
        City : {{ City::where('citycode', $tm->city)->pluck('cityname') }}<br/>
        Barangay : {{ Barangay::where('bgycode', $tm->barangay)->pluck('bgyname') }}<br/>

        @if(Task::where('user_id', Auth::user()->id)->where('status', 'OPEN')->where('hiringType', 'DIRECT')->count() > 0)
            <a href="/directHire_{{ $tm->id }}">Hire for Direct Task</a>
        @endif
    </body>
</html>