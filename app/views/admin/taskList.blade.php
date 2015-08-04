@extends('layouts.main')

@section('head')
    {{ $pageName }}
@stop

@section('user-name')
    {{ Auth::user()->fullName }}
@stop

@section('head-contents')
    {{ HTML::script('js/jquery-1.11.0.min.js') }}
    <script>
        $(document).ready(function(){
            $('#searchBtn').click(function(){
                var searchWord = 0;
                if($('#searchWord').val() != ''){
                    searchWord = $('#searchWord').val();
                }

                location.href = '{{$formUrl}}='+$('#searchBy').val()+'='+searchWord+'='+$('#workTimeValue').val()+'='+$('#status').val();
            });

            if($('#searchBy').val() == 'name'){
                $('#searchWord').prop('disabled', false);
            }else{
                $('#searchWord').prop('disabled', true);
            }

            $('#searchBy').change(function(){
                if($(this).val() == 'name'){
                    $('#searchWord').prop('disabled', false);
                }else{
                    $('#searchWord').prop('disabled', true);
                }
            })
        });
    </script>
@stop

@section('contents')
    <div class="page-title">
        <h1>
            {{ $pageName }}
        </h1>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <ul class="breadcrumb">
                <li>
                    <a href="/"><i class="icon-home"></i></a>
                </li>
                <li class="active">
                    Bidding Tasks
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9">
            <div class="well selected-filters">
                    <div class="row">
                        <div class="col-md-2">
                            Search By:
                        </div>
                        <div class="col-md-3">
                            <select name="searchBy" id="searchBy" class="form-control">
                                <option value="0" <?php if(@$searchBy == '0'){ echo('selected'); } ?>>Display all tasks</option>
                                <option value="name" <?php if(@$searchBy == 'name'){ echo('selected'); } ?>>Task Name</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="workTimeValue" id="workTimeValue" class="form-control">
                                <option value="0" <?php if(@$workTimeValue == '0'){ echo('selected'); } ?>>Display all employment type</option>
                                <option value="PTIME" <?php if(@$workTimeValue == 'PTIME'){ echo('selected'); } ?>>Part Time</option>
                                <option value="FTIME" <?php if(@$workTimeValue == 'FTIME'){ echo('selected'); } ?>>Full Time</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" value="<?php if(@$searchWord){ echo($searchWord); } ?>" name="searchWord" id="searchWord" placeholder="search keyword" class="form-control"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            Status:
                        </div>
                        <div class="col-md-6">
                            <select name="status" id="status" class="form-control">
                                <option value="0" <?php if(@$status == '0'){ echo('selected'); } ?>>Display all status</option>
                                <option value="OPEN" <?php if(@$status == 'OPEN'){ echo('selected'); } ?>>Open</option>
                                <option value="ONGOING" <?php if(@$status == 'ONGOING'){ echo('selected'); } ?>>On Going</option>
                                <option value="COMPLETE" <?php if(@$status == 'COMPLETED'){ echo('selected'); } ?>>Complete</option>
                                <option value="CANCELLED" <?php if(@$status == 'CANCELLED'){ echo('selected'); } ?>>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" id="searchBtn" class="btn btn-block btn-primary">Search</button>
                        </div>
                    </div>
            </div>
            @if($tasks->count() == 0)
                <div class="well selected-filters" style="text-align: center">
                    <font style="color: red">No data available.</font>
                </div>
            @endif

            @foreach($tasks as $task)
                <div class="widget-container" style="min-height: 150px; padding-bottom: 5px;">
                    <div class="widget-content padded">
                        <div>
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Name</span>
                             : <span style="margin-left: 5px"><a target="_tab" href="/admin/taskDetails/{{$task->id}}">{{ $task->name }}</a></span><br/>
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">By</span>
                             : <span style="margin-left: 5px"><a target="_tab" href="/viewUserProfile/{{User::where('id', $task->id)->pluck('id')}}">{{ User::where('id', $task->id)->pluck('fullName') }}</a></span><br/>
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Work Time</span>
                             : <span style="margin-left: 5px">{{ $task->workTime }}</span><br/>
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Created at</span>
                             : <span style="margin-left: 5px">{{ $task->created_at }}</span><br/>
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Status</span>
                             : <span style="margin-left: 5px">{{ $task->status }}</span>
                        </div>
                    </div>
                </div><br/>
            @endforeach
            <center>{{ $tasks->links() }}</center>
        </div>
        <div class="col-md-3">
            <div class="widget-container">
                <div class="widget-content">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <a class="accordion-toggle">
                            Client</a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <i class="glyphicon glyphicon-chevron-right"></i> &nbsp; <a href="/userListClientIndi" class="sidemenu">Individuals</a><br>
                        <i class="glyphicon glyphicon-chevron-right"></i> &nbsp; <a href="/userListClientComp" class="sidemenu">Companies</a><br>
                    </div>
                    <div class="panel-heading">
                        <div class="panel-title">
                            <a class="accordion-toggle">
                            Pending Users</a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <i class="glyphicon glyphicon-chevron-right"></i> &nbsp; <a href="/pendingTskmntr" class="sidemenu">Taskminators</a><br>
                        <i class="glyphicon glyphicon-chevron-right"></i> &nbsp; <a href="/pendingClientIndi" class="sidemenu">Client (Individual)</a><br>
                        <i class="glyphicon glyphicon-chevron-right"></i> &nbsp; <a href="/pendingClientComp" class="sidemenu">Client (Company)</a>
                    </div>
                    <div class="panel-heading">
                        <div class="panel-title">
                            <a class="accordion-toggle">
                            Tasks</a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <i class="glyphicon glyphicon-chevron-right"></i> &nbsp; <a href="/taskListBidding" class="sidemenu">Bidding</a><br>
                        <i class="glyphicon glyphicon-chevron-right"></i> &nbsp; <a href="/taskListAuto" class="sidemenu">Automatic</a><br>
                        <i class="glyphicon glyphicon-chevron-right"></i> &nbsp; <a href="/taskListDirect" class="sidemenu">Direct</a>
                    </div>
                    <div class="panel-heading">
                        <div class="panel-title">
                            <a class="accordion-toggle">
                            Audit Trail</a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <i class="glyphicon glyphicon-chevron-right"></i> &nbsp; <a href="/AT_taskminator" class="sidemenu">Taskminators</a><br>
                        <i class="glyphicon glyphicon-chevron-right"></i> &nbsp; <a href="/AT_clientindi" class="sidemenu">Client (Individual)</a><br>
                        <i class="glyphicon glyphicon-chevron-right"></i> &nbsp; <a href="/AT_clientcomp" class="sidemenu">Client (Company)</a>
                    </div>
                    <div class="panel-heading">
                        <div class="panel-title">
                            <a class="accordion-toggle" href="/categoryAndSkills">
                            Category & Skills</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--<form method="POST" action="{{ $formUrl }}">
            Search by : <select name="searchBy" id="searchBy">
                <option value="0">Display All</option>
                <option value="name" <?php if(@$searchBy == 'name'){ echo('selected'); } ?>>Task Name</option>
                <option value="workTime" <?php if(@$searchBy == 'workTime'){ echo('selected'); } ?>>Work Time</option>
            </select>
            <select name="workTimeValue" id="workTimeValue" disabled>
                <option value="PTIME" <?php if(@$workTimeValue == 'PTIME'){ echo('selected'); } ?>>Part Time</option>
                <option value="FTIME" <?php if(@$workTimeValue == 'FTIME'){ echo('selected'); } ?>>Full Time</option>
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
            <div style="border: 1px solid black; padding: 0.4em; margin-bottom: 0.4em">
                Name : <a target="_tab" href="/admin/taskDetails/{{$task->id}}">{{ $task->name }}</a><br/>
                By : <a target="_tab" href="/viewUserProfile/{{User::where('id', $task->id)->pluck('id')}}">{{ User::where('id', $task->id)->pluck('fullName') }}</a><br/>
                Work Time : {{ $task->workTime }}<br/>
                Created at : {{ $task->created_at }}<br/>
                Status : {{ $task->status }}
            </div>
        @endforeach-->
@stop