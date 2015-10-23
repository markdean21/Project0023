@extends('layouts.registration')

@section('head')
    Register as Employer (Individual)
@stop

@section('head-contents')
    <style type="text/css">
        span#confirmpassId2 {
            top: -60px;
            left: 125px;
            content: "\2713";
            color: green;
        }
    </style>
    <script>
        function enableSubmit(){
            var val = document.getElementById('TOS');
            var sbmt = document.getElementById("submitForm");
            
            if (val.checked){
                sbmt.disabled = false;
            }
            else{
                sbmt.disabled = true;
            }
        }

        function passConfirm(){
            if(document.getElementById('passwordInput').value != '' && document.getElementById('passwordInput').value == document.getElementById('confirmpassId').value){
                document.getElementById('confirmedPass').className = 'form-group has-success has-feedback';
                document.getElementById('confirmpassId2').style.display = 'block';
                document.getElementById('tooltipPass').style.display = 'none';
            }else{
                document.getElementById('confirmedPass').className = 'form-group has-error has-feedback';
                document.getElementById('confirmpassId2').style.display = 'none';
                document.getElementById('tooltipPass').style.display = 'inline';
            }
        }

        function validateMobile(){
            value = document.getElementById('mobileNum').value;
            if(value.match(/[^0-9]/i))
                document.getElementById('mobileNum').value = value.replace(/[^0-9]/g, '');

        }
