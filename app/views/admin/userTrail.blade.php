<html>
    <head>
        <script src="/js/jquery-1.11.0.min.js" type="text/javascript"></script>
        <script>
            $(document).ready(function(){
                $('#searchByDate').change(function(){
                    switch($(this).val()){
                        case 'date'     :
                            $('.singleDate').prop('disabled', false);
                            $('.betweenDate').prop('disabled', true);
                            break;
                        case 'bet_date' :
                            $('.singleDate').prop('disabled', true);
                            $('.betweenDate').prop('disabled', false);
                            break;
                        default :
                            $('.singleDate').prop('disabled', true);
                            $('.betweenDate').prop('disabled', true);
                    }
                })
            });
        </script>
    </head>
    <body style="background-color: #BDC3C7;">
        <a href="/">Home</a><br/>
        <h2>Audit Trail for {{$user->fullName}}</h2>
        <hr/>
        <form method="POST" action="/searchAudits">
            <input type="hidden" name="userId" value="{{$user->id}}" />
            Search by date :
            <select id="searchByDate">
                <option value="date">Date</option>
                <option value="bet_date">Between two dates</option>
            </select>

            <input name="date" placeholder="Select Date" class="singleDate"/>
            <input name="date1" placeholder="Select First Date" class="betweenDate" disabled/>
            <input name="date2" placeholder="Select Second Date" class="betweenDate" disabled/>
            <button type="submit">Search</button>
        </form>
        @if($trails->count() == 0)
            <center><i>No data available.</i></center>
        @else
            @foreach($trails as $trail)
            <div style="padding: 0.4em; margin: 0.4em; background-color: white;">
                {{ $trail->content }}
                @if($trail->at_url)
                    <a target="_tab" href="/admin{{ $trail->at_url }}">VIEW_DETAILS_ICON</a>
                @endif()
                <br/>
                <span style="color: #7F8C8D; font-size: 0.8em">{{ $trail->created_at }}</span>
            </div>
            @endforeach

            {{ $trails->links() }}
        @endif
    </body>
</html>