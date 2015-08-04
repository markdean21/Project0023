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
                        <i class="glyphicon glyphicon-map-marker"></i>Address Details
                    </div>
                    <div style="padding: 0 12px;">
                        <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">City and Barangay</span>
                        :
                        <span style="margin-left: 5px">{{ City::where('citycode', $user->city)->pluck('cityname') }}, {{ Barangay::where('bgycode', $user->barangay)->pluck('bgyname') }}</span><br/>
                    </div>
                    <hr/>
                    @if($user->businessDescription)
                    <div class="heading">
                        <i class="glyphicon glyphicon-map-marker"></i>Business Description
                    </div>
                    <div style="padding: 0 12px;">
                        {{ $user->businessDescription }}
                    </div>
                    <hr/>
                    @endif
                    @if($user->businessNature)
                        <div class="heading">
                            <i class="glyphicon glyphicon-map-marker"></i>Business Nature
                        </div>
                        <div style="padding: 0 12px;">
                            {{ $user->businessNature }}
                        </div>
                        <hr/>
                    @endif
                </div>
            </div>
        </div>
        @stop