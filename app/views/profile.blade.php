@extends('layouts.main')

@section('head')
    {{ $user->fullName }}
@stop

@section('user-name')
    {{ Auth::user()->firstName }} {{ Auth::user()->lastName }}
@stop

@section('contents')
	<div class="page-title">
<!--        <h1>-->
<!--            Taskminator Profile-->
<!--        </h1>-->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <ul class="breadcrumb">
                <li>
                    <a href="/"><i class="icon-home"></i></a>
                </li>
                <li class="active">
                    {{ $user->username }}'s Profile
                </li>
            </ul>
        </div>
        <div class="col-sm-12">
            <div class="widget-container fluid-height">
                <div class="widget-content padded row" style="padding-bottom: 30px">
                	<div class="col-sm-3" style="text-align: center; align-content: center; align-items: center;">

                        @if($user->profilePic)
                            <img src="{{$user->profilePic}}" width="90%" style="border-radius: 0.6em; box-shadow: 0 0 10px 1px #7F8C8D;" />
                        @else
                            <img src="/images/default_profile_pic.png" width="90%" style="border-radius: 0.6em; box-shadow: 0 0 10px 1px #7F8C8D;" />
                        @endif
	                	<h3 style="margin-top: 1em;">{{ $user->username }}</h3>
	                </div>
	                <div class="col-sm-9">
                        <div class="heading">
                            <i class="glyphicon glyphicon-book"></i>Educational Background
                        </div>
                        <div style="padding: 0 12px;">
                            {{ $user->educationalBackground }}
                        </div>
                        <hr/>
                        <div class="heading">
                            <i class="glyphicon glyphicon-list-alt"></i>Services Offered
                        </div>
                        <div style="padding: 0 12px;">
                            {{ $user->servicesOffered }}
                        </div>
                        <hr/>
                        <div class="heading">
                            <i class="glyphicon glyphicon-star"></i>Skills Information
                        </div>
                        <div style="padding: 0 12px;">
                            @foreach(User::getSkills($user->id) as $skill)
                            <span style="background-color: #BDC3C7; color: white; padding: 0.3em; border-radius: 0.2em; font-size: 0.9em;">{{ $skill->itemname }}</span>
                            @endforeach
                        </div>
                        <hr/>
	                	<div class="heading">
	                        <i class="glyphicon glyphicon-map-marker"></i>Address Details
	                    </div>
	                    <div style="padding: 0 12px;">
							<span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">City and Barangay</span>
							 :
							<span style="margin-left: 5px">{{ City::where('citycode', $user->city)->pluck('cityname') }}, {{ Barangay::where('bgycode', $user->barangay)->pluck('bgyname') }}</span><br/>
							<span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Address</span>
							 :
							<span style="margin-left: 5px">{{ $user->address }}</span><br/>
						</div>
                        <hr/>
                        <div class="heading">
                            <i class="glyphicon glyphicon-euro"></i>Rates
                        </div>
                        <div style="padding: 0 12px;">
                            From P{{ $user->minRate }} to P{{ $user->maxRate }}
                        </div>
                        <?php $directTasks = Task::where('user_id', Auth::user()->id)->where('hiringType', 'DIRECT')->where('status', 'OPEN'); ?>
                        @if($directTasks->count() > 0)
                            @foreach($directTasks->get() as $dt)
                                @if(TaskminatorHasOffer::where('task_id', $dt->id)->where('taskminator_id', $user->id)->where('client_id', Auth::user()->id)->count() > 0)
                                    <hr/>
                                    <div class="alert alert-success">
                                        <span style="color: green;">You have offered this taskminator a task : <span style="font-weight: bolder;">{{ $dt->name }}</span>. Click <a target="_tab" href="/taskDetails/{{$dt->id}}">here</a> for task details</span><br/>
                                    </div>
                                @else
                                    <hr/>
                                    <div class="alert alert-danger">
                                        <a href="/directHire_{{ $user->id }}">Offer this taskminator a Direct Task</a><br/>
                                        <?php break; ?>
                                    </div>
                                @endif
                            @endforeach
                        @endif
					<div>
                </div>
            </div>
        </div>
    </div>
@stop