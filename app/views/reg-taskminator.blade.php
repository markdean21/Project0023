@extends('layouts.registration')

@section('head')
    Register as Taskminator
@stop

@section('head-contents')
    <style type="text/css">
        span#confirmpassId2 {
            top: -60px;
            left: 125px;
            content: "\2713";
            color: green;
        }
        .error{
            color: red;
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
            if(document.getElementById('passwordInput').value == document.getElementById('confirmpassId').value){
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
/*

            $('#submitForm').click(function(event){
                event.preventDefault();
                var inputs = $('.inputItem'),
                    missingInputs = '',
                    trigger = false;

                for(var x=0; x < inputs.size(); x++){
                    if(inputs.eq(x).val() == ''){
                        trigger = true;
                        break;
                    }
                }

                if(trigger){
                    for(var i=0; i < inputs.size(); i++){
                        if(inputs.eq(i).val() == ''){
                            missingInputs += '- '+inputs.eq(i).attr('data-name')+'<br/>';
                        }
                    }

                    $('#confirmButton').attr('disabled','disabled');
                    $('#emailConfirm').empty();
                    $('#confirmMsg').empty().append('Please fill up necessary information first<br/>'+missingInputs);
                }else{
                    $('#confirmMsg').empty().append('Please confirm your email information before proceeding (This email will recieve necessary updates and notifications)');
                    $('#emailConfirm').empty().append('<i class="se7en-envelope"></i> '+$('#tskmntrEmail').val());
                }

                $('#confirmModal').modal('show');
*/
            });
/*
//            $('#submitForm').click(function(event){
//                event.preventDefault();
//
//
//                if($('#tskmntrEmail').val() == ''){
//                    $('#emailConfirm').empty();
//                    $('#confirmMsg').empty().append('Please fill up necessary information first');
//                }else{
//                    $('#confirmMsg').empty().append('Please confirm your email information before proceeding (This email will recieve necessary updates and notifications)');
//                    $('#emailConfirm').empty().append('<i class="se7en-envelope"></i> '+$('#tskmntrEmail').val());
//                }
//                $('#confirmModal').modal('show');
//            });

            locationChain($('#region-task'), $('#city-task'),$('#registrationForm-task'), '/chainRegion');
//            locationChain($('#region-task'), $('#province-task'),$('#registrationForm-task'), '/chainProvince');
            locationChain($('#city-task'), $('#barangay-task'),$('#registrationForm-task'), '/chainCity');

            $('#taskcategory').change(function(){
                $('#taskitems').empty();
                $.ajax({
                    type    :   'POST',
                    url     :   '/chainCategoryItems',
                    data    :   $('#registrationForm-task').serialize(),
                    success :   function(data){
                        $.each(data, function(key, value){
                            $('#taskitems').append('<option value="'+ value['itemcode'] +'">'+value['itemname']+'</option>');
                        });
                    },error :   function(){
                        alert('ERR500 : Please check network connectivity');
                    }
                })
            });

            $('#addSkillBtn').click(function(){
                var category = $('#taskcategory').find('option:selected').text(),
                    skill = $('#taskitems').find('option:selected').text(),
                    skillCode = $('#taskitems').val();

                if($('#div_'+skillCode).size() > 0){
                    alert('This skill has already been added.');
                }else{
                    var display = '<div id="div_'+skillCode+'" style="margin: 0;"><span data-removeId="'+skillCode+'" onclick="removeSkill(this)" class="glyphicon glyphicon-remove removeSkill" style="cursor:pointer; color: #3498DB; opacity: 1;"></span>&nbsp;&nbsp;&nbsp;'+category+' - '+skill+'</div>',
                        newSkillInput = '<input id="input_'+skillCode+'" type="hidden" name="skills[]" value="'+skillCode+'" />';

                    $('#addedSkills').append(display).append(newSkillInput);
                }
            })
        });
*/
    </script>
@stop

