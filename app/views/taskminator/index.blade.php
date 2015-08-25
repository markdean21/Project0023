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
    {{ Auth::user()->firstName }} {{ Auth::user()->lastName }}
@stop

@section('contents')
    <div class="container-fluid main-content">
        <!-- Statistics -->
        <div class="row">
            <div class="col-lg-12">
                <div class="widget-container stats-container">
                    <div class="col-md-3">
                        <div class="number">
                            <div class="icon globe"></div>
                            {{ $bidCount }}
<!--                            86<small>%</small>-->
                        </div>
                        <div class="text">
                            <a href="/tskmntr_taskBids">Bids</a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="number">
                            <div class="icon visitors"></div>
                            {{ $offerCount }}
<!--                            613-->
                        </div>
                        <div class="text">
                            <a href="/tskmntr_taskOffers">Offers</a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="number">
                            <div class="icon money"></div>
                            {{ $ongoingCount }}
<!--                            <small>$</small>924-->
                        </div>
                        <div class="text">
                            <a href="/tskmntr_onGoing">On going</a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="number">
                            <div class="icon money"></div>
                            {{ $completedCount }}
<!--                            <small>$</small>924-->
                        </div>
                        <div class="text">
                            <a href="/tskmntr_completed">Completed</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="widget-container weather">
                <div class="widget-content padded">
                    @if(Auth::user()->status == 'PRE_ACTIVATED')
                        @if(Document::where('user_id', Auth::user()->id)->count() != 0 && Photo::where('user_id', Auth::user()->id)->count() != 0)
                            <div class="heading">
                                <i class="icon-bar-chart"></i>Your profile is being reviewed by our staff.
                            </div>
                            <div class="widget-content clearfix" style="padding: 0px 30px;">
                                After your profile has been activated, you can start looking for tasks!<br/>
                                This could take 24 hours or less.
                            </div>
                        @else
                            <div class="heading">
                                <i class="icon-bar-chart"></i>You're one step closer to taking jobs!
                            </div>
                            <div class="widget-content clearfix" style="padding: 0px 30px;">
                                You just need to upload:
                                <ul>
                                <li>1 old document with complete name and address (i.e Transcript of record, birth certificate, etc. Accepted files are .doc, .pdf and .docx); and, </li>
                                <li>at least 2 (Two) Key Skills Certification (Accepts .jpg, .png and .jpeg file extensions only)</li>
                                </ul>
                                Just click <a href="/editProfile">here!</a>
                            </div>
                        @endif
                    @else
                        <div class="heading">
                            <i class="icon-bar-chart"></i>You can now search for tasks!
                        </div>
                        <div class="widget-content clearfix" style="padding: 0px 30px;">
                            <a href="/tskmntr/taskSearch" class="btn btn-magenta btn-blk">Search for a task</a><br/>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="widget-container small">
                @if(Auth::user()->profilePic == null)
                    <div class="heading">
                        <i class="icon-signal"></i>Please upload a profile picture<i class="icon-list pull-right"></i><i class="icon-refresh pull-right"></i>
                    </div>
                    <div class="widget-content padded">
                        {{ Form::open(array('url' => '/uploadProfilePic', 'id' => 'uploadProfilePicForm', 'files' => 'true')) }}
                            <input type="file" name="profilePic" accept="image/*" class="form-control" required="required"/><br/>
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