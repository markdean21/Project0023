@extends('layouts.registration')

@section('head')
    Register as Taskminator
@stop

@section('head-contents')
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

        $(document).ready(function(){
            enableSubmit();
        });

        function passConfirm(){
            if(document.getElementById('passwordInput').value == document.getElementById('confirmpassId').value){
                document.getElementById('confirmedPass').className = 'form-group has-success has-feedback';
            }else{
                document.getElementById('confirmedPass').className = 'form-group has-error has-feedback';
            }
        }

        function removeSkill(data){
            var dataId = $(data).attr('data-removeId');
//            alert($(data).attr('data-removeId'));
            $('#div_'+dataId).remove();
            $('#input_'+dataId).remove();
        }

        $(document).ready(function(){
            $('#reset').click(function(event){
                document.getElementById('submitForm').disabled = true;
            });
            $("#confirmpassId").keyup(passConfirm);

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
            });
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
    </script>
@stop

@section('content')
<!--TASKMINATOR REGISTRATION FORM-->
<!--<div class="taskminator-form" style="display: none;">-->
<div class="taskminator-form">
    <h3 style="text-align:center">Worker Information</h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="widget-container fluid-height clearfix">

                @if(Session::has('errorMsg'))
                    <div class="alert alert-danger">
                        {{ Session::get('errorMsg') }}
                    </div>
                @endif

                <div class="heading" style="padding: 40px 60px">
                    Personal Information
                </div>
                <div class="widget-content padded" style="padding: 10px 60px 40px 60px;">

                    {{ Form::open(array('url' => '/doRegisterTaskminator', 'id' => 'registrationForm-task')) }}
                        <div class="form-group">
                            <label class="control-label row" style="margin-left: 5px;">Name</label>
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
                                <label class="control-label" style="margin-left: 5px;">Gender</label>
                                <select name="gender" required="required" class="form-control inputItem" data-name="Gender">
                                    <option value="MALE">Male</option>
                                    <option value="FEMALE">Female</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label" style="margin-left: 5px;">Nationality</label>
                                {{ Form::text('nationality', Input::old('nationality'), array('data-name' => 'Nationality', 'class' => 'inputItem form-control', 'placeholder' => 'Ex. Filipino', 'required' => 'true')) }}
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
                                {{ Form::text('mobileNum', Input::old('mobileNum'), array('data-name' => 'Mobile Number', 'class' => 'inputItem form-control', 'placeholder' => 'Mobile number', 'required' => 'true')) }}
                            </div>
                        </div><br/>

                        <div class="form-group">
                            <label class="control-label">Preferred Job</label>
                            {{ Form::text('preferredJob', Input::old('preferredJob'), array('data-name' => 'Preffered Job', 'class' => 'form-control inputItem', 'placeholder' => 'Ex. Carpenter', 'required' => 'true')) }}
                        </div>
                        <br/>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label" style="margin-left: 5px;">Years of Experience</label>
                                {{ Form::select('experience', array('0-1 years' => '0-1 years', '2-3 years' => '2-3 years', '3-5 years' => '3-5 years', '5-10 years' => '5-10 years', 'more than 10 years' => 'more than 10 years'), Input::old('experience'), array('data-name' => 'Years of Experience', 'class' => 'inputItem form-control', 'required' => 'true')) }}
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label" style="margin-left: 5px;">Rate</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <select class="inputItem form-control" name="minRate">
                                            <option selected disabled>Select minimum rate</option>
                                            <?php
                                                for ($i=400; $i <= 1000; $i+=50) { 
                                                    echo "<option value=".$i.">".$i."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="inputItem form-control" name="maxRate">
                                            <option selected disabled>Select maximum rate</option>
                                            <?php
                                                for ($i=1000; $i <= 5000; $i+=100) { 
                                                    echo "<option value=".$i.">".$i."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label">Email Address</label>
                                {{ Form::text('email', Input::old('email'), array('data-name' => 'Email Address', 'class' => 'form-control inputItem', 'placeholder' => 'Email address', 'required' => 'true', 'id' => 'email', 'style' => 'max-width: 400px;')) }}
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">TIN Number</label>
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
                                    </div>
                                </div>
                            </div>
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
                <button onclick="$('#registrationForm-task').submit()" class="btn btn-primary" id="confirmButton">Confirm</button>
            </div>
        </div>
    </div>
</div>

@stop