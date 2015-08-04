@extends('layouts.main')

@section('head')
    Task Details
@stop

@section('head-contents')
    <script src="/js/jquery-1.11.0.min.js" type="text/javascript"></script>
    <script>
        $(document).ready(function(){
            $('.cancel-task').click(function(){
                if(confirm('Are you sure you want to cancel your bid?')){
                    location.href = $(this).attr('data-href');
                }
            })
        })
    </script>
@stop

@section('user-name')
    {{ Auth::user()->firstName }} {{ Auth::user()->lastName }}
@stop

@section('contents')
    <div class="page-title">
        <h1>
            Task Details
        </h1>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <ul class="breadcrumb">
                <li>
                    <a href="/"><i class="icon-home"></i></a>
                </li>
                <li class="active">
                    Task Details
                </li>
            </ul>
        </div>
        <div class="col-md-8">
            <div class="widget-container" style="min-height: 150px; padding-bottom: 5px; padding-top: 20px;">
                <div class="widget-content padded">
                    <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">
                        Description
                    </span> :
                    <span style="margin-left: 5px">{{ $task->description }}</span><br/>
                    <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">
                        Category
                    </span> :
                    <span style="margin-left: 5px">{{ TaskCategory::where('categorycode', $task->taskCategory)->pluck('categoryname') }}</span><br/>
                    <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">
                        Skill
                    </span> :
                    <span style="margin-left: 5px">{{ TaskItem::join('taskcategory', 'taskcategory.categorycode', '=', 'taskitems.item_categorycode')->where('taskitems.itemcode', $task->taskType)->pluck('itemname') }}</span><br/>
                    <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">
                        Salary
                    </span> :
                    <span style="margin-left: 5px">{{ $task->salary }}</span><br/>
                    <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">
                        Deadline
                    </span> :
                    <span style="margin-left: 5px">{{ $task->deadline }}</span><br/>
                    <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">
                        Date Created
                    </span> :
                    <span style="margin-left: 5px">{{ $task->created_at }}</span><br/>
                    <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">
                        Location
                    </span> :
                    <span style="margin-left: 5px">{{ City::where('citycode', $task->city)->pluck('cityname') }}, {{ Barangay::where('bgycode', $task->barangay)->pluck('bgyname') }}</span><br/>
                    <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">
                        Working Time
                    </span> :
                    <span style="margin-left: 5px">
                        @if($task->workTime == 'FTIME')
                            Full Time
                        @else
                            Part Time
                        @endif
                    </span><br/>
                    <?php $client = User::where('id', $task->user_id)->first(); ?>
                    by <a href="/profile/{{ $client->id }}">{{ $client->fullName }}</a>
                    <hr/>
                    @if($task->status != 'COMPLETE' && $task->status != 'ONGOING')
                        @if($bid)
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">
                                Your bid
                            </span>
                             : <span style="margin-left: 5px">{{ $bid->proposedRate }}</span><br/>
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">
                                message
                            </span>
                             : <span style="margin-left: 5px">{{ $bid->message}}</span><br/><br/>
                            <a href="#" class="cancel-task btn btn-danger" data-href="/cancelBid/{{$task->id}}">Cancel Bid</a>
                        @else

                            <br/><a href="/bid{{$task->workTime}}/{{ $task->id }}" class="btn btn-success">Bid for task</a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="widget-container small">
                @if(Auth::user()->profilePic == null)
                    <div class="heading">
                        <i class="icon-signal"></i>Please upload a profile picture
                    </div>
                    <div class="widget-content padded">
                        {{ Form::open(array('url' => '/uploadProfilePic', 'id' => 'uploadProfilePicForm', 'files' => 'true')) }}
                            <input type="file" name="profilePic" accept="image/*" class="form-control" /><br/>
                            <button type="submit" class="btn btn-success">Upload</button>
                        {{ Form::close() }}
                    </div>
                @else
                    <div class="widget-content padded">
                        <div class="heading">
                            <i class="glyphicon glyphicon-user"></i>{{ Auth::user()->fullName }}
                        </div>
                        <div class="thumbnail">
                            <a href="/editProfile"><img src="/public/{{ Auth::user()->profilePic }}" class="portrait"/></a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!--<h2>Task Details</h2>
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
    <?php $client = User::where('id', $task->user_id)->first(); ?>
    by <a href="/profile/{{ $client->id }}">{{ $client->fullName }}</a>
    <hr/>
    @if($task->status != 'COMPLETE' && $task->status != 'ONGOING')
        @if($bid)
            Your bid : {{ $bid->proposedRate }}<br/>
            message : {{ $bid->message}}<br/>
            <a href="#" class="cancel-task" data-href="/cancelBid/{{$task->id}}">Cancel Bid</a>
        @else

            <br/><a href="/bid{{$task->workTime}}/{{ $task->id }}">Bid for task</a>
        @endif
    @endif-->
@stop