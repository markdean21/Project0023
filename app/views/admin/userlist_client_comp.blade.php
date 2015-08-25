@extends('layouts.main')

@section('head')
    Company Clients
@stop

@section('head-contents')
<script>
    $(document).ready(function(){
        $('#searchBtn').click(function(){
            var searchBy = 0,
                searchWord = 0;
            if($('#searchBy').val() != ''){
                searchBy = $('#searchBy').val()
            }

            if($('#searchWord').val() != ''){
                searchWord = $('#searchWord').val()
            }

            location.href = '/userListClientComp=search='+searchBy+'='+searchWord;
        });

        $('#searchBy').change(function(){
            if($(this).val() == '0'){
                $('#searchWord').prop('disabled', true);
            }else{
                $('#searchWord').prop('disabled', false);
            }
        })

        if($('#searchBy').val() == '0'){
            $('#searchWord').prop('disabled', true);
        }
    });
</script>
@stop

@section('user-name')
    {{ Auth::user()->fullName }}
@stop

@section('contents')
    <div class="page-title">
        <h1>
            User List : Client (Company)
        </h1>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <ul class="breadcrumb">
                <li>
                    <a href="/"><i class="icon-home"></i></a>
                </li>
                <li class="active">
                    User List
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9">
            <div class="well selected-filters">
<!--                <form method="POST" action="/userListClientComp=search">-->
                    <div class="row">
                        <div class="col-md-3">
                            <select name="searchBy" class="form-control" id="searchBy">
                                <option value="0">Display All</option>
                                <option value="fullName" <?php if(@$searchBy == 'fullName'){ echo('selected'); } ?>>Name</option>
                                <option value="username" <?php if(@$searchBy == 'username'){ echo('selected'); } ?>>Username</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input value="<?php if(@$searchWord){ echo($searchWord); } ?>" type="text" name="searchWord" id="searchWord" placeholder="search keyword" class="form-control"/>
                        </div>
                        <div class="col-md-3">
                            <button id="searchBtn" type="submit" class="btn btn-block btn-primary" style="margin: 0">Search</button>
                        </div>
                    </div>
<!--                </form>-->
            </div>
            @if($users->count() == 0)
                <div class="well selected-filters" style="text-align: center">
                    <font style="color: red">No data available.</font>
                </div>
            @endif
            @foreach($users as $user)
                <div class="widget-container" style="min-height: 150px; padding-bottom: 5px;">
                    <div class="widget-content padded">
                        <div>
                            <h3><a href="/viewUserProfile/{{ $user->id }}">{{ $user->fullName }}</a></h3>
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Username</span>
                             : <span style="margin-left: 5px">{{ $user->username }}</span><br/>
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Status</span>
                             : <span style="margin-left: 5px">{{ $user->status }}</span><br/>
                            @if($user->status != 'PRE_ACTIVATED')
                                <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Open Tasks</span>
                                 : <span style="margin-left: 5px">{{ Task::where('user_id', $user->id)->where('status', 'OPEN')->count() }}</span><br/>
                                <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Ongoing Tasks</span>
                                 : <span style="margin-left: 5px">{{ Task::where('user_id', $user->id)->where('status', 'ONGOING')->count() }}</span><br/>
                                <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Accomplished Tasks</span>
                                 : <span style="margin-left: 5px">{{ Task::where('user_id', $user->id)->where('status', 'CLOSED')->count() }}</span><br/>
                                <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Cancelled Tasks</span>
                                 : <span style="margin-left: 5px">{{ Task::where('user_id', $user->id)->where('status', 'CANCELLED')->count() }}</span><br/>
                                <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Total Tasks Posted</span>
                                 : <span style="margin-left: 5px">{{ Task::where('user_id', $user->id)->count() }}</span><br/><br/>
                            @else
                            <span style="color: red; margin-right: 5px;">Please check credentials of this user before fully activating their account.</span>
                            @endif
                            <hr style="margin: 0;"/>
                            @if($user->status == 'PRE_ACTIVATED')
                                <a href="/adminActivate/{{$user->id}}" class="btn btn-info">Fully Activate Account</a>
                                <a href="/adminDeactivate/{{$user->id}}" class="btn btn-danger">Deactivate Account</a><br/>
                            @elseif($user->status == 'ACTIVATED')
                                <a href="/adminDeactivate/{{$user->id}}" class="btn btn-danger">Deactivate Account</a><br/>
                            @elseif($user->status == 'DEACTIVATED')
                                <a href="/adminActivate/{{$user->id}}" class="btn btn-success">Activate Account</a><br/>
                            @elseif($user->status == 'SELF_DEACTIVATED')
                                <a href="/adminActivate/{{$user->id}}" class="btn btn-success">Activate Account</a><br/>
                            @elseif($user->status == 'ADMIN_DEACTIVATED')
                                <a href="/adminActivate/{{$user->id}}" class="btn btn-success">Activate Account</a><br/>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
            <center>{{ $users->links() }}</center>
        </div>
        <div class="col-md-3">
            <div class="widget-container">
                <div class="widget-content">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <a class="accordion-toggle">
                                User Account List</a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <i class="glyphicon glyphicon-chevron-right"></i> &nbsp; <a href="/userListClientIndi" class="sidemenu">Client - Individuals</a><br>
                        <i class="glyphicon glyphicon-chevron-right"></i> &nbsp; <a href="/userListClientComp" class="sidemenu">Client - Companies</a><br>
                        <i class="glyphicon glyphicon-chevron-right"></i> &nbsp; <a href="/" class="sidemenu">Taskminators</a><br>
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
@stop