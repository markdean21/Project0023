@extends('layouts.main')

@section('head')
    List of tasks
@stop

@section('head-contents')
    <style>
        h5 {
            margin: 0;
        }
    </style>
    {{ HTML::script('js/jquery-1.11.0.min.js') }}
    <script>
//        $(document).ready(function(){
//            $('.cancel-task-btn').click(function(){
//                if(confirm("Are you sure you want to cancel this task?")){
//                    location.href = $(this).attr('data-href');
//                }
//            });
//        });
    </script>
@stop

@section('user-name')
    {{ Auth::user()->fullName }}
@stop

@section('contents')
    <div class="page-title">
        <h1>
            Ongoing Task List
        </h1>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <ul class="breadcrumb">
                <li>
                    <a href="/"><i class="icon-home"></i></a>
                </li>
                <li class="active">
                    Task List
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 pull-right">
            <div class="widget-container small">
                <div class="widget-content">
                    <div class="panel" style="  background: rgb(249, 249, 180); border-bottom: solid rgb(234, 234, 145) 1px; margin-bottom: 0">
                        <div class="panel-body">
                            <h3 style="text-align: center; margin-bottom: 0px;">Points Left: {{ Auth::user()->points }}</h3>
                        </div>
                    </div>
                    <div class="panel">
                        <div class="panel-body">
                            <i class="glyphicon glyphicon-chevron-right"></i> &nbsp; <a href="/createTask" class="sidemenu">Create Tasks</a><br/>
                            <i class="glyphicon glyphicon-chevron-right"></i> &nbsp; <a href="/tasks" class="sidemenu">Ongoing Tasks</a><br/>
                            <i class="glyphicon glyphicon-chevron-right"></i> &nbsp; <a href="/cancelledTasks" class="sidemenu">Cancelled Tasks</a><br/>
                            <i class="glyphicon glyphicon-chevron-right"></i> &nbsp; <a href="/accomplishedTasks" class="sidemenu">Accomplished Tasks</a><br/>
                            <i class="glyphicon glyphicon-chevron-right"></i> &nbsp; <a href="/tskmntrSearch" class="sidemenu">Search for Taskminators</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9 pull-left">
            @if(@Session::has('errorMsg'))
                <div class="alert alert-danger">
                    <button class="close" data-dismiss="alert" type="button">&times;</button>{{ @Session::has('errorMsg') }}
                </div>
            @endif
            @if(@Session::has('successMsg'))
                <div class="alert alert-success">
                    <button class="close" data-dismiss="alert" type="button">&times;</button>{{ @Session::has('successMsg') }}
                </div>
            @endif
        </div>
        @if($tasks->count() == 0)
            <center><i>No currently ongoing tasks</i></center>
        @endif
        @foreach($tasks as $task)
            <div class="col-md-9">
                <div class="widget-container">
                    <div class="widget-content padded">
                        <div class="heading">
                            <h4 style="margin-bottom: 0; margin-top: 0.3em;"><i class="glyphicon glyphicon-unchecked checktask"></i> <a href="/taskDetails/{{ $task->id }}" class="taskname">{{ $task->name }}</a></h4>
                        </div>
                        <div class="widget-content clearfix" style="padding: 0px 40px;">
                            <span style="font-size: 1.1em"><strong style="text-transform: uppercase">Description :</strong> &nbsp;&nbsp;{{ $task->description }}</span><br/>
                            <span style="font-size: 1.1em"><strong style="text-transform: uppercase">Category :</strong> &nbsp;&nbsp;{{ TaskCategory::where('categorycode', $task->taskCategory)->pluck('categoryname') }}</span><br/>
                            <span style="font-size: 1.1em"><strong style="text-transform: uppercase">Hiring Type :</strong> &nbsp;&nbsp;{{ $task->hiringType }}</span><br/>
                            <hr/>
                            @if($task->status == 'ONGOING')
                                @foreach(User::join('task_has_taskminator', 'users.id', '=', 'task_has_taskminator.taskminator_id')->where('task_has_taskminator.task_id', $task->id)->get() as $tskmntr)
                                    Hired Taskminator : {{ $tskmntr->fullName }}<br/>
                                @endforeach
                            @elseif($task->status == 'OPEN')
                                @if($task->hiringType == 'BIDDING')
                                    <span style="color: grey; font-size: 1em">Bidders : {{ TaskHasBidder::where('task_id', $task->id)->count() }}</span><br/>
                                @elseif($task->hiringType == 'DIRECT')
                                    @if(TaskminatorHasOffer::where('task_id', $task->id)->count() == 0)
                                        <div class="alert alert-danger">
                                            <button class="close" data-dismiss="alert" type="button">×</button>No Taskminators has been offered for this Task.
                                        </div>
                                    @else
                                        Offered Taskminator(s) :<br/>
                                        @foreach(User::join('taskminator_has_offer', 'taskminator_has_offer.taskminator_id', '=', 'users.id')->where('taskminator_has_offer.task_id', $task->id)->select(['users.id', 'users.fullName'])->get() as $offeredTm)
                                            <a target="_tab" href="/profile/{{ $offeredTm->id }}">{{ $offeredTm->fullName }}</a><br/>
                                        @endforeach
                                    @endif
                                    <br/>
                                @elseif($task->hiringType == 'AUTOMATIC')
                                    @if(TaskminatorHasOffer::where('task_id', $task->id)->count() == 0)
                                        <div class="alert alert-danger">
                                            <button class="close" data-dismiss="alert" type="button">×</button>No Taskminators has been offered for this Task.
                                        </div>
                                    @else
                                        Offered Taskminator(s) :<br/>
                                        @foreach(User::join('taskminator_has_offer', 'taskminator_has_offer.taskminator_id', '=', 'users.id')->where('taskminator_has_offer.task_id', $task->id)->select(['users.id', 'users.fullName'])->get() as $offeredTm)
                                            <a target="_tab" href="/profile/{{ $offeredTm->id }}">{{ $offeredTm->fullName }}</a><br/>
                                        @endforeach
                                    @endif
                                    <br/>
                                @endif<br/>

                                @if(TaskHasTaskminator::where('task_id', $task->id)->count() == 0 && TaskHasBidder::where('task_id', $task->id)->count() == 0 && TaskminatorHasOffer::where('task_id', $task->id)->count() == 0)
                                    <div class="row">
                                        @if($task->hiringType == 'AUTOMATIC')
                                            <a href="/automaticSearch/{{$task->id}}" class="btn btn-info">Automatic search for a Taskminator</a>
                                        @elseif($task->hiringType == 'DIRECT')
                                            <a href="/tskmntrSearch" class="btn btn-primary">Look for a Taskminator</a>
                                        @elseif($task->hiringType == 'BIDDING')
                                        @endif
                                        <a href="/editTask/{{ $task->id }}" class="btn btn-warning">Edit Task Details</a>
                                        <a href="#" data-href="/deleteTask/{{ $task->id }}" class="btn btn-danger cancel-task-btn">Cancel Task</a>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div><br/>
            </div>
        @endforeach
    </div>
    <center>{{ $tasks->links() }}</center>
@stop