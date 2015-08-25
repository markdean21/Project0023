@extends('layouts.main')

@section('head')
    Edit Personal Information
@stop

@section('head-contents')
        {{ HTML::script('js/jquery-1.11.0.min.js') }}
        {{ HTML::script('js/taskminator.js') }}
        <script>
            $(document).ready(function(){
                locationChain($('#city-task'), $('#barangay-task'),$('#editPersonalInfo'), '/chainCity');
            });
        </script>
@stop

@section('user-name')
    {{ Auth::user()->firstName }} {{ Auth::user()->lastName }}
@stop

@section('contents')
    <div class="page-title">
        <h1>
            Edit Personal Information
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
                    Edit Personal Information
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
                    <form method="POST" action="/doEditPersonalInfo" id="editPersonalInfo">
                        <div class="col-md-3">
                            First Name : 
                        </div>
                        <div class="col-md-9">
                            <input type="text"  class="form-control"value="{{ $user->firstName }}" name="firstName" required="required"/><br/>
                        </div>
                        <div class="col-md-3">
                            Middle Name : 
                        </div>
                        <div class="col-md-9">
                            <input type="text"  class="form-control"value="{{ $user->midName }}" name="midName" required="required"/><br/>
                        </div>
                        <div class="col-md-3">
                            Last Name : 
                        </div>
                        <div class="col-md-9">
                            <input type="text"  class="form-control"value="{{ $user->lastName }}" name="lastName" required="required"/><br/>
                        </div>
                        <div class="col-md-3">
                            Address : 
                        </div>
                        <div class="col-md-9">
                            <input type="text"  class="form-control"value="{{ $user->address }}" name="address" required="required"/><br/>
                        </div>
                        <div class="col-md-3">
                            City : 
                        </div>
                        <div class="col-md-9">
                            <select name="city-task" id="city-task" class="form-control">
                                @foreach($cities as $city)
                                    <option value="{{$city->citycode}}" <?php if($city->citycode == $user->city){ echo('selected'); } ?> >{{ $city->cityname }}</option>
                                @endforeach
                            </select><br/>
                        </div>
                        <div class="col-md-3">
                            Barangay : 
                        </div>
                        <div class="col-md-9">
                            <select name="barangay-task" id="barangay-task" class="form-control">
                                @foreach($barangays as $bgy)
                                <option value="{{$bgy->bgycode}}" <?php if($bgy->bgycode == $user->barangay){ echo('selected'); } ?> >{{ $bgy->bgyname }}</option>
                                @endforeach
                            </select><br/>
                        </div>
                        <div class="col-md-3">
                            Gender : 
                        </div>
                        <div class="col-md-9">
                            <select name="gender" class="form-control">
                                <option value="FEMALE" <?php if($user->gender == 'FEMALE'){ echo('selected'); } ?>>Female</option>
                                <option value="MALE" <?php if($user->gender == 'MALE'){ echo('selected'); } ?>>Male</option>
                            </select><br/>
                        </div>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </form>
                </div>
            </div>
        </div>

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
    </div>
        
        <!--<h1>Edit Personal Information</h1>
        <span style="color: red; font-weight: bold">{{ @Session::get('errorMsg') }}</span>
        <span style="color: green; font-weight: bold">{{ @Session::get('successMsg') }}</span>
        <form method="POST" action="/doEditPersonalInfo" id="editPersonalInfo">
            First Name : <input type="text" value="{{ $user->firstName }}" name="firstName" required="required"/><br/>
            Middle Name : <input type="text" value="{{ $user->midName }}" name="midName" required="required"/><br/>
            Last Name : <input type="text" value="{{ $user->lastName }}" name="lastName" required="required"/><br/>
            Address : <input type="text" value="{{ $user->address }}" name="address" required="required"/><br/>
            City : <select name="city-task" id="city-task">
                @foreach($cities as $city)
                    <option value="{{$city->citycode}}" <?php if($city->citycode == $user->city){ echo('selected'); } ?> >{{ $city->cityname }}</option>
                @endforeach
            </select><br/>
            Barangay : <select name="barangay-task" id="barangay-task">
                @foreach($barangays as $bgy)
                <option value="{{$bgy->bgycode}}" <?php if($bgy->bgycode == $user->barangay){ echo('selected'); } ?> >{{ $bgy->bgyname }}</option>
                @endforeach
            </select><br/>
            Gender : <select name="gender">
                <option value="FEMALE" <?php if($user->gender == 'FEMALE'){ echo('selected'); } ?>>Female</option>
                <option value="MALE" <?php if($user->gender == 'MALE'){ echo('selected'); } ?>>Male</option>
            </select><br/>
            <button type="submit">Edit</button>
        </form>-->
@stop