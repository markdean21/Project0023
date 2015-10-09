@extends('layouts.main')

@section('head')
    Edit your profile
@stop

@section('head-contents')
    <style>
        .thumbnail {
            border: 1px solid #BDC3C7;
            border-radius: 0.3em;
            cursor: pointer;
            position: relative;
            width: 80px;
            height: 80px;
            overflow: hidden;
            /*float: left;*/
            margin-right: 1em;
            margin-bottom: 0em;
            /*-moz-box-shadow:    3px 3px 5px 6px #ccc;*/
            /*-webkit-box-shadow: 3px 3px 5px 6px #ccc;*/
            /*box-shadow: 0 8px 6px -6px black;*/
        }
        .thumbnail img {
            display: inline;
            position: absolute;
            left: 50%;
            top: 50%;
            height: 100%;
            width: auto;
            /*-webkit-transform: translate(-50%,-50%);*/
            /*-ms-transform: translate(-50%,-50%);*/
            transform: translate(-50%,-50%);
        }
        .thumbnail img.portrait {
            width: 100%;
            height: auto;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('#profilePicDiv').hover(function(){
                $('#picNotice').fadeToggle('fast');
            })
        })
    </script>
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
                    Edit Profile
                </li>
            </ul>
        </div>
        @if(Session::has('errorMsg'))
        <div class="col-sm-12">
            <div class="alert alert-danger">
                {{ @Session::get('errorMsg') }}
            </div>
        </div>
        @endif
        @if(Session::has('successMsg'))
            <div class="col-sm-12">
                <div class="alert alert-success">
                    {{ @Session::get('successMsg') }}
                </div>
            </div>
        @endif


        @if($user->status == 'PRE_ACTIVATED')
        <div class="col-sm-12">
            <div class="alert alert-warning">
                @if(Document::where('user_id', $user->id)->count() == 0 && Photo::where('user_id', $user->id)->count() == 0)
                    <div>
                        {{ Form::open(array('url' => '/doUploadDocuments', 'id' => 'registrationForm-task', 'files' => 'true')) }}
                        <h3>Activate Your Account</h3>
                        upload 1 old document with complete name and address (i.e Transcript of record, birth certificate, etc. Accepted files are .doc, .pdf)
                        <input required="required" type="file" name="document" accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"/><br/>
                        2 (Two) Key Skills Certification (All image files are accepted)
                        <input type="file" name="keySkills[]" accept='image/*' multiple required="required"/><br/>
                        <button type="submit">Upload</button>
                        {{ Form::close() }}
                    </div>
                @else
                    <div>
                        Your profile is being reviewed by our staff.<br/>
                        After your profile has been activated, you can start looking for tasks!<br/>
                        This could take 24 hours or less.
                    </div>
                @endif
            </div>
        </div>
        @endif

        <div class="col-sm-12">
            <div class="widget-container fluid-height">
                <div class="widget-content padded row" style="padding-bottom: 30px">
                    <div class="col-sm-3" style="align-items: center; align-content: center; text-align: center;">
                        <h3>{{ $user->fullName }}</h3>
                        @if($user->profilePic == null)
                            <div style="border: 1px solid #333333; padding: 0.4em; margin-top: 0.8em;">
                                {{ Form::open(array('url' => '/uploadProfilePic', 'id' => 'uploadProfilePicForm', 'files' => 'true')) }}
                                Please upload a profile picture<br/>
                                <input type="file" name="profilePic" accept="image/*" required="required"/><br/>
                                <button type="submit">Upload</button>
                                {{ Form::close() }}
                            </div>
                        @else
                            <div style="width:100%; overflow:hidden;" id="profilePicDiv">
                                <a href="#" data-toggle="modal" data-target="#newProfilePic"><img src="public{{ Auth::user()->profilePic }}" class="portrait" style="width: 100%" /></a>
                            </div>
                            <span style="margin-top: 1em; border-radius: 0.3em; padding : 0.3em; color: #ECF0F1; display: none; background-color: #2C3E50;" id="picNotice">Click to change profile picture</span>
                        @endif
                    </div>
                    <div class="col-sm-9">
                        <div class="heading">
                            <i class="glyphicon glyphicon-map-marker"></i>Personal Information <button onclick="location.href='/editPersonalInfo'" class="btn btn-xs btn-default" style=" margin: 5px;">Edit</button>
                        </div>
                        <div style="padding: 0 12px;">
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">First Name</span>
                             :
                            <span style="margin-left: 5px">{{ $user->firstName }}</span><br/>
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Middle Name</span>
                             :
                            <span style="margin-left: 5px">{{ $user->midName }}</span><br/>
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Last Name</span>
                             :
                            <span style="margin-left: 5px">{{ $user->lastName }}</span><br/>
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">City</span>
                             :
                            <span style="margin-left: 5px">{{ City::where('citycode', $user->city)->pluck('cityname') }}</span><br/>
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Barangay</span>
                             :
                            <span style="margin-left: 5px">{{ Barangay::where('bgycode', $user->barangay)->pluck('bgyname') }}</span><br/>
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">Gender</span>
                             :
                            <span style="margin-left: 5px">{{ Auth::user()->gender }}</span><br/>
                        </div>
                        <hr/>
                        <div class="heading">
                            <i class="glyphicon glyphicon-phone-alt"></i>Contact Information <button class="btn btn-xs btn-default" onclick="location.href='/editContactInfo'" style=" margin: 5px;">Edit</button>
                        </div>
                        <div style="padding: 0 12px;">
                            @foreach(Contact::where('user_id', $user->id)->get() as $con)
                            <span style="text-transform: capitalize; color: rgb(72, 157, 179); margin-right: 5px;">
                                @if($con->ctype == "mobileNum") Mobile No.
                                @elseif($con->ctype == "businessNum") Business No.
                                @else {{ $con->ctype }} @endif
                            </span>
                             :
                            <span style="margin-left: 5px">{{ $con->content }}</span>
                            @if($con->ctype == "mobileNum")
                                @if(Contact::where('user_id',  Auth::user()->id)->pluck('pincode')!='verified')
                                    <button class="btn btn-xs btn-primary" onclick="location.href='/doVerifyMobileNumber'" style=" margin: 5px;">Verify!</button>
                                @else
                                    <span class="btn btn-xs btn-default" style=" margin: 5px;">Verified</span>
                                @endif
                            @endif
                            <br/>
                            @endforeach
                        </div>
                        <hr/>
                        <div class="heading">
                            <i class="glyphicon glyphicon-star"></i>Skills <button class="btn btn-xs btn-default" style=" margin: 5px;" onclick="location.href='/editSkillInfo'">Edit</button>
                        </div>
                        <div style="padding: 0 12px;">
                            @foreach(User::getSkills(Auth::user()->id) as $skill)
                                <span style="background-color: #BDC3C7; color: white; padding: 0.3em; border-radius: 0.2em; font-size: 0.9em;">{{ $skill->itemname }}</span>
                            @endforeach
                        </div>
                    <div>
                </div>
            </div>
        </div>
    </div>

<!--MODAL-->
{{ Form::open(array('url' => '/uploadProfilePic', 'id' => 'uploadProfilePicForm', 'files' => 'true')) }}
    <div class="modal fade" id="newProfilePic" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Upload new profile picture</h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin: 0;">
                        Please upload a profile picture<br/>
                        <input type="file" name="profilePic" accept="image/*" required="required"/><br/>
                        <button type="submit">Upload</button>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 0.8em;">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Upload</button>
                </div>
            </div>
        </div>
    </div>
{{ Form::close() }}
@stop