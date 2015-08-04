@extends('layouts.login')

@section('head')
    Login to Taskminator
@stop

@section('head-contents')
<script>
    $(document).ready(function(){
       $('.passBtn').click(function(){
           var inputLength = $($(this).attr('data-field')).val().length,
               input = $($(this).attr('data-field')),
               msgDiv = $($(this).attr('data-msg')) ;

           msgDiv.empty().append('Please wait.');
           input.prop('readonly', true);

           if(inputLength > 0){
               var form = $($(this).attr('data-form'));
               $.ajax({
                   type      :   form.attr('method'),
                   url       :   form.attr('action'),
                   data      :   form.serialize(),
                   success  :   function(data){
                        if(data['flag'] == 'SUCCESS'){
                            input.val('');
                            msgDiv.empty().append('<span style="color: green; font-size: 0.8em;">'+data['msg']+'</span>');
                        }else{
                            msgDiv.empty().append('<span style="color: red; font-size: 0.8em;">'+data['msg']+'</span>');
                        }

                       input.prop('readonly', false);
                       setTimeout(function(){ msgDiv.empty(); }, 5000);
                   },error  :   function(){
                       msgDiv.empty().append('<span style="color: red; font-size: 0.8em;">Request Failed. Your network connectivity might be unstable or<br/>Server might be down</span>');
                       input.prop('readonly', false);
                       setTimeout(function(){ msgDiv.empty(); }, 5000);
                   }
               });
           }else{
                msgDiv.empty().append('<span style="color: red; font-size: 0.8em;">Please input a registered email</span>');
           }
       })
    });
</script>
@stop

@section('content')
    <!--<a href="/"><h1 style="margin: 40px 0px 30px 0px;">TASK<span style="color: rgb(102, 102, 102)">minator</span></h1></a>-->
    <a href="/"><img src="../images/proveek-logo-300.png" /></a>

    {{ Form::open(array('url' => '/doLogin')) }}
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="icon-envelope"></i></span>
                {{ Form::text('username', Input::old('username'), array('class' => 'form-control', 'placeholder' => 'Enter your username here')) }}
            </div>
        </div>
        {{--Form::text('username', Input::old('username'), array('class' => '', 'placeholder' => 'Enter your username here'))--}}
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="icon-lock"></i></span>
                {{ Form::password('password' , array('class' => 'form-control margin-bottom-10', 'placeholder' => 'Enter your password here')) }}
            </div>
        </div>
        {{--Form::password('password' , array('class' => 'form-control margin-bottom-10', 'placeholder' => 'Enter your password here'))--}}

        {{ Form::submit('Login', array('class' => 'btn btn-lg btn-primary btn-block')) }}
    {{ Form::close() }}

    @if(Session::has('errorMsg'))
        <h5 style="color: red"> {{ Session::get('errorMsg') }} </h5>
    @endif

    @if(Session::has('successMsg'))
        <h5 style="color: green"> {{ Session::get('successMsg') }} </h5>
    @endif

    <p>
        Don't have an account yet?
    </p>
    <a class="btn btn-default-outline btn-block" href="../register">Sign up now</a>
<hr/>
<!--    <a class="btn btn-primary-outline" href="../forgotPassword">Forgot Password</a>-->
    <a class="btn btn-primary-outline" data-toggle="modal" data-target="#forgotPassModal">Forgot Password</a>
<!--    <a class="btn btn-primary-outline" href="../changePassword">Change password</a>-->
    <a class="btn btn-primary-outline" data-toggle="modal" data-target="#changePassModal">Change password</a>

<!-- Modal -->
<div class="modal fade" id="forgotPassModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Forgot Password</h4>
            </div>
            <div class="modal-body">
                <div class="row" style="margin: 0;">
                    <p>
                        You will recieve a confirmation link on this email to for reseting your password.<br/>
                        The account related to this email will be deactivated until password reset has been successful.
                    </p>
                    <form method="POST" action="/forgotPassword" id="forgotPassword">
                        <input type="text" style="display: none;"/>
                        <input type="hidden" name="process" value="FGPASS" />
                        <input type="text" class="form-control" placeholder="Enter your email" name="email" id="emailForgotPass"/>
                        <button type="button" class="btn btn-danger pull-right passBtn" data-msg="#forgotpass-msg" data-form="#forgotPassword" data-field="#emailForgotPass" style="margin: 0; margin-top: 0.4em;">Send</button>
                    </form>
                    <p id="forgotpass-msg" style="margin: 0; margin-top: 1em;">

                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="changePassModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Change Password</h4>
            </div>
            <div class="modal-body">
                <div class="row" style="margin: 0;">
                    <p>
                        You will recieve a confirmation link on this email to for reseting your password.<br/>
                        The account related to this email will be deactivated until password reset has been successful.
                    </p>
                    <form method="POST" action="/changePassword" id="changePassword">
                        <input type="text" style="display: none;"/>
                        <input type="hidden" name="process" value="CHPASS" />
                        <input type="text" class="form-control" placeholder="Enter your email" name="email" id="emailChangePass"/>
                        <button type="button" class="btn btn-danger pull-right passBtn" data-msg="#changepass-msg" data-form="#changePassword" data-field="#emailChangePass" style="margin: 0; margin-top: 0.4em;">Send</button>
                    </form>
                    <p id="changepass-msg" style="margin: 0; margin-top: 1em;">

                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@stop