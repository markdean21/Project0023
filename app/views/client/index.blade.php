@extends('layouts.main')

@section('head')
    Welcome to your dashboard!
@stop

@section('head-contents')
    <style>
        h5 {
            margin: 0;
        }
        .thumbnail {
            border: 1px solid #BDC3C7;
            border-radius: 0.3em;
            cursor: pointer;
            position: relative;
            width: 80px;
            height: 80px;
            overflow: hidden;
            /*float: left;*/
            margin-left: 20px;
            margin-top: 15px;
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
            $('#uploadProfilePicForm').submit(function(){
                $('#uploadBtn').empty().append('Uploading..');
            });
        })
    </script>
@stop

@section('user-name')
    {{ Auth::user()->fullName }}
@stop

@section('contents')
    <div class="row">
        <div class="col-md-8">
            <div class="widget-container weather">
                <div class="widget-content padded">
                    @if(Auth::user()->status == 'PRE_ACTIVATED')
                        <div class="heading">
                            <i class="icon-signal"></i>Your Profile
                        </div>
                        <div style="margin: 0 15px;">
                        Your profile is being reviewed by our staff.<br/>
                        After your profile has been activated, you can start looking for tasks!<br/>
                        This could take 24 hours or less.
                    </div>
                    @else
                        <div class="heading">
                            <i class="glyphicon glyphicon-info-sign"></i>Your info
                        </div>
                        <div class="widget-content clearfix" style="padding: 0px 30px;">
                            <h4>Points left : {{ Auth::user()->points }}</h4>
                            <h4>Account Type : {{ Auth::user()->accountType }}</h4>
                            <span style="color: red">
                                {{ @Session::get('errorMsg') }}
                            </span>
                            <br/>
                            <div class="row">
                                <a href="/createTask" class="btn btn-success">Create Task</a>
                                <a href="/tasks" class="btn btn-warning">Tasks</a>
                                <a href="/tskmntrSearch" class="btn btn-magenta">Search for Taskminators</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="widget-container small">
                @if(Auth::user()->profilePic == '')
                    <div class="heading">
                        <i class="icon-signal"></i>Please upload a profile picture<i class="icon-list pull-right"></i><i class="icon-refresh pull-right"></i>
                    </div>
                    <div class="widget-content padded">
                        {{ Form::open(array('url' => '/uploadProfilePic', 'id' => 'uploadProfilePicForm', 'files' => 'true')) }}
                            <input type="file" name="profilePic" accept="image/*" required="required"/><br/>
                            <button type="submit" class="btn btn-success" id="uploadBtn">Upload</button>
                        {{ Form::close() }}
                    </div>
                @else
                    <div class="widget-content padded">
                        <div class="heading">
                            <i class="glyphicon glyphicon-user"></i>{{ Auth::user()->fullName }}
                        </div>
                        <div class="thumbnail">
                            <a href="/editProfile"><img src="/public/{{ Auth::user()->profilePic }}" class="portrait"/></a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop