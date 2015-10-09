@extends('layouts.registration')

@section('head')
    Register as Employer
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
            }else{
                document.getElementById('confirmedPass').className = 'form-group has-error has-feedback';
                document.getElementById('confirmpassId2').style.display = 'none';
            }
        }

        function validateMobile(){
            value = document.getElementById('mobileNum').value;
            if(value.match(/[^0-9]/i))
                document.getElementById('mobileNum').value = value.replace(/[^0-9]/g, '');

        }

        function swapClient(){
            var indi = document.getElementById('individual');
            var comp = document.getElementById('company');

            if(indi.style.display == 'block'){
                comp.style.display = 'block';
                indi.style.display = 'none';
                document.getElementById('indiButton').className = 'btn btn-default';
                document.getElementById('compButton').className = 'btn btn-primary';
            }else{
                comp.style.display = 'none';
                indi.style.display = 'block';
                document.getElementById('indiButton').className = 'btn btn-primary';
                document.getElementById('compButton').className = 'btn btn-default';
            }
        }

        $(document).ready(function(){
            enableSubmit();
            $('#reset').click(function(event){
                document.getElementById('submitForm').disabled = true;
            });
            // validate password
            $("#confirmpassId").keyup(passConfirm);
            // prevent alpha input on mobileNum
            $("#mobileNum").keyup(validateMobile);

        });
    </script>
@stop

