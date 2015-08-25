@extends('layouts.main')

@section('head')
    Automatic Search for Taskminators
@stop

@section('user-name')
    {{ Auth::user()->firstName }} {{ Auth::user()->lastName }}
@stop

@section('contents')
    <div class="page-title">
        <h1>
            Edit Profile
        </h1>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <ul class="breadcrumb">
                <li>
                    <a href="/"><i class="icon-home"></i></a>
                </li>
                <li class="active">
                    Autosearch
                </li>
            </ul>
        </div>
        <div class="col-sm-4">
            <div class="widget-container fluid-height">
                <div class="widget-content">
                    <div class="panel-group" id="accordion">
                        <form method="POST" action="/tskmntr/doTaskSearch" id="searchForm">
                            <div class="panel">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <a class="accordion-toggle" data-parent="#accordion" data-toggle="collapse" href="#collapseOne">
                                        <div class="caret pull-right"></div>
                                        Task Details</a>
                                    </div>
                                </div>
                                <div class="panel-collapse collapse in" id="collapseOne">
                                    <div class="panel-body">
                                        <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Name</span>
                                         : 
                                        <span style="margin-left: 5px"><a target="_tab" href="/taskDetails/{{$task->id}}">{{ $task->name }}</a></span><br/>
                                        <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Description</span>
                                         : 
                                        <span style="margin-left: 5px">{{ $task->description }}</span><br/>
                                        <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Skill Category</span>
                                         : 
                                        <span style="margin-left: 5px">{{ TaskCategory::where('categorycode', $task->taskCategory)->pluck('categoryname') }}</span><br/>
                                        <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Skill</span>
                                         : 
                                        <span style="margin-left: 5px">{{ TaskItem::where('itemcode', $task->taskType)->pluck('itemname') }}</span><br/>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="heading">
                <i class="glyphicon glyphicon-user"></i> Users with the Same Skills
            </div>
            @foreach($users as $user)
                <div class="widget-container fluid-height padded">
                    <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Name</span>
                     : <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;"><a target="_tab" href="/profile/{{$user->id}}">{{ $user->fullName }}</a></span><br/>
                    <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Address</span>
                     : <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">{{ $user->address }}</span><br/>
                @if(TaskminatorHasOffer::where('taskminator_id', $user->id)->where('task_id', $task->id)->count() > 0)
                    <span style="color: green;"> This task has been already offered to this taskminator. Click <a target="_tab" href="/taskDetails/{{$task->id}}">here</a> for more details. </span>
                @else
                    <a href="/automaticOffer/{{$task->id}}={{$user->id}}" class="btn btn-primary">Offer {{ $user->fullName }} for this task.</a>
                @endif
                </div>
            @endforeach
        </div>
    </div>
@stop