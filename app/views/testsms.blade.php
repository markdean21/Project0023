@extends('layouts.login')

@section('head')
    Test SMS
@stop

@section('head-contents')

@stop

@section('content')
    <!--<a href="/"><h1 style="margin: 40px 0px 30px 0px;">TASK<span style="color: rgb(102, 102, 102)">minator</span></h1></a>-->
   

    {{ Form::open(array('url' => '/verify')) }}
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="icon-envelope"></i></span>
                {{ Form::text('mobilenumber', Input::old('mobilenumber'), array('class' => 'form-control', 'placeholder' => 'Enter your number here')) }}
            </div>
        </div>
       

        {{ Form::submit('Verify', array('class' => 'btn btn-lg btn-primary btn-block')) }}
    {{ Form::close() }}



<hr/>


@stop