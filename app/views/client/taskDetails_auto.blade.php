@extends('layouts.main')

@section('head')
    Task Details
@stop

@section('user-name')
    {{ Auth::user()->firstName }} {{ Auth::user()->lastName }}
@stop

@section('contents')
    <div class="page-title">
        <h1>
            {{ $task->name }}
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
    </div>
    <div class="col-sm-12">
            <div class="widget-container fluid-height padded">
                <div class="row padded">
                    <div class="col-sm-6">
                        <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Description</span>
                         : <span style="margin-left: 5px">{{ $task->description }}</span><br/> 
                         <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Category</span>
                         : <span style="margin-left: 5px">{{ TaskCategory::where('categorycode', $task->taskCategory)->pluck('categoryname') }}</span><br/>
                         <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Skill</span>
                         : <span style="margin-left: 5px">{{ TaskItem::join('taskcategory', 'taskcategory.categorycode', '=', 'taskitems.item_categorycode')->where('taskitems.itemcode', $task->taskType)->pluck('itemname') }}</span><br/>
                        <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Salary</span>
                         : <span style="margin-left: 5px">{{ $task->salary }}</span><br/>
                         <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Deadline</span>
                         : <span style="margin-left: 5px">{{ $task->deadline }}</span><br/>
                    </div>
                    <div class="col-sm-6">
                        <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Date Created</span>
                         : <span style="margin-left: 5px">{{ $task->created_at }}</span><br/>
                         <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Location</span>
                         : <span style="margin-left: 5px">{{ City::where('citycode', $task->city)->pluck('cityname') }}, {{ Barangay::where('bgycode', $task->barangay)->pluck('bgyname') }}</span><br/>
                        <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Mode of Payment</span>
                         : <span style="margin-left: 5px">{{ $task->modeOfPayment }}</span><br/>
                         <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Hiring Type</span>
                         : <span style="margin-left: 5px">{{ $task->hiringType}}</span><br/>
                         <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Working Time</span>
                         : <span style="margin-left: 5px">
                            @if($task->workTime == 'FTIME')
                                Full Time
                            @else
                                Part Time
                            @endif
                        </span><br/>
                    </div>
                </div>
                <div class="row padded" style="margin-top: 0">
                    <div class="col-sm-12">
                        @if($hired->count() != 0)
                            <hr/>
                            @foreach($hired as $h)
                                @foreach(User::where('id', $h->taskminator_id)->get() as $user)
                                    <div style="border: 1px solid #333333; margin-bottom: 0.4em; padding: 0.2em;">
                                        sds
                                    </div>
                                @endforeach
                            @endforeach
                        @endif
                        @if(TaskHasTaskminator::where('task_id', $task->id)->count() == 0 && TaskHasBidder::where('task_id', $task->id)->count() == 0)
                            <hr/>
                            <a href="/editTask/{{ $task->id }}" class="btn btn-primary">Edit Task Details</a><br/>
                            <a href="/deleteTask/{{ $task->id }}" class="btn btn-danger">Cancel Task</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop