<html>
    <head>
        {{ HTML::script('js/jquery-1.11.0.min.js') }}
        <script>
            $(document).ready(function(){
                if($('#searchBy').val() == 'workTime'){
                    $('#workTimeValue').prop('disabled', false);
                }

                $('#searchBy').change(function(){
                    if($(this).val() == 'workTime'){
                        $('#workTimeValue').prop('disabled', false);
                    }else{
                        $('#workTimeValue').prop('disabled', true);
                    }
                });
            });
        </script>
    </head>
    <body>
        <h3>Tasks created by {{ $client->fullName }}</h3>
        <form method="POST" action="/viewUsersTasks=search">
            <input type="hidden" value="{{$client->id}}" name="clientid">
            Search by : <select name="searchBy" id="searchBy">
                <option value="0">Display All</option>
                <option value="name" <?php if(@$searchBy == 'name'){ echo('selected'); } ?>>Task Name</option>
                <option value="workTime" <?php if(@$searchBy == 'workTime'){ echo('selected'); } ?>>Work Time</option>
            </select>
            <select name="workTimeValue" id="workTimeValue" disabled>
                <option value="PTIME" <?php if(@$workTimeValue == 'PTIME'){ echo('selected'); } ?>>Part Time</option>
                <option value="FTIME" <?php if(@$workTimeValue == 'FTIME'){ echo('selected'); } ?>>Full Time</option>
            </select>
            Hiring Type : <select name="hiringType" id="hiringType">
                <option value="ALL" <?php if(@$hiringType == 'ALL'){ echo('selected'); } ?>>Display All</option>
                <option value="DIRECT" <?php if(@$hiringType == 'DIRECT'){ echo('selected'); } ?>>Direct</option>
                <option value="AUTOMATIC"  <?php if(@$hiringType == 'AUTOMATIC'){ echo('selected'); } ?>>Automatic</option>
                <option value="BIDDING"  <?php if(@$hiringType == 'BIDDING'){ echo('selected'); } ?>>Bidding</option>
            </select>
            Status : <select name="status" id="status">
                <option value="ALL" <?php if(@$status == 'ALL'){ echo('selected'); } ?>>Display All</option>
                <option value="OPEN" <?php if(@$status == 'OPEN'){ echo('selected'); } ?>>Open</option>
                <option value="ONGOING" <?php if(@$status == 'ONGOING'){ echo('selected'); } ?>>On Going</option>
                <option value="COMPLETE" <?php if(@$status == 'COMPLETED'){ echo('selected'); } ?>>Complete</option>
                <option value="CANCELLED" <?php if(@$status == 'CANCELLED'){ echo('selected'); } ?>>Cancelled</option>
            </select>
            <input type="text" name="searchWord" placeholder="search keyword"/>
            <button type="submit">Search</button>
        </form>

        @if($tasks->count() == 0)
            <center><i>No data available.</i></center>
        @endif

        @foreach($tasks as $task)
            <div style="padding: 0.4em; margin-bottom: 0.4em; border: 2px solid #27AE60;">
                Task Name : <a target="_tab" href="/admin/taskDetails/{{$task->id}}">{{ $task->name }}</a><br/>
                Hiring Type : {{ $task->hiringType }}<br/>
                Created at : {{ $task->created_at }}<br/>
                Status : {{ $task->status }}<br/>
                @if($task->status == 'COMPLETE')
                    <hr/>
                    Completed by : <a target="_tab" href="/viewUserProfile/{{$task->completed_by}}">{{ User::where('id', $task->completed_by)->pluck('fullName') }}</a><br/>
                    Completed at : {{ $task->completed_at }}
                @endif
            </div>
        @endforeach
    </body>
</html>