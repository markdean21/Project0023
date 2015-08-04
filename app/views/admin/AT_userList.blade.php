@extends('layouts.main')

@section('head')
    Audit Trail
@stop

@section('user-name')
    {{ Auth::user()->fullName }}
@stop

@section('contents')
    <div class="page-title">
        <h1>
            Audit Trail
        </h1>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <ul class="breadcrumb">
                <li>
                    <a href="/"><i class="icon-home"></i></a>
                </li>
                <li class="active">
                    Audit Trail
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9">
            @foreach($users as $user)
            <div class="widget-container" style="min-height: 100px; padding-bottom: 5px;">
                <div class="widget-content padded">
                        <div style="padding: 0.4em; margin: 0.4em; background-color: white;">
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Name</span>
                             : <span style="margin-left: 5px"><a target="_tab" href="/viewUserProfile/{{$user->id}}">{{ $user->fullName }}</a></span><br/>
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Account Status</span>
                             : <span style="margin-left: 5px">{{ $user->status }}</span><br/><br/>
                            <a href="/userAuditTrail_{{$user->id}}" class="btn btn-info">View User Trails</a>
                        </div>
                </div>
            </div><br/>
            @endforeach
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
    {{ $users->links() }}
@stop