@section('content')
<!--TASKMINATOR REGISTRATION FORM-->
<div class="taskminator-form">
    <h3 style="text-align:center">Worker Information</h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="widget-container fluid-height clearfix">
                <div class="heading" style="padding: 40px 60px">
                    Personal Information
                </div>
                <div class="widget-content padded" style="padding: 10px 60px 40px 60px;">
                    {{ Form::open(array('url' => '/doRegisterTaskminator', 'id' => 'registrationForm-task')) }}
                        <div class="form-group">
                            <label class="control-label row" style="margin-left: 2px;">
                                Name <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your full name"></a>
                            </label>
                            <div class="row">
                                <div class="col-md-4" style="margin-bottom: 2px;">
                                    {{ Form::text('firstName', Input::old('firstName'), array('data-name' => 'First Name', 'class' => 'inputItem form-control', 'placeholder' => 'First name', 'required' => 'true')) }}
                                    @if ($errors->has())
                                        <font color="red">{{ $errors->first('firstName') }}</font>
                                    @endif
                                </div>
                                <div class="col-md-3" style="margin-bottom: 2px;">
                                    {{ Form::text('midName', Input::old('midName'), array('data-name' => 'Middle Name', 'class' => 'inputItem form-control', 'placeholder' => 'Middle name', 'required' => 'true')) }}
                                    @if ($errors->has())
                                        <font color="red">{{ $errors->first('midName') }}</font>
                                    @endif
                                </div>
                                <div class="col-md-5">
                                    {{ Form::text('lastName', Input::old('lastName'), array('data-name' => 'Last Name', 'class' => 'inputItem form-control', 'placeholder' => 'Last name', 'required' => 'true')) }}
                                    @if ($errors->has())
                                        <font color="red">{{ $errors->first('lastName') }}</font>
                                    @endif
                                </div>
                            </div>
                        </div><br/>


                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">
                                    Gender <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your gender"></a>
                                </label>
                                {{ Form::select('gender', array('MALE' => 'Male', 'FEMALE' => 'Female'), Input::old('gender'), array('data-name' => 'Gender', 'class' => 'inputItem form-control', 'required' => 'true')) }}
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label" style="margin-left: 2px;">
                                    Nationality <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your nationality"></a>
                                </label>
                                {{ Form::text('nationality', Input::old('nationality'), array('data-name' => 'Nationality', 'class' => 'inputItem form-control', 'placeholder' => 'Ex. Filipino', 'required' => 'true')) }}
                                @if ($errors->has())
                                    <font color="red">{{ $errors->first('nationality') }}</font>
                                @endif
                            </div>
                        </div>
                        <br/>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">
                                    Birth Date <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your birth date"></a>
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
                                {{ Form::text('mobileNum', Input::old('mobileNum'), array('data-name' => 'Mobile Number', 'class' => 'inputItem form-control', 'id' => 'mobileNum', 'placeholder' => 'Mobile number', 'required' => 'true')) }}
                                @if ($errors->has())
                                    <font color="red">{{ $errors->first('mobileNum') }}</font>
                                @endif
                            </div>
                        </div><br/>

                        <div class="form-group">
                            <label class="control-label">
                                Preferred Job <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your preferred job"></a>
                            </label>
                            {{ Form::text('preferredJob', Input::old('preferredJob'), array('data-name' => 'Preffered Job', 'class' => 'form-control inputItem', 'placeholder' => 'Ex. Carpenter', 'required' => 'true')) }}
                            @if ($errors->has())
                                <font color="red">{{ $errors->first('preferredJob') }}</font>
                            @endif
                        </div>
                        <br/>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label" style="margin-left: 2px;">
                                    Years of Experience <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your years of experience"></a>
                                </label>
                                {{ Form::select('experience', array('0-1 years' => '0-1 years', '2-3 years' => '2-3 years', '3-5 years' => '3-5 years', '5-10 years' => '5-10 years', 'more than 10 years' => 'more than 10 years'), Input::old('experience'), array('data-name' => 'Years of Experience', 'class' => 'inputItem form-control', 'required' => 'true')) }}
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label" style="margin-left: 2px;">
                                    Rate/Month <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your rate per month"></a>
                                </label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <select class="inputItem form-control" name="minRate" id="minRate">
                                            <option selected disabled>Select minimum rate</option>
                                            <?php
                                                for ($i=400; $i <= 1000; $i+=50) {
                                                    echo "<option value=".$i." ".(Input::old("minRate") == $i ? "selected":"").">".$i."</option>";
                                                }
                                            ?>
                                        </select>
                                        @if ($errors->has())
                                            <font color="red">{{ $errors->first('minRate') }}</font>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <select class="inputItem form-control" name="maxRate">
                                            <option selected disabled>Select maximum rate</option>
                                            <?php
                                                for ($i=1000; $i <= 5000; $i+=100) { 
                                                    echo "<option value=".$i." ".(Input::old("maxRate") == $i ? "selected":"").">".$i."</option>";
                                                }
                                            ?>
                                        </select>
                                        @if ($errors->has())
                                            <font color="red">{{ $errors->first('maxRate') }}</font>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label">
                                        Email Address <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your working email address"></a>
                                    </label>
                                    {{ Form::text('email', Input::old('email'), array('data-name' => 'Email Address', 'class' => 'form-control inputItem', 'placeholder' => 'Email address', 'required' => 'true', 'id' => 'email', 'style' => 'max-width: 400px;')) }}
                                    @if ($errors->has())
                                        <font color="red">{{ $errors->first('email') }}</font>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">
                                        TIN Number <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your TIN number"></a>
                                    </label>
                                    <div class="row">
                                        <div class="col-md-2" style="margin-bottom: 2px;">
                                            {{ Form::text('tin1', Input::old('tin1'), array('data-name' => 'TIN Number', 'class' => 'form-control inputItem', 'placeholder' => 'XXX', 'maxlength' => '3')) }}
                                        </div>
                                        <div class="col-md-2" style="margin-bottom: 2px;">
                                            {{ Form::text('tin2', Input::old('tin2'), array('data-name' => 'TIN Number', 'class' => 'form-control inputItem', 'placeholder' => 'XXX', 'maxlength' => '3')) }}
                                        </div>
                                        <div class="col-md-2" style="margin-bottom: 2px;">
                                            {{ Form::text('tin3', Input::old('tin3'), array('data-name' => 'TIN Number', 'class' => 'form-control inputItem', 'placeholder' => 'XXX', 'maxlength' => '3')) }}
                                        </div>
                                        <label class="col-md-2" style="font-size: 16pt;">-&nbsp;000</label>
                                        @if ($errors->has())
                                            @if(!is_null($errors->first('tin1')))
                                                <font color="red">{{ $errors->first('tin1') }}</font>
                                            @elseif (!is_null($errors->first('tin2')))
                                                <font color="red">{{ $errors->first('tin2') }}</font>
                                            @elseif (!is_null($errors->first('tin3')))
                                                <font color="red">{{ $errors->first('tin3') }}</font>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div><br/>


                        <hr/>
                                
                        <div class="form-group">
                            <label class="control-label">
                                Username <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your username"></a>
                            </label>
                            {{ Form::text('username', Input::old('username'), array('data-name' => 'Username', 'class' => 'inputItem form-control', 'placeholder' => 'Username', 'required' => 'true', 'style' => 'max-width: 400px;')) }}
                            @if ($errors->has())
                                <font color="red">{{ $errors->first('username') }}</font>
                            @endif
                        </div><br/>
                        
                        <div class="form-group">
                            <label class="control-label">
                                Password <a href="#" class="icon-question-sign" data-toggle="tooltip" title="Please input your password"></a>
                                <h6>(minimum of 8 characters)</h6>
                            </label>
                            {{ Form::password('password', array('data-name' => 'Password', 'data-display' => 'strengthDisplay', 'id' => 'passwordInput', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter password', 'required' => 'true', 'style' => 'max-width: 400px;')) }}
                            <h5 id="strengthDisplay"></h5>
                            @if ($errors->has())
                                <font color="red">{{ $errors->first('password') }}</font>
                            @endif
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
                            @if ($errors->has())
                                <font color="red">{{ Session::get('captcha') }}</font>
                            @endif
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
<!--
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                <button onclick="$('#registrationForm-task').submit()" class="btn btn-primary">Confirm</button>
            </div>
        </div>
    </div>
</div>
-->
@stop