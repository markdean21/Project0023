@extends('layouts.main')

@section('head')
    Edit Contact Information
@stop

@section('head-contents')
        {{ HTML::script('js/jquery-1.11.0.min.js') }}
        {{ HTML::script('js/taskminator.js') }}
@stop

@section('user-name')
    {{ Auth::user()->firstName }} {{ Auth::user()->lastName }}
@stop

@section('contents')
    <div class="page-title">
        <h1>
            Enter Pin Code
        </h1>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <ul class="breadcrumb">
                <li>
                    <a href="/"><i class="icon-home"></i></a>
                </li>
                <li>
                    <a href="/editProfile">Edit Profile</a>
                </li>
                <li class="active">
                    Verify Mobile Number / Enter Pin Code
                </li>
            </ul>
        </div>

        @if(Session::has('errorMsg'))
            <div class="col-sm-12">
                <div class="alert alert-danger">
                    {{ @Session::has('errorMsg') }}
                </div>
            </div>
        @endif
        @if(Session::has('successMsg'))
            <div class="col-sm-12">
                <div class="alert alert-success">
                    {{ @Session::has('successMsg') }}
                </div>
            </div>
        @endif

        <div class="col-md-8">
            <div class="widget-container" style="min-height: 150px; padding-bottom: 5px; padding-top: 20px;">
                <div class="widget-content padded">
                   <!-- <form method="POST" action="/doVerifyMobileNumber" id="doVerifyMobileNumber"> -->
                        @foreach($contacts as $contact)

                            @if($contact->ctype == 'mobileNum')
                                    <div class="col-md-3">
                                        Mobile Number : 
                                    </div>
                                    <div class="col-md-9">
                                        <input type="hidden" name="{{$contact->ctype}}" value="{{$contact->content}}" class="form-control" />
                                        <p>{{$contact->content}}</p>
                                        <br/>
                                    </div>
                            @endif
                        @endforeach



                    {{ Form::open(array('url' => '/verifyPin')) }}
                        


                    
                            
                                    <div class="col-md-3">
                                        Pin Code : 
                                    </div>
                                    <div class="col-md-9">
                                     
                                     {{ Form::text('inputpin', Input::old('inputpin'), array('class' => 'form-control', 'placeholder' => 'Enter Pin Code Here')) }}
                                        <br/>
                                    </div>
                            
                       
                        <button type="submit" class="btn btn-primary" style="margin-eft: 10px;">Submit</button>
                   <!-- </form> -->
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <!--
        <div class="col-md-4">
            <div class="widget-container small">
                @if(Auth::user()->profilePic == null)
                    <div class="heading">
                        <i class="icon-signal"></i>Please upload a profile picture
                    </div>
                    <div class="widget-content padded">
                        {{ Form::open(array('url' => '/uploadProfilePic', 'id' => 'uploadProfilePicForm', 'files' => 'true')) }}
                            <input type="file" name="profilePic" accept="image/*" class="form-control" /><br/>
                            <button type="submit" class="btn btn-success">Upload</button>
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
    -->
    </div>
        <!--<span style="color: red; font-weight: bold">{{ @Session::get('errorMsg') }}</span>
        <span style="color: green; font-weight: bold">{{ @Session::get('successMsg') }}</span>
        <form method="POST" action="/doEditContactInfo" id="editContactInfo">
            @foreach($contacts as $contact)
                @if($contact->ctype == 'email')
                    Email : <input type="text" name="{{$contact->ctype}}" value="{{$contact->content}}" /><br/>
                @elseif($contact->ctype == 'facebook')
                    Facebook : <input type="text" name="{{$contact->ctype}}" value="{{$contact->content}}" /><br/>
                @elseif($contact->ctype == 'linkedin')
                    LinkedIn : <input type="text" name="{{$contact->ctype}}" value="{{$contact->content}}" /><br/>
                @elseif($contact->ctype == 'mobileNum')
                    Mobile Number : <input type="text" name="{{$contact->ctype}}" value="{{$contact->content}}" /><br/>
                @endif
            @endforeach
            <button type="submit">Edit</button>
        </form>-->
@stop