/*
        function validateInput(this){
            if(this.value != ''){
                this.className .= ' has-success has-feedback';
            }else{
                this.className .= ' has-error has-feedback';
            }
        }
*/
        $(document).ready(function(){
            enableSubmit();
            $('#reset').click(function(event){
                document.getElementById('submitForm').disabled = true;
            });
            // validate password
            $("#confirmpassId").keyup(passConfirm);
            // prevent alpha input on mobileNum
            $("#mobileNum").keyup(validateMobile);
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop

@section('content')
    <div class="taskminator-form">
        <h3 style="text-align:center">Employer Registration (Individual)</h3>
        <div class="row">
            <div class="col-lg-12">
                <div class="widget-container fluid-height clearfix">
                    <div class="heading" style="padding: 40px 60px">
                        Personal Information
                    </div>
                    <div class="widget-content padded" style="padding: 10px 60px 40px 60px;">
                        <div class="client-form-indi">
                            @if(Session::has('errorMsg'))
                                <font color="red">{{ Session::get('errorMsg') }}</font><br><br>
                            @endif
                            {{ Form::open(array('url' => '/doRegisterIndi', 'id' => 'registrationForm')) }}
                                
                                <div class="form-group">
                                    <label class="control-label row" style="margin-left: 2px;">
                                        Name <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your full name"></a>
                                    </label>
                                    <div class="row">
                                        <div class="col-md-4" style="margin-bottom: 2px;">
                                            {{ Form::text('firstName', Input::old('firstName'), array('data-name' => 'First Name', 'class' => 'inputItem form-control', 'placeholder' => 'First name', 'required' => 'true')) }}
                                        </div>
                                        <div class="col-md-3" style="margin-bottom: 2px;">
                                            {{ Form::text('midName', Input::old('midName'), array('data-name' => 'Middle Name', 'class' => 'inputItem form-control', 'placeholder' => 'Middle name', 'required' => 'true')) }}
                                        </div>
                                        <div class="col-md-5">
                                            {{ Form::text('lastName', Input::old('lastName'), array('data-name' => 'Last Name', 'class' => 'inputItem form-control', 'placeholder' => 'Last name', 'required' => 'true')) }}
                                        </div>
                                    </div>
                                </div><br/>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="control-label" style="margin-left: 2px;">
                                            Gender <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please select your gender"></a>
                                        </label>
                                        {{ Form::select('gender', array('MALE' => 'Male', 'FEMALE' => 'Female'), Input::old('gender'), array('data-name' => 'Gender', 'class' => 'inputItem form-control', 'required' => 'true')) }}
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="control-label" style="margin-left: 2px;">
                                            Occupation <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your occupation"></a>
                                        </label>
                                        {{ Form::text('occupation', Input::old('occupation'), array('data-name' => 'Occupation', 'class' => 'inputItem form-control', 'placeholder' => 'Ex. Contractor', 'required' => 'true')) }}
                                    </div>
                                </div>
                                <br/>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="control-label">
                                            Birth Date <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your birthdate"></a>
                                        </label>
                                        <div class="row">
                                            <div class="col-md-4" style="margin-bottom: 2px;">
                                                {{ Form::selectMonth('month', Input::old('month'), array('data-name' => 'Month', 'class' => 'inputItem form-control', 'required' => 'true')) }}
                                            </div>
                                            <div class="col-md-2" style="margin-bottom: 2px;">
                                                {{ Form::selectRange('date', 1, 31, Input::old('date'), array('data-name' => 'Date', 'class' => 'inputItem form-control', 'required' => 'true')) }}
                                            </div>
                                            <div class="col-md-3" style="margin-bottom: 2px;">
                                                <?php $year = date("Y"); $year -= 18; ?>
                                        {{ Form::selectYear('year', $year, 1955, Input::old('year'), array('data-name' => 'Year', 'class' => 'inputItem form-control', 'required' => 'true')) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="control-label">
                                            Mobile Number <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your mobile number"></a>
                                        </label>
                                        {{ Form::text('mobileNum', Input::old('mobileNum'), array('data-name' => 'Mobile Number', 'class' => 'inputItem form-control', 'placeholder' => 'Mobile number', 'required' => 'true', 'id' => 'mobileNum')) }}
                                    </div>
                                </div><br/>

                                <div class="form-group">
                                    <label class="control-label">
                                        TIN Number <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your TIN number"></a>
                                    </label>
                                    <div class="row">
                                        <div class="col-md-1" style="margin-bottom: 2px;">
                                            {{ Form::text('tin1', Input::old('tin1'), array('data-name' => 'TIN Number', 'class' => 'form-control inputItem', 'placeholder' => 'XXX', 'maxlength' => '3','required' => 'true')) }}
                                        </div>
                                        <div class="col-md-1" style="margin-bottom: 2px;">
                                            {{ Form::text('tin2', Input::old('tin2'), array('data-name' => 'TIN Number', 'class' => 'form-control inputItem', 'placeholder' => 'XXX', 'maxlength' => '3','required' => 'true')) }}
                                        </div>
                                        <div class="col-md-1" style="margin-bottom: 2px;">
                                            {{ Form::text('tin3', Input::old('tin3'), array('data-name' => 'TIN Number', 'class' => 'form-control inputItem', 'placeholder' => 'XXX', 'maxlength' => '3','required' => 'true')) }}
                                        </div>
                                        <label class="col-md-8" style="font-size: 16pt;">-&nbsp;000</label>
                                    </div>
                                </div><br/>

                                <div class="form-group">
                                    <label class="control-label">
                                        Email Address <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your working email address"></a>
                                    </label>
                                    {{ Form::text('email', Input::old('email'), array('data-name' => 'Email Address', 'class' => 'form-control inputItem', 'placeholder' => 'Email address', 'required' => 'true', 'id' => 'email', 'style' => 'max-width: 400px;')) }}
                                </div><br/>
                                
                                <hr/>
                                
                                <div class="form-group">
                                    <label class="control-label">
                                        Username <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your username"></a>
                                    </label>
                                    {{ Form::text('username', Input::old('username'), array('data-name' => 'Username', 'class' => 'inputItem form-control', 'placeholder' => 'Username', 'required' => 'true', 'style' => 'max-width: 400px;')) }}
                                </div><br/>

                                <div class="form-group">
                                    <label class="control-label">
                                        Password <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your password"></a>
                                        <h6>(minimum of 8 characters)</h6>
                                    </label>
                                    {{ Form::password('password', array('data-name' => 'Password', 'data-display' => 'strengthDisplay', 'id' => 'passwordInput', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter password', 'required' => 'true', 'style' => 'max-width: 400px;')) }}
                                    <h5 id="strengthDisplay"></h5>
                                </div><br/>


                                <div class="form-group" id="confirmedPass">
                                    <label class="control-label" for="confirmpassId">
                                        Confirm Password <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please re-input your password to confirm" id="tooltipPass"></a>
                                    </label>
                                    {{ Form::password('confirmpass', array('data-name' => 'Confirm Password', 'id' => 'confirmpassId', 'class' => 'inputItem form-control', 'placeholder' => 'Re-type password', 'style' => 'max-width: 400px;', 'required' => 'true')) }}
                                    <span class="glyphicon glyphicon-ok form-control-feedback" style="display: none;" id="confirmpassId2"></span>
                                </div><br/>

                                <p>
                                    {{ HTML::image(URL::to('simplecaptcha'),'Captcha', array('class' => 'img-rounded')) }}<br><br>
                                    <label>CAPTCHA</label>
                                    {{ Form::text('captcha', '', array('data-name' => 'Captcha', 'class' => 'inputItem form-control', 'id' => 'captcha','placeholder' => 'Type code above', 'required' => 'true', 'style' => 'width: 130px;')) }}
                                </p>

                                <div class="row form-group" style="margin-left: 5px;">
                                    <input id="TOS" name="TOS" type="checkbox" value="1" onclick="enableSubmit()" style="display: -moz-box;">
                                    <label class="control-label" style="margin-left: 5px;">Accept Terms of Service and Privacy Policy</label>
                                </div>
                            
                                <button class="btn btn-primary" type="submit" id="submitForm" disabled>Register</button>
                                {{ Form::reset('Reset', array('class' => 'btn btn-default', 'id' => 'reset')) }}
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!--div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Confirm Email</h4>
            </div>
            <div class="modal-body">
                <div class="row" style="margin: 0;">
                    <span id="confirmMsg">Please confirm your email information before proceeding (This email will recieve necessary updates and notifications)</span>
                    <p id="emailConfirm" style="font-size: 1.5em; margin-top: 2em;"></p>
                </div>
            </div>
            <div class="modal-footer" style="margin: 0; padding: 0.8em;">
                <button data-dismiss="modal" class="btn btn-danger">Cancel</button>
                <button class="btn btn-primary" id="confirmBtn" onclick="$('#registrationForm').submit();">Confirm</button>
            </div>
        </div>
    </div>
</div-->
@stop