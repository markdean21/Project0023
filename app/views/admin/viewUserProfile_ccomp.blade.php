@extends('layouts.main')

@section('head')
    {{ $user->companyName }}
@stop

@section('user-name')
    {{ Auth::user()->firstName }} {{ Auth::user()->lastName }}
@stop

@section('contents')
    <div class="row">
        <div class="col-lg-12">
            <ul class="breadcrumb">
                <li>
                    <a href="/"><i class="icon-home"></i></a>
                </li>
                <li class="active">
                    {{ $user->companyName }}'s Profile
                </li>
            </ul>
        </div>
        <div class="col-sm-12">
            <div class="widget-container fluid-height">
                <div class="widget-content padded row" style="padding-bottom: 30px">
                    <div class="col-sm-3" style="text-align: center; align-content: center; align-items: center;">
                        <br/>
                        @if($user->profilePic)
                            <img src="{{$user->profilePic}}" width="90%" style="border-radius: 0.6em; box-shadow: 0 0 10px 1px #7F8C8D;" />
                        @else
                            <img src="/images/default_profile_pic.png" width="90%" style="border-radius: 0.6em; box-shadow: 0 0 10px 1px #7F8C8D;" />
                        @endif
                        <h3 style="margin-top: 1em;">{{ $user->companyName }}</h3>
                        <br/>
                        @if($user->status == 'PRE_ACTIVATED')
                            <a href="/adminActivate/{{$user->id}}" class="btn btn-success">Fully Activate Account</a><br/>
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
                        <br/>
                        <a href="/viewUsersTasks/{{$user->id}}" class="btn btn-primary">View all tasks for this user</a>
                    </div>
                    <div class="col-sm-9">
                        <div class="heading">
                            <i class="glyphicon glyphicon-info-sign"></i>General Information
                        </div>
                        <div style="padding: 0 12px;">
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Address</span>
                             : {{$user->address}}<br/>
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Birthdate</span>
                             : {{$user->birthdate}}<br/>
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">City</span>
                             : {{$user->city}}<br/>
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Barangay</span>
                             : {{$user->barangay}}<br/>
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Gender</span>
                             : {{$user->gender}}<br/>
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Status</span>
                             : {{$user->status}}<br/>
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Account Created at</span>
                             : {{$user->created_at}}<br/>
                        </div>
                        <hr/>
                        <div class="heading">
                            <i class="glyphicon glyphicon-phone"></i>Contact Details
                        </div>
                        <div style="padding: 0 12px;">
                            @foreach(Contact::where('user_id', $user->id)->get() as $conts)
                                <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">{{ $conts->ctype }}</span>
                                 : {{ $conts->content }}<br/>
                            @endforeach
                        </div>
                        <hr/>
                        <div class="heading">
                            <i class="glyphicon glyphicon-phone"></i>Key Person
                        </div>
                        <div style="padding: 0 12px;">
                            @foreach($keyperson as $ks)
                                <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Name</span>
                                 : <span style="margin-left: 5px">{{ $ks->firstName }} {{ $ks->midName }} {{ $ks->lastName }}</span><br/>
                                <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Contact #</span>
                                 : <span style="margin-left: 5px">{{ $ks->contactNum }}</span><br/>
                                <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Email</span>
                                 : <span style="margin-left: 5px">{{ $ks->email }}</span><br/>
                                <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Position</span>
                                 : <span style="margin-left: 5px">{{ $ks->position}}</span><br/>
                                <br/>
                            @endforeach
                        </div>
                        <hr/>
                        <div class="col-sm-12">
                            <div class="col-sm-6">
                                <div class="heading">
                                    <i class="glyphicon glyphicon-folder-open"></i>Documents (Click to download)
                                </div>
                                <div style="padding: 0 35px;">
                                    @if($docs->count() == 0)
                                        <i>No data available.</i><br/>
                                    @else
                                        @foreach($docs as $doc)
                                            <i class="glyphicon glyphicon-download" style="top: 2px;"></i> &nbsp;&nbsp;<a href="{{ $doc->path }}">{{ $doc->docname }}</a><br/>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="heading">
                                    <i class="glyphicon glyphicon-folder-open"></i>Photos
                                </div>
                                <div style="padding: 0 35px;">
                                    @if($photos->count() == 0)
                                        <i>No data available.</i><br/>
                                    @else
                                        @foreach($miscDocs as $misc)
                                            <i class="glyphicon glyphicon-download" style="top: 2px;"></i> &nbsp;&nbsp;<a href="{{ $misc->path }}">{{ $misc->name }}</a><br/>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <br/><br/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--
        @if($user->status == 'PRE_ACTIVATED')
            <a href="/adminActivate/{{$user->id}}">Fully Activate Account</a><br/>
            <a href="/adminDeactivate/{{$user->id}}">Deactivate Account</a><br/>
        @elseif($user->status == 'ACTIVATED')
            <a href="/adminDeactivate/{{$user->id}}">Deactivate Account</a><br/>
        @elseif($user->status == 'DEACTIVATED')
            <a href="/adminActivate/{{$user->id}}">Activate Account</a><br/>
        @elseif($user->status == 'SELF_DEACTIVATED')
            <a href="/adminActivate/{{$user->id}}">Activate Account</a><br/>
        @elseif($user->status == 'ADMIN_DEACTIVATED')
            <a href="/adminActivate/{{$user->id}}">Activate Account</a><br/>
        @endif
        <a href="/viewUsersTasks/{{$user->id}}">View all tasks for this user</a>
        <h3>{{ $user->companyName }}</h3>
        <div style="border: 1px solid #333333; padding: 0.4em;">
            Address : {{$user->address}}<br/>
            Birthdate : {{$user->birthdate}}<br/>
            City : {{$user->city}}<br/>
            Barangay : {{$user->barangay}}<br/>
            Gender : {{$user->gender}}<br/>
            Status : {{$user->status}}<br/>
            Account Created at : {{$user->created_at}}<br/>
            <hr/>
            Contact Details :<br/>
            @foreach(Contact::where('user_id', $user->id)->get() as $conts)
                {{ $conts->ctype }} : {{ $conts->content }}<br/>
            @endforeach
            <hr/>
            Key Person :<br/>
            @foreach($keyperson as $ks)
                Name : {{ $ks->firstName }} {{ $ks->midName }} {{ $ks->lastName }}<br/>
                Contact # : {{ $ks->contactNum }}<br/>
                Email : {{ $ks->email }}<br/>
                Position : {{ $ks->position}}<br/>
            @endforeach
        </div>
        Documents (Click to download) :<br/>
        @if($docs->count() == 0)
            <i>No data available.</i><br/>
        @else
            @foreach($docs as $doc)
                <a href="{{ $doc->path }}">{{ $doc->docname }}</a><br/>
            @endforeach
        @endif
        <hr/>
        Photos : <br/>
        @if($photos->count() == 0)
            <i>No data available.</i><br/>
        @else
            @foreach($miscDocs as $misc)
                <a href="{{ $misc->path }}">{{ $misc->name }}</a><br/>
            @endforeach
        @endif
        <hr/>
    -->
@stop