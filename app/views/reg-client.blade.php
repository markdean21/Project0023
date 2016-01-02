@extends('layouts.registration')

@section('head')
    Register as Employer
@stop

@section('head-contents')
    <style type="text/css">
        span#confirmpassId2, span#confirmpassId4  {
            top: -60px;
            left: 125px;
            content: "\2713";
            color: green;
        }
    </style>
    <script>
        function enableSubmit(){
            // for indi client
            var val = document.getElementById('TOS');
            var sbmt = document.getElementById("submitForm");
            
            if (val.checked){
                sbmt.disabled = false;
            }
            else{
                sbmt.disabled = true;
            }
            // for company client
            var val = document.getElementById('TOS2');
            var sbmt = document.getElementById("submitForm2");
            
            if (val.checked){
                sbmt.disabled = false;
            }
            else{
                sbmt.disabled = true;
            }
        }

        function passConfirm1(){
            // for indi client
            if(document.getElementById('passwordInput').value != '' && document.getElementById('passwordInput').value == document.getElementById('confirmpassId').value){
                document.getElementById('confirmedPass').className = 'form-group has-success has-feedback';
                document.getElementById('confirmpassId2').style.display = 'block';
                document.getElementById('tooltipPass').style.display = 'none';
            }else{
                document.getElementById('confirmedPass').className = 'form-group has-error has-feedback';
                document.getElementById('confirmpassId2').style.display = 'none';
                document.getElementById('tooltipPass').style.display = 'inline';
            }
            validateRequired('passwordInput');
        }

        function passConfirm2(){
            // for company client
            if(document.getElementById('passwordInput2').value != '' && document.getElementById('passwordInput2').value == document.getElementById('confirmpassId3').value){
                document.getElementById('confirmedPass2').className = 'form-group has-success has-feedback';
                document.getElementById('confirmpassId4').style.display = 'block';
                document.getElementById('tooltipPass2').style.display = 'none';
            }else{
                document.getElementById('confirmedPass2').className = 'form-group has-error has-feedback';
                document.getElementById('confirmpassId4').style.display = 'none';
                document.getElementById('tooltipPass2').style.display = 'inline';
            }
            validateRequired('passwordInput2');
        }

        function validateRequired(idName){
            value = document.getElementById(idName).value;
            classProperty = document.getElementById(idName).className;
            if(value || value!=''){
                document.getElementById(idName).className = classProperty.replace(' error', '');
            }else{
                if(classProperty.indexOf("error") == -1) document.getElementById(idName).className = classProperty.concat(' error');
            }
        }

        function validateMobile(){
            value = document.getElementById('mobileNum').value;
            if(value.match(/[^0-9]/i)){
                document.getElementById('mobileNum').value = value.replace(/[^0-9]/g, '');
            }
            validateRequired('mobileNum');
        }

        $(document).ready(function(){
            enableSubmit();
            $('[data-toggle="tooltip"]').tooltip();
            $("select").each(function(){
                var input = $(this);
                @if (!$errors->has())
                    input.prepend('<option value="disabled" disabled selected> -- select '+input.attr('name')+' -- </option>');
                @else
                    input.prepend('<option value="disabled" disabled> -- select '+input.attr('name')+' -- </option>');
                @endif
            });
            $('form input[type=text], form input[type=password], form select').each(function(){
                var input = $(this);
                if( !input.val() || input.val()!='' ) {
                    input.addClass('error');
                }
            });

            // validation functions
            $('#reset').click(function(event){
                document.getElementById('submitForm1').disabled = true;
                document.getElementById('submitForm2').disabled = true;
            });
            // validate password
            $("#confirmpassId3").keyup(passConfirm2);
            $("#confirmpassId").keyup(passConfirm1);
            // prevent alpha input on mobileNum
            $("#mobileNum").keyup(validateMobile);
        });
    </script>
@stop

