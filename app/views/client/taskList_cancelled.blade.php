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
@stop

@section('user-name')
{{ Auth::user()->fullName }}
@stop

@section('contents')
<div class="page-title">
    <h1>
        Cancelled Task List
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
    @if(Session::has('errorMsg'))
        <div class="col-md-9">
            <div class="alert alert-danger">
                {{ @Session::has('errorMsg') }}
            </div>
        </div>
    @endif
    @if(Session::has('successMsg'))
        <div class="col-md-9">
            <div class="alert alert-success">
                {{ @Session::has('successMsg') }}
            </div>
        </div>
    @endif
    @if($tasks->count() == 0)
        <div class="col-md-9">
            <div class="alert alert-danger">You have no cancelled tasks</div>
        </div>
    @endif
    @foreach($tasks as $task)
    <div class="col-md-9">
        <div class="widget-container weather">
            <div class="widget-content padded">
                <div class="heading">
                    <h4 style="margin-bottom: 0; margin-top: 0.3em;"><i class="glyphicon glyphicon-unchecked"></i> <a href="/taskDetails/{{ $task->id }}" class="taskname">{{ $task->name }}</a></h4>
                </div>
                <div class="widget-content clearfix" style="padding: 0px 40px;">
                    <span style="font-size: 1.1em"><strong style="text-transform: uppercase">Description :</strong> &nbsp;&nbsp;{{ $task->description }}</span><br/>
                    <span style="font-size: 1.1em"><strong style="text-transform: uppercase">Category :</strong> &nbsp;&nbsp;{{ TaskCategory::where('categorycode', $task->taskCategory)->pluck('categoryname') }}</span><br/>
                    <span style="font-size: 1.1em"><strong style="text-transform: uppercase">Hiring Type :</strong> &nbsp;&nbsp;{{ $task->hiringType }}</span><br/>
                    <span style="font-size: 1.1em"><strong style="text-transform: uppercase">Cancelled at :</strong> &nbsp;&nbsp;{{ $task->cancelled_at }}</span><br/>
                </div>
            </div>
        </div><br/>
    </div>
    @endforeach
</div>
@stop