@section('content')
    <h3 style="text-align:center">Employer Registration</h3>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist" style="margin-left: 19px; margin-right: 17px;">
      <li class="active" style="width: 50%;"><a href="#individual" role="tab" data-toggle="tab">Individual</a></li>
      <li style="width: 50%;"><a href="#company" role="tab" data-toggle="tab">Company</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active" id="individual">
            <div class="taskminator-form">
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
                                        <label class="control-label row" style="margin-left: 2px;">Name</label>
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
                                            <label class="control-label" style="margin-left: 2px;">Gender</label>
                                            <select name="gender" required="required" class="form-control inputItem" data-name="Gender">
                                                <option value="MALE">Male</option>
                                                <option value="FEMALE">Female</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label" style="margin-left: 2px;">Occupation</label>
                                            {{ Form::text('occupation', Input::old('occupation'), array('data-name' => 'Occupation', 'class' => 'inputItem form-control', 'placeholder' => 'Ex. Contractor', 'required' => 'true')) }}
                                        </div>
                                    </div>
                                    <br/>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="control-label">Birth Date</label>
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
                                            <label class="control-label">Mobile Number</label>
                                            {{ Form::text('mobileNum', Input::old('mobileNum'), array('data-name' => 'Mobile Number', 'class' => 'inputItem form-control', 'placeholder' => 'Mobile number', 'required' => 'true', 'id' => 'mobileNum')) }}
                                        </div>
                                    </div><br/>

                                    <div class="form-group">
                                        <label class="control-label">TIN Number</label>
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
                                        <label class="control-label">Email Address</label>
                                        {{ Form::text('email', Input::old('email'), array('data-name' => 'Email Address', 'class' => 'form-control inputItem', 'placeholder' => 'Email address', 'required' => 'true', 'id' => 'email', 'style' => 'max-width: 400px;')) }}
                                    </div><br/>
                                    
                                    <hr/>
                                    
                                    <div class="form-group">
                                        <label class="control-label">Username</label>
                                        {{ Form::text('username', Input::old('username'), array('data-name' => 'Username', 'class' => 'inputItem form-control', 'placeholder' => 'Username', 'required' => 'true', 'style' => 'max-width: 400px;')) }}
                                    </div><br/>

                                    <div class="form-group">
                                        <label class="control-label">Password <h6>(minimum of 8 characters)</h6></label>
                                        {{ Form::password('password', array('data-name' => 'Password', 'data-display' => 'strengthDisplay', 'id' => 'passwordInput', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter password', 'required' => 'true', 'style' => 'max-width: 400px;')) }}
                                        <h5 id="strengthDisplay"></h5>
                                    </div><br/>


                                    <div class="form-group" id="confirmedPass">
                                        <label class="control-label" for="confirmpassId">Confirm Password</label>
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
      </div>
      <div class="tab-pane" id="company">
            <div class="taskminator-form">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="widget-container fluid-height clearfix">
                                <div class="heading" style="padding: 40px 60px">
                                    Company Information
                                </div>
                                <div class="widget-content padded" style="padding: 10px 60px 40px 60px;">
                                    <div class="client-form-comp">
                                        @if(Session::has('errorMsg'))
                                            <font color="red">{{ Session::get('errorMsg') }}</font>
                                        @endif
                                        {{ Form::open(array('url' => '/doRegisterComp', 'id' => 'registrationForm-comp')) }}
                                            <div class="form-group">
                                                <label class="control-label">Company Name</label>
                                                {{ Form::text('companyName', Input::old('companyName'), array('data-name' => 'Company Name', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter company name', 'required' => 'true')) }}
                                            </div><br/>

                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label class="control-label">Nature of Business</label>
                                                    {{ Form::text('businessNature', Input::old('businessNature'), array('data-name' => 'Business Nature', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter nature of business', 'required' => 'true')) }}
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="control-label" style="margin-left: 2px;">Years in Operation</label>
                                                    {{ Form::select('experience', array('0-1 years' => '0-1 years', '2-3 years' => '2-3 years', '3-5 years' => '3-5 years', '5-10 years' => '5-10 years', 'more than 10 years' => 'more than 10 years'), Input::old('experience'), array('data-name' => 'Years in Operation', 'class' => 'inputItem form-control', 'required' => 'true', 'style' => 'max-width: 200px;'), Input::old('experience')) }}
                                                </div>
                                            </div><br/>

                                            <div class="form-group">
                                                <label class="control-label">Business Description</label>
                                                {{ Form::text('businessDescription', Input::old('businessDescription'), array('data-name' => 'Business Description', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter business description', 'required' => 'true')) }}
                                            </div><br/>
                                            
                                            <div class="form-group">
                                                <label class="control-label">Business Address</label>
                                                {{ Form::text('address', Input::old('address'), array('data-name' => 'Business Address', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter business address', 'required' => 'true')) }}
                                            </div><br/>

                                            <div class="form-group">
                                                <label class="control-label">Business Number</label>
                                                {{ Form::text('businessNum', Input::old('businessNum'), array('data-name' => 'Business Number', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter business number', 'required' => 'true', 'id' => 'businessNum', 'style' => 'max-width: 500px;')) }}
                                            </div><br><br>

                                            <div class="form-group">
                                                <label class="control-label row" style="margin-left: 2px;">Key Contact Person</label>
                                                <div class="row">
                                                    <div class="col-md-4" style="margin-bottom: 2px;">
                                                        {{ Form::text('firstName-keyperson', Input::old('firstName-keyperson'), array('data-name' => 'First Name', 'class' => 'inputItem form-control', 'placeholder' => 'First name', 'required' => 'true')) }}
                                                    </div>
                                                    <div class="col-md-3" style="margin-bottom: 2px;">
                                                        {{ Form::text('midName-keyperson', Input::old('midName-keyperson'), array('data-name' => 'Middle Name', 'class' => 'inputItem form-control', 'placeholder' => 'Middle name', 'required' => 'true')) }}
                                                    </div>
                                                    <div class="col-md-5">
                                                        {{ Form::text('lastName-keyperson', Input::old('lastName-keyperson'), array('data-name' => 'Last Name', 'class' => 'inputItem form-control', 'placeholder' => 'Last name', 'required' => 'true')) }}
                                                    </div>
                                                </div>
                                            </div><br/>

                                            <div class="form-group">
                                                <label class="control-label">Position</label>
                                                {{ Form::text('position-keyperson', Input::old('position-keyperson'), array('data-name' => 'Point Person Position', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter position', 'required' => 'true', 'style' => 'max-width: 500px;')) }}
                                            </div><br>

                                            <div class="form-group">
                                                <label class="control-label">SEC / DTI Registration Number</label>
                                                {{ Form::text('regNum', Input::old('regNum'), array('data-name' => 'Registration Number', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter registration number', 'required' => 'true', 'style' => 'max-width: 400px;')) }}
                                            </div><br>

                                            <div class="form-group">
                                                <label class="control-label">Email</label>
                                                {{ Form::text('email', Input::old('email'), array('data-name' => 'Email Address', 'class' => 'form-control inputItem', 'placeholder' => 'Email address', 'required' => 'true', 'id' => 'email', 'style' => 'max-width: 400px;')) }}
                                            </div><br>

                                            <hr/>
                                            
                                            <div class="form-group">
                                                <label class="control-label">Username</label>
                                                {{ Form::text('username', Input::old('username'), array('data-name' => 'Username', 'class' => 'inputItem form-control', 'placeholder' => 'Username', 'required' => 'true', 'style' => 'max-width: 400px;')) }}
                                            </div><br/>
                                            
                                            <div class="form-group">
                                                <label class="control-label">Password <h6>(minimum of 8 characters)</h6></label>
                                                {{ Form::password('password', array('data-name' => 'Password', 'data-display' => 'strengthDisplay', 'id' => 'passwordInput', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter password', 'required' => 'true', 'style' => 'max-width: 400px;')) }}
                                                <h5 id="strengthDisplay"></h5>
                                            </div><br/>

                                            <div class="form-group" id="confirmedPass">
                                                <label class="control-label" for="confirmpassId">Confirm Password</label>
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
      </div>
    </div>

   

    

    
@stop
