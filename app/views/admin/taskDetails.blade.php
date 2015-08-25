<html>
    <head></head>
    <body>
        <h2>Task Details for {{ $task->name }}</h2>
        Created by : <a href="/viewUserProfile/{{ $client->id }}">{{ $client->fullName }}</a><br/>
        Date Created : {{ $task->created_at }}<br/>
        Description : {{ $task->description }}<br/>
        Hiring Type : {{ $task->hiringType }}<br/>
        Working Time: {{ $task->workTime }}<br/>
        Task Skill Category : {{ TaskCategory::where('categorycode', $task->taskCategory)->pluck('categoryname') }}<br/>
        Task Skill : {{ TaskItem::where('itemcode', $task->taskType)->pluck('itemname') }}<br/>
        Status : {{ $task->status }}<br/>
        @if($task->status == 'COMPLETE')
            Completed at : {{ $task->completed_at }}<br/>
            Completed by : {{ User::where('id', $task->completed_by)->pluck('fullName') }}<br/>
        @endif
        @if($taskminator)
            <hr/>
            <h4>Taskminator Details</h4>
            Hired : <a target="_tab" href="/viewUserProfile/{{ $taskminator->id }}">{{ $taskminator->fullName }}</a><br/>
            Date Hired : {{ $taskminator->created_at }}
        @endif
    </body>
</html>