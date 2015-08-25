@extends('layouts.registration')

@section('head')
    Register as Taskminator
@stop

@section('head-contents')
    <script>
        function removeSkill(data){
            var dataId = $(data).attr('data-removeId');
//            alert($(data).attr('data-removeId'));
            $('#div_'+dataId).remove();
            $('#input_'+dataId).remove();
        }

        $(document).ready(function(){
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

                    $('#confirmBtn').prop('disabled', true);
                    $('#emailConfirm').empty();
                    $('#confirmMsg').empty().append('Please fill up necessary information first<br/>'+missingInputs);
                }else{
                    $('#confirmBtn').prop('false', true);
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
    <h3 style="text-align:center">Taskminator Registration</h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="widget-container fluid-height clearfix">

                @if(Session::has('errorMsg'))
                    <div class="alert alert-danger">
                        {{ Session::get('errorMsg') }}
                    </div>
                @endif

                <div class="heading" style="padding: 40px 60px">
                    <i class="icon-reorder"></i>Basic Information
                </div>
                <div class="widget-content padded" style="padding: 10px 60px 40px 60px;">

                    {{ Form::open(array('url' => '/doRegisterTaskminator', 'id' => 'registrationForm-task')) }}
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <div class="row">
                                <div class="col-md-4" style="margin-bottom: 2px;">
                                    {{ Form::text('firstName', Input::old('firstName'), array('data-name' => 'First Name', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter first name', 'required' => 'true')) }}
                                </div>
                                <div class="col-md-3" style="margin-bottom: 2px;">
                                    {{ Form::text('midName', Input::old('midName'), array('data-name' => 'Middle Name', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter middle name', 'required' => 'true')) }}
                                </div>
                                <div class="col-md-5">
                                    {{ Form::text('lastName', Input::old('lastName'), array('data-name' => 'Last Name', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter last name', 'required' => 'true')) }}
                                </div>
                            </div>
                        </div><br/>
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
                                        {{ Form::selectYear('year', 2015, 1955, Input::old('year'), array('data-name' => 'Year', 'class' => 'inputItem form-control', 'required' => 'true')) }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Gender</label>
                                <select name="gender" required="required" class="form-control inputItem">
                                    <option value="MALE" <?php if(Input::old('gender') == 'MALE'){ echo('selected'); } ?>>Male</option>
                                    <option value="FEMALE" <?php if(Input::old('gender') == 'FEMALE'){ echo('selected'); } ?>>Female</option>
                                </select>
                            </div>
                        </div><br/>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Mobile Number</label>
                                {{ Form::text('mobileNum', Input::old('mobileNum'), array('data-name' => 'Mobile Number', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter mobile number', 'required' => 'true')) }}
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Nationality</label>
                                {{ Form::text('nationality', Input::old('nationality'), array('data-name' => 'Nationality', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter your nationality', 'required' => 'true')) }}
                            </div>
                        </div><br/>
                        <div class="form-group">
                            <label class="control-label">Preferred Job</label>
                            {{ Form::text('preferredJob', Input::old('preferred Job'), array('data-name' => 'Preferred Job', 'class' => 'form-control inputItem', 'placeholder' => 'Ex. Carpenter, Plumber, Maid, etc.', 'required' => 'true')) }}
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Experience</label>
                                {{ Form::text('yearsOfExperience', Input::old('yearsOfExperience'), array('data-name' => 'Years of experience', 'class' => 'form-control', 'placeholder' => 'Please enter the number of years of experience', 'required' => 'true')) }}
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Rate</label>
                                {{ Form::text('rate', Input::old('rate'), array('data-name' => 'Rate', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter your rate', 'required' => 'true')) }}
                            </div>
                        </div><br/>

                        <hr />
                        <h5>Account Information</h5><br/>
                        <div class="form-group">
                            <label class="control-label">Username</label>
                            {{ Form::text('username', Input::old('username'), array('data-name' => 'Username', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter username', 'required' => 'true')) }}
                        </div>
                        <br/>
                        <div class="form-group">
                            <label class="control-label">Password</label>
                            {{ Form::password('password', array('data-name' => 'Password', 'data-display' => 'strengthDisplay', 'id' => 'passwordInput', 'class' => 'form-control inputItem', 'placeholder' => 'Please enter password', 'required' => 'true')) }}
                            <div class="col-md-4" id="strengthDisplay"></div>
                        </div>
                        <br/>
                        <div class="form-group">
                            <label class="control-label">Confirm Password</label>
                            {{ Form::password('confirmpass', array('data-name' => 'Confirm Password', 'class' => 'form-control inputItem', 'placeholder' => 'Re-type password', 'required' => 'true')) }}
                        </div>
                        <br/>
                        <p>
                            {{ HTML::image(URL::to('simplecaptcha'),'Captcha', array('class' => 'img-rounded')) }}<br><br>
                            <label>CAPTCHA</label>
                            {{ Form::text('captcha', '', array('data-name' => 'Captcha', 'class' => 'inputItem form-control', 'id' => 'captcha','placeholder' => 'Type code above', 'required' => 'true', 'style' => 'width: 130px;')) }}
                        </p>
                        <div class="form-group">
                            <label class="control-label">Terms of Service</label>
                            {{ Form::checkbox('TOS', '1', array('class' => 'form-control'));}}
                        </div><br/>
                        <br/>
                        <button class="btn btn-primary" id="submitForm" type="submit">Register</button>
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
                <button onclick="$('#registrationForm-task').submit()" class="btn btn-primary">Confirm</button>
            </div>
        </div>
    </div>
</div>
@stop