@section('content')



    <h3 style="text-align:center">Employer Registration</h3>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist" style="margin-left: 19px; margin-right: 17px; text-align:center;">
        @if(Session::has('client'))
            <li style="width: 50%;"><a href="#individual" role="tab" data-toggle="tab">Individual</a></li>
            <li class="active" style="width: 50%;"><a href="#company" role="tab" data-toggle="tab">Company</a></li>
        @else
            <li class="active" style="width: 50%;"><a href="#individual" role="tab" data-toggle="tab">Individual</a></li>
            <li style="width: 50%;"><a href="#company" role="tab" data-toggle="tab">Company</a></li>
        @endif
      
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        @if(!Session::has('client'))
            <div class="tab-pane active" id="individual">
        @else
            <div class="tab-pane" id="individual">
        @endif
            <div class="taskminator-form">
            <div class="row">
                <div class="col-lg-12">
                    <div class="widget-container fluid-height clearfix">
                        <div class="heading" style="padding: 40px 60px">
                            Personal Information
                        </div>
                        <div class="widget-content padded" style="padding: 10px 60px 40px 60px;">
                            <div class="client-form-indi">
                                {{ Form::open(array('url' => '/doRegisterIndi', 'id' => 'registrationForm')) }}
                                    <div class="form-group">
                                        <label class="control-label row" style="margin-left: 2px;">
                                            Name <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your full name"></a>
                                        </label>
                                        <div class="row">
                                            <div class="col-md-4" style="margin-bottom: 2px;">
                                                {{ Form::text('firstName', Input::old('firstName'), array('data-name' => 'First Name', 'class' => 'inputItem form-control', 'placeholder' => 'First name', 'required' => 'true', 'id' => 'firstName', 'onkeyup' => 'validateRequired("firstName");')) }}
                                                @if ($errors->has())
                                                    <font color="red">{{ $errors->first('firstName') }}</font>
                                                @endif
                                            </div>
                                            <div class="col-md-3" style="margin-bottom: 2px;">
                                                {{ Form::text('midName', Input::old('midName'), array('data-name' => 'Middle Name', 'class' => 'inputItem form-control', 'placeholder' => 'Middle name', 'required' => 'true', 'id' => 'midName', 'onkeyup' => 'validateRequired("midName");')) }}
                                                @if ($errors->has())
                                                    <font color="red">{{ $errors->first('midName') }}</font>
                                                @endif
                                            </div>
                                            <div class="col-md-5">
                                                {{ Form::text('lastName', Input::old('lastName'), array('data-name' => 'Last Name', 'class' => 'inputItem form-control', 'placeholder' => 'Last name', 'required' => 'true', 'id' => 'lastName', 'onkeyup' => 'validateRequired("lastName");')) }}
                                                @if ($errors->has())
                                                    <font color="red">{{ $errors->first('lastName') }}</font>
                                                @endif
                                            </div>
                                        </div>

                                    </div><br/>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="control-label" style="margin-left: 2px;">
                                                Gender <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your gender"></a>
                                            </label>
                                            {{ Form::select('gender', array('MALE' => 'Male', 'FEMALE' => 'Female'), Input::old('gender'), array('data-name' => 'Gender', 'class' => 'inputItem form-control', 'required' => 'true', 'id' => 'gender', 'onchange' => 'validateRequired("gender");')) }}
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label" style="margin-left: 2px;">
                                                Occupation <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your occupation"></a>
                                            </label>
                                            {{ Form::text('occupation', Input::old('occupation'), array('data-name' => 'Occupation', 'class' => 'inputItem form-control', 'placeholder' => 'Ex. Contractor', 'required' => 'true', 'id' => 'occupation', 'onkeyup' => 'validateRequired("occupation");')) }}
                                            @if ($errors->has())
                                                <font color="red">{{ $errors->first('occupation') }}</font>
                                            @endif
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
                                                    {{ Form::selectMonth('month', Input::old('month'), array('data-name' => 'Month', 'class' => 'inputItem form-control', 'required' => 'true', 'id' => 'month', 'onchange' => 'validateRequired("month")')) }}
                                                </div>
                                                <div class="col-md-2" style="margin-bottom: 2px;">
                                                    {{ Form::selectRange('date', 1, 31, Input::old('date'), array('data-name' => 'Date', 'class' => 'inputItem form-control', 'required' => 'true', 'id' => 'date', 'onchange' => 'validateRequired("date")')) }}
                                                </div>
                                                <div class="col-md-3" style="margin-bottom: 2px;">
                                                    <?php $year = date("Y"); $year -= 18; ?>
                                                    {{ Form::selectYear('year', $year, 1955, Input::old('year'), array('data-name' => 'Year', 'class' => 'inputItem form-control', 'required' => 'true', 'id' => 'year', 'onchange' => 'validateRequired("year")')) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label">
                                                Mobile Number <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your mobile number"></a>
                                            </label>
                                            {{ Form::text('mobileNum', Input::old('mobileNum'), array('data-name' => 'Mobile Number', 'class' => 'inputItem form-control ', 'placeholder' => 'Mobile number', 'required' => 'true', 'id' => 'mobileNum')) }}
                                            @if ($errors->has())
                                                <font color="red">{{ $errors->first('mobileNum') }}</font>
                                            @endif
                                        </div>
                                    </div><br/>

                                    <div class="form-group">
                                        <label class="control-label">
                                            TIN Number <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your TIN number"></a>
                                        </label>
                                        <div class="row">
                                            <div class="col-md-1" style="margin-bottom: 2px;">
                                                {{ Form::text('tin1', Input::old('tin1'), array('data-name' => 'TIN Number', 'class' => 'form-control inputItem', 'placeholder' => 'XXX', 'maxlength' => '3','required' => 'true', 'id' => 'tin1', 'onkeyup' => 'validateRequired("tin1")')) }}
                                            </div>
                                            <div class="col-md-1" style="margin-bottom: 2px;">
                                                {{ Form::text('tin2', Input::old('tin2'), array('data-name' => 'TIN Number', 'class' => 'form-control inputItem', 'placeholder' => 'XXX', 'maxlength' => '3','required' => 'true', 'id' => 'tin2', 'onkeyup' => 'validateRequired("tin2")')) }}
                                            </div>
                                            <div class="col-md-1" style="margin-bottom: 2px;">
                                                {{ Form::text('tin3', Input::old('tin3'), array('data-name' => 'TIN Number', 'class' => 'form-control inputItem', 'placeholder' => 'XXX', 'maxlength' => '3','required' => 'true', 'id' => 'tin3', 'onkeyup' => 'validateRequired("tin3")')) }}
                                            </div>
                                            <label class="col-md-8" style="font-size: 16pt;">-&nbsp;000</label>
                                        </div>
                                        @if ($errors->has())
                                            @if(!is_null($errors->first('tin1')))
                                                <font color="red">{{ $errors->first('tin1') }}</font>
                                            @elseif (!is_null($errors->first('tin2')))
                                                <font color="red">{{ $errors->first('tin2') }}</font>
                                            @elseif (!is_null($errors->first('tin3')))
                                                <font color="red">{{ $errors->first('tin3') }}</font>
                                            @endif
                                        @endif
                                    </div><br/>

                                    <div class="form-group">
                                        <label class="control-label">
                                            Email Address <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your working email address"></a>
                                        </label>
                                        {{ Form::text('email', Input::old('email'), array('data-name' => 'Email Address', 'class' => 'form-control inputItem', 'placeholder' => 'Email address', 'required' => 'true', 'id' => 'email', 'style' => 'max-width: 400px;', 'onkeyup' => 'validateRequired("email");')) }}
                                        @if ($errors->has())
                                            <font color="red">{{ $errors->first('email') }}</font>
                                        @endif
                                    </div><br/>
                                    
                                    <hr/>
                                    
                                    <div class="form-group">
                                        <label class="control-label">
                                            Username <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your username"></a>
                                        </label>
                                        {{ Form::text('username', Input::old('username'), array('data-name' => 'Username', 'class' => 'inputItem form-control', 'placeholder' => 'Username', 'required' => 'true', 'style' => 'max-width: 400px;', 'id' => 'username', 'onkeyup' => 'validateRequired("username")')) }}
                                        @if ($errors->has())
                                            <font color="red">{{ $errors->first('username') }}</font>
                                        @endif
                                    </div><br/>

                                    <div class="form-group">
                                        <label class="control-label">
                                            Password <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your password"></a>
                                            <h6>(minimum of 8 characters)</h6>
                                        </label>
                                        {{ Form::password('password', array('data-name' => 'Password', 'data-display' => 'strengthDisplay', 'id' => 'passwordInput', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter password', 'required' => 'true', 'style' => 'max-width: 400px;', 'onkeyup' => 'validateRequired("passwordInput")')) }}
                                        <h5 id="strengthDisplay"></h5>
                                        @if ($errors->has())
                                            <font color="red">{{ $errors->first('password') }}</font>
                                        @endif
                                    </div><br/>


                                    <div class="form-group" id="confirmedPass">
                                        <label class="control-label" for="confirmpassId">
                                            Confirm Password <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please re-input your password to confirm" id="tooltipPass"></a>
                                        </label>
                                        {{ Form::password('confirmpass', array('data-name' => 'Confirm Password', 'id' => 'confirmpassId', 'class' => 'inputItem form-control', 'placeholder' => 'Re-type password', 'style' => 'max-width: 400px;', 'required' => 'true', 'onkeyup' => 'validateRequired("confirmpassId")')) }}
                                        <span class="glyphicon glyphicon-ok form-control-feedback" style="display: none;" id="confirmpassId2"></span>
                                    </div><br/>

                                    <p>
                                        {{ HTML::image(URL::to('simplecaptcha'),'Captcha', array('class' => 'img-rounded')) }}<br><br>
                                        <label>CAPTCHA</label>
                                        {{ Form::text('captcha', '', array('data-name' => 'Captcha', 'class' => 'inputItem form-control', 'id' => 'captcha','placeholder' => 'Type code above', 'required' => 'true', 'style' => 'width: 130px;', 'onkeyup' => 'validateRequired("captcha")')) }}
                                        @if ($errors->has())
                                            <font color="red">{{ Session::get('captcha') }}</font>
                                        @endif
                                    </p>

                                    <div class="row form-group checkbox" style="margin-left: 1px;">
                                        <label class="control-label" style="margin-left: 5px;">
                                        <input id="TOS" name="TOS" type="checkbox" value="1" onclick="enableSubmit()" style="display: -moz-box;">
                                        Accept Terms of Service and Privacy Policy</label>
                                    </div>

                                    <br>
                                
                                    <button class="btn btn-primary" type="submit" id="submitForm" disabled>Register</button>
                                    {{ Form::reset('Reset', array('class' => 'btn btn-default', 'id' => 'reset')) }}
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      @if(Session::has('client'))
        <div class="tab-pane active" id="company">
      @else
        <div class="tab-pane" id="company">
      @endif
            <div class="taskminator-form">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="widget-container fluid-height clearfix">
                                <div class="heading" style="padding: 40px 60px">
                                    Company Information
                                </div>
                                <div class="widget-content padded" style="padding: 10px 60px 40px 60px;">
                                    <div class="client-form-comp">
                                        @if(Session::has('errorMsg') && Session::has('client'))
                                            <font color="red">{{ Session::get('errorMsg') }}</font>
                                        @endif
                                        {{ Form::open(array('url' => '/doRegisterComp', 'id' => 'registrationForm-comp')) }}
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Company Name <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your company name"></a>
                                                </label>
                                                {{ Form::text('companyName', Input::old('companyName'), array('data-name' => 'Company Name', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter company name', 'required' => 'true', 'id' => 'companyName', 'onkeyup' => 'validateRequired("companyName")')) }}
                                                @if ($errors->has())
                                                    <font color="red">{{ $errors->first('companyName') }}</font>
                                                @endif
                                            </div><br/>

                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label class="control-label">
                                                        Nature of Business <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input the nature of business"></a>
                                                    </label>
                                                    {{ Form::text('businessNature', Input::old('businessNature'), array('data-name' => 'Business Nature', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter nature of business', 'required' => 'true', 'id' => 'businessNature', 'onkeyup' => 'validateRequired("businessNature")')) }}
                                                    @if ($errors->has())
                                                        <font color="red">{{ $errors->first('businessNature') }}</font>
                                                    @endif
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="control-label" style="margin-left: 2px;">
                                                        Years in Operation <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input select your years in operation"></a>
                                                    </label>
                                                    {{ Form::select('experience', array('0-1 years' => '0-1 years', '2-3 years' => '2-3 years', '3-5 years' => '3-5 years', '5-10 years' => '5-10 years', 'more than 10 years' => 'more than 10 years'), Input::old('experience'), array('data-name' => 'Years in Operation', 'class' => 'inputItem form-control', 'required' => 'true', 'style' => 'max-width: 200px;', 'id' => 'experience', 'onchange' => 'validateRequired("experience")')
                                                    ) }}
                                                </div>
                                            </div><br/>

                                            <div class="form-group">
                                                <label class="control-label">
                                                    Business Description <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your business description"></a>
                                                </label>
                                                {{ Form::text('businessDescription', Input::old('businessDescription'), array('data-name' => 'Business Description', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter business description', 'required' => 'true', 'id' => 'businessDescription', 'onkeyup' => 'validateRequired("businessDescription")')) }}
                                                @if ($errors->has())
                                                    <font color="red">{{ $errors->first('businessDescription') }}</font>
                                                @endif
                                            </div><br/>
                                            
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Business Address <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your business address"></a>
                                                </label>
                                                {{ Form::text('address', Input::old('address'), array('data-name' => 'Business Address', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter business address', 'required' => 'true', 'id' => 'address', 'onkeyup' => 'validateRequired("address")')) }}
                                                @if ($errors->has())
                                                    <font color="red">{{ $errors->first('address') }}</font>
                                                @endif
                                            </div><br/>

                                            <div class="form-group">
                                                <label class="control-label">
                                                    Business Number <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your business number"></a>
                                                </label>
                                                {{ Form::text('businessNum', Input::old('businessNum'), array('data-name' => 'Business Number', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter business number', 'required' => 'true', 'id' => 'businessNum', 'style' => 'max-width: 500px;', 'onkeyup' => 'validateRequired("businessNum")')) }}
                                                @if ($errors->has())
                                                    <font color="red">{{ $errors->first('businessNum') }}</font>
                                                @endif
                                            </div><br><br>

                                            <div class="form-group">
                                                <label class="control-label row" style="margin-left: 2px;">
                                                    Key Contact Person <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input the full name of your Key Contact Person"></a>
                                                </label>
                                                <div class="row">
                                                    <div class="col-md-4" style="margin-bottom: 2px;">
                                                        {{ Form::text('firstName-keyperson', Input::old('firstName-keyperson'), array('data-name' => 'First Name', 'class' => 'inputItem form-control', 'placeholder' => 'First name', 'required' => 'true', 'id' => 'firstName-keyperson', 'onkeyup' => 'validateRequired("firstName-keyperson")')) }}
                                                        @if ($errors->has())
                                                            <font color="red">{{ $errors->first('firstName-keyperson') }}</font>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-3" style="margin-bottom: 2px;">
                                                        {{ Form::text('midName-keyperson', Input::old('midName-keyperson'), array('data-name' => 'Middle Name', 'class' => 'inputItem form-control', 'placeholder' => 'Middle name', 'required' => 'true', 'id' => 'midName-keyperson', 'onkeyup' => 'validateRequired("midName-keyperson")')) }}
                                                        @if ($errors->has())
                                                            <font color="red">{{ $errors->first('midName-keyperson') }}</font>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-5">
                                                        {{ Form::text('lastName-keyperson', Input::old('lastName-keyperson'), array('data-name' => 'Last Name', 'class' => 'inputItem form-control', 'placeholder' => 'Last name', 'required' => 'true', 'id' => 'lastName-keyperson', 'onkeyup' => 'validateRequired("lastName-keyperson")')) }}
                                                        @if ($errors->has())
                                                            <font color="red">{{ $errors->first('lastName-keyperson') }}</font>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div><br/>

                                            <div class="form-group">
                                                <label class="control-label">
                                                    Position <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input the position of your Key Contact Person"></a>
                                                </label>
                                                {{ Form::text('position-keyperson', Input::old('position-keyperson'), array('data-name' => 'Point Person Position', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter position', 'required' => 'true', 'style' => 'max-width: 500px;', 'id' => 'position-keyperson', 'onkeyup' => 'validateRequired("position-keyperson")')) }}
                                                @if ($errors->has())
                                                    <font color="red">{{ $errors->first('position-keyperson') }}</font>
                                                @endif
                                            </div><br>

                                            <div class="form-group">
                                                <label class="control-label">
                                                    SEC / DTI Registration Number <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your SEC or Registration Number"></a>
                                                </label>
                                                {{ Form::text('regNum', Input::old('regNum'), array('data-name' => 'Registration Number', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter registration number', 'required' => 'true', 'style' => 'max-width: 400px;', 'id' => 'regNum', 'onkeyup' => 'validateRequired("regNum")')) }}
                                                @if ($errors->has())
                                                    <font color="red">{{ $errors->first('regNum') }}</font>
                                                @endif
                                            </div><br>

                                            <div class="form-group">
                                                <label class="control-label">
                                                    Email <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your business address"></a>
                                                </label>
                                                {{ Form::text('email2', Input::old('email2'), array('data-name' => 'Email Address', 'class' => 'form-control inputItem', 'placeholder' => 'Email address', 'required' => 'true', 'id' => 'email2', 'style' => 'max-width: 400px;', 'onkeyup' => 'validateRequired("email2")')) }}
                                                @if ($errors->has())
                                                    <font color="red">{{ $errors->first('email2') }}</font>
                                                @endif
                                            </div><br>

                                            <hr/>
                                            
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Username <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your username"></a>
                                                </label>
                                                {{ Form::text('username2', Input::old('username2'), array('data-name' => 'Username', 'class' => 'inputItem form-control', 'placeholder' => 'Username', 'required' => 'true', 'style' => 'max-width: 400px;', 'id' => 'username2', 'onkeyup' => 'validateRequired("username2")')) }}
                                                @if ($errors->has())
                                                    <font color="red">{{ $errors->first('username2') }}</font>
                                                @endif
                                            </div><br/>
                                            
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Password <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your password"></a>
                                                    <h6>(minimum of 8 characters)</h6>
                                                </label>
                                                {{ Form::password('password', array('data-name' => 'Password', 'data-display' => 'strengthDisplay', 'id' => 'passwordInput2', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter password', 'required' => 'true', 'style' => 'max-width: 400px;', 'onkeyup' => 'validateRequired("passwordInput2")')) }}
                                                <h5 id="strengthDisplay"></h5>
                                                @if ($errors->has())
                                                    <font color="red">{{ $errors->first('password') }}</font>
                                                @endif
                                            </div><br/>

                                            <div class="form-group" id="confirmedPass2">
                                                <label class="control-label" for="confirmpassId3">
                                                    Confirm Password <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please re-input your password to confirm" id="tooltipPass2"></a>
                                                </label>
                                                {{ Form::password('confirmpass', array('data-name' => 'Confirm Password', 'id' => 'confirmpassId3', 'class' => 'inputItem form-control', 'placeholder' => 'Re-type password', 'style' => 'max-width: 400px;', 'required' => 'true', 'onkeyup' => 'validateRequired("confirmpassId3")')) }}
                                                <span class="glyphicon glyphicon-ok form-control-feedback" style="display: none;" id="confirmpassId4"></span>
                                            </div><br/>

                                            <p>
                                                {{ HTML::image(URL::to('simplecaptcha'),'Captcha', array('class' => 'img-rounded')) }}<br><br>
                                                <label>CAPTCHA</label>
                                                {{ Form::text('captcha', '', array('data-name' => 'Captcha', 'class' => 'inputItem form-control', 'id' => 'captcha1','placeholder' => 'Type code above', 'required' => 'true', 'style' => 'width: 130px;', 'onkeyup' => 'validateRequired("captcha1")')) }}
                                                @if ($errors->has())
                                                    <font color="red">{{ Session::get('captcha') }}</font>
                                                @endif
                                            </p>

                                            <div class="row form-group checkbox" style="margin-left: 1px;">
                                                <label class="control-label">
                                                <input id="TOS2" name="TOS" type="checkbox" onclick="enableSubmit()" style="display: -moz-box;">
                                                Accept Terms of Service and Privacy Policy</label>
                                            </div>
                                        
                                            <br>

                                            <button class="btn btn-primary" type="submit" id="submitForm2" disabled>Register</button>
                                            {{ Form::reset('Reset', array('class' => 'btn btn-default', 'id' => 'reset')) }}
                                        {{ Form::close() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
      </div>
    </div>
@stop
