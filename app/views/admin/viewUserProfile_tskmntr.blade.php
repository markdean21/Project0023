@extends('layouts.main')

@section('head')
    {{ $user->firstName }} {{ $user->lastName }}
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
                    {{ $user->firstName }} {{ $user->lastName }}'s Profile
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
                        <h3 style="margin-top: 1em;">{{ $user->firstName }} {{ $user->midName }} {{ $user->lastName }}</h3>
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
                    </div>
                    <div class="col-sm-9">
                        <div class="heading">
                            <i class="glyphicon glyphicon-info-sign"></i>General Information
                        </div>
                        <div style="padding: 0 12px;">
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Address</span>
                             : <span style="margin-left: 5px">{{$user->address}}</span><br/>
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Birthdate</span>
                             : <span style="margin-left: 5px">{{$user->birthdate}}</span><br/>
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">City</span>
                             : <span style="margin-left: 5px">{{$user->city}}</span><br/>
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Barangay</span>
                             : <span style="margin-left: 5px">{{$user->barangay}}</span><br/>
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Gender</span>
                             : <span style="margin-left: 5px">{{$user->gender}}</span><br/>
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Status</span>
                             : <span style="margin-left: 5px">{{$user->status}}</span><br/>
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Account Created at</span>
                             : <span style="margin-left: 5px">{{$user->created_at}}</span><br/>
                        </div>
                        <hr/>
                        <div class="heading">
                            <i class="glyphicon glyphicon-phone"></i>Contact Details
                        </div>
                        <div style="padding: 0 12px;">
                            @foreach(Contact::where('user_id', $user->id)->get() as $conts)
                                <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">{{ $conts->ctype }}</span>
                                 : <span style="margin-left: 5px">{{ $conts->content }}</span><br/>
                            @endforeach
                        </div>
                        <hr/>
                        <div class="heading">
                            <i class="glyphicon glyphicon-wrench"></i>Skills
                        </div>
                        <div style="padding: 0 12px;">
                            @foreach($skills as $skill)
                                <span style="background-color: #BDC3C7; color: white; padding: 0.3em; border-radius: 0.2em; font-size: 0.9em;">{{ TaskItem::where('itemcode', $skill->taskitem_code)->pluck('itemname') }}</span>
                            @endforeach
                        </div>
                        <hr/>
                        <div class="heading">
                            <i class="glyphicon glyphicon-star"></i>Ratings
                        </div>
                        <div style="padding: 0 12px;">
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Number of ratings</span>
                             : <span style="margin-left: 5px">{{ $ratings }}</span><br/>
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Total Ratings</span>
                             : <span style="margin-left: 5px">{{ $starRatings }} stars</span><br/><br/>
                            <a href="/viewRatings={{$user->id}}" class="btn btn-primary">View Ratings</a>
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
                                    <i class="glyphicon glyphicon-folder-open"></i>Key Skill Certification
                                </div>
                                <div style="padding: 0 35px;">
                                    @if($keyskills->count() == 0)
                                        <i>No data available.</i><br/>
                                    @else
                                        @foreach($keyskills as $ks)
                                            <i class="glyphicon glyphicon-download" style="top: 2px;"></i> &nbsp;&nbsp;<a href="{{ $ks->path }}"><img src="{{ $ks->path }}" title="{{ $ks->imgname }}" width="100em;" style="border: 1px solid #333333; border-radius: 0.3em"/></a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <br/><br/>
                        </div>
                        <hr class="col-sm-12" style="margin-top: 70px" />
                        <div class="col-sm-12">
                            <div class="col-sm-6">
                                <div class="heading">
                                    <i class="glyphicon glyphicon-folder-open"></i>Misc. Documents
                                </div>
                                <div style="padding: 0 35px;">
                                    @if($miscDocs->count() == 0)
                                        <i>No data available.</i><br/>
                                    @else
                                        @foreach($miscDocs as $misc)
                                            <i class="glyphicon glyphicon-download" style="top: 2px;"></i> &nbsp;&nbsp;<a href="{{ $misc->path }}">{{ $misc->name }}</a><br/>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="heading">
                                    <i class="glyphicon glyphicon-folder-open"></i>Misc. Photos
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--
        <span style="color: green; font-weight: bold">{{ @Session::get('successMsg') }}</span>
        <span style="color: red; font-weight: bold">{{ @Session::get('errorMsg') }}</span>
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
        <h3>{{ $user->firstName }} {{ $user->midName }} {{ $user->lastName }}</h3>
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
            Skills :<br/>
            @foreach($skills as $skill)
                {{ TaskItem::where('itemcode', $skill->taskitem_code)->pluck('itemname') }}<br/>
            @endforeach
            <hr/>
            Number of ratings : {{ $ratings }}<br/>
            Total Ratings : {{ $starRatings }} stars<br/>
            <a href="/viewRatings={{$user->id}}">View Ratings</a>
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
        Key Skill Certification :<br/>
        @if($keyskills->count() == 0)
            <i>No data available.</i><br/>
        @else
            @foreach($keyskills as $ks)
            <a href="{{ $ks->path }}"><img src="{{ $ks->path }}" title="{{ $ks->imgname }}" width="100em;" style="border: 1px solid #333333; border-radius: 0.3em"/></a>
            @endforeach
        @endif
        <hr/>
        Misc. Documents : <br/>
        @if($miscDocs->count() == 0)
            <i>No data available.</i><br/>
        @else
            @foreach($miscDocs as $misc)
                <a href="{{ $misc->path }}">{{ $misc->name }}</a><br/>
            @endforeach
        @endif
        <hr/>
        Misc. Photos : <br/>
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