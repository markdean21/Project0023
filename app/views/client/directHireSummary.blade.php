<html>
    <head></head>
    <body>
        <h5>Points left : {{ Auth::user()->points }}</h5>
        <h5>Account Type : {{ Auth::user()->accountType }}</h5>
        <a href="/">Home</a><br/>
        Taskminator :
        <div style="border: 1px solid red">
            Name : {{ $tskmntr->fullName }}<br/>
            Address : {{ $tskmntr->address }}<br/>
            Barangay/City : {{ Barangay::where('bgycode', $tskmntr->barangay)->pluck('bgyname') }}, {{ City::where('citycode', $tskmntr->city)->pluck('cityname') }}<br/>
            <hr/>
            <h4 style="margin: 0;">Contact Details</h4>
            @foreach(Contact::where('user_id', $tskmntr->id)->get() as $contact)
                @if($contact->ctype == 'email')
                    Email : {{ $contact->content }}<br/>
                @elseif($contact->ctype == 'facebook')
                    Facebook : <a href="{{ $contact->content }}">{{ $contact->content }}</a><br/>
                @elseif($contact->ctype == 'linkedin')
                    LinkedIn : {{ $contact->content }}<br/>
                @elseif($contact->ctype == 'mobileNum')
                    Mobile # : {{ $contact->content }}<br/>
                @endif
            @endforeach
        </div>
        <br/>
        Select a task for {{ $tskmntr->fullName }} (Direct Hiring Tasks)
        @foreach($tasks as $task)
            <div style="border: 1px solid #333333; margin-bottom: 0.4em;">
                <h4 style="color: blue; margin-bottom: 0; margin-top: 0.3em">{{ $task->name }}</h4>
                <span style="color: grey; font-size: 1em">Description : {{ $task->description }}</span><br/>
                <span style="color: grey; font-size: 1em">Category : {{ TaskCategory::where('categorycode', $task->taskCategory)->pluck('categoryname') }}</span><br/>
                <span style="color: grey; font-size: 1em">Skill : {{ TaskItem::join('taskcategory', 'taskcategory.categorycode', '=', 'taskitems.item_categorycode')->where('taskitems.itemcode', $task->taskType)->pluck('itemname') }}</span><br/>
                <span style="color: grey; font-size: 1em">Salary : {{ $task->salary }}</span><br/>
                <span style="color: grey; font-size: 1em">Deadline : {{ $task->deadline }}</span><br/>
                <span style="color: grey; font-size: 1em">Created@ : {{ $task->created_at }}</span><br/>
                <span style="color: grey; font-size: 1em">Location : {{ City::where('citycode', $task->city)->pluck('cityname') }}, {{ Barangay::where('bgycode', $task->barangay)->pluck('bgyname') }}</span><br/>
                <span style="color: grey; font-size: 1em">Mode of payment : {{ $task->modeOfPayment }}</span><br/>
                <span style="color: grey; font-size: 1em">Hiring Type : {{ $task->hiringType}}</span><br/>
                <span style="color: grey; font-size: 1em">
                    Working Time :
                    @if($task->workTime == 'FTIME')
                        Full Time
                    @else
                        Part Time
                    @endif
                </span><br/>
                @if(TaskminatorHasOffer::where('task_id', $task->id)->where('taskminator_id', $tskmntr->id)->count() == 1)
                    <span style="color: green">You have already offered this taskminator for this task. Click <a target="_tab" href="/taskDetails/{{$task->id}}">here</a> to view details.</span>
                @else
                    <a href="/doDirectHire_{{ $tskmntr->id }}.{{ $task->id }}">Offer {{ $tskmntr->fullName }} for this task.</a>
                @endif
            </div>
        @endforeach
    </body>
</html>