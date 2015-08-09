@extends('layouts.registration')

@section('head')
    Register as Client (Individual)
@stop

@section('head-contents')
    <script>
        function enableSubmit(val){
            var sbmt = document.getElementById("submitForm");
            
            if (val.checked){
                sbmt.disabled = false;
            }
            else{
                sbmt.disabled = true;
            }
        } 


        $("#captcha").keyup(function (e) {
            if (e.keyCode == 13) {
                // Do something
                /*
                $.ajax({
                type: "POST",
                url: '/checkCaptcha',
                data: 'captcha='+$('#captcha').val(),
                success: function( data ) {
                alert( data );
                }
                });
                */
                alert('here');
            }
        });

        /*
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
                    $('#confirmBtn').prop('disabled', false);
                    $('#confirmMsg').empty().append('Please confirm your email information before proceeding (This email will recieve necessary updates and notifications)');
                    $('#emailConfirm').empty().append('<i class="se7en-envelope"></i> '+$('#email').val());
                }
                $('#confirmModal').modal('show');
            });
        });*/
    </script>
@stop

@section('content')
    <div class="taskminator-form">
        <h3 style="text-align:center">Client Registration (Individual)</h3>
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
                                        <label class="control-label" style="margin-left: 5px;">Occupation</label>
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
                                                {{ Form::selectYear('year', 2015, 1955, Input::old('year'), array('data-name' => 'Year', 'class' => 'inputItem form-control', 'required' => 'true')) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="control-label">Mobile Number</label>
                                        {{ Form::text('mobileNum', Input::old('mobileNum'), array('data-name' => 'Mobile Number', 'class' => 'inputItem form-control', 'placeholder' => 'Mobile number', 'required' => 'true')) }}
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
                                    {{ Form::text('email', Input::old('email'), array('data-name' => 'Email Address', 'class' => 'form-control inputItem', 'placeholder' => 'Email address', 'required' => 'true', 'id' => 'email')) }}
                                </div><br/>
                                
                                <hr/>
                                
                                <div class="form-group">
                                    <label class="control-label">Username</label>
                                    {{ Form::text('username', Input::old('username'), array('data-name' => 'Username', 'class' => 'inputItem form-control', 'placeholder' => 'Username', 'required' => 'true')) }}
                                </div><br/>

                                <div class="form-group">
                                    <label class="control-label">Password <h6>(minimum of 8 characters)</h6></label>
                                    <div class="row">
                                        <div class="col-md-5">
                                            {{ Form::password('password', array('data-name' => 'Password', 'data-display' => 'strengthDisplay', 'id' => 'passwordInput', 'class' => 'inputItem form-control', 'placeholder' => 'Please enter password', 'required' => 'true')) }}
                                        </div>
                                        <div class="col-md-7" id="strengthDisplay"></div>
                                    </div>
                                </div><br/>


                                <div class="form-group">
                                    <label class="control-label">Confirm Password</label>
                                    <div class="row">
                                        <div class="col-md-5">
                                            {{ Form::password('confirmpass', array('data-name' => 'Confirm Password', 'class' => 'inputItem form-control', 'placeholder' => 'Re-type password', 'required' => 'true')) }}
                                        </div>
                                        <div class="col-md-7"></div>
                                    </div>
                                </div><br/>


                                <p>
                                    {{ HTML::image(URL::to('simplecaptcha'),'Captcha', array('class' => 'img-rounded')) }}<br><br>
                                    <label>CAPTCHA</label>
                                    {{ Form::text('captcha', '', array('data-name' => 'Captcha', 'class' => 'inputItem form-control', 'id' => 'captcha','placeholder' => 'Type code above', 'required' => 'true', 'style' => 'width: 130px;')) }}
                                </p>

                                <div class="form-group" style="margin-left: 5px;">
                                    <input id="TOS" name="TOS" type="checkbox" value="1" onclick="enableSubmit(this)">
                                    <label class="control-label" style="margin-left: 5px;">Terms of Service</label>
                                </div>
                                <button class="btn btn-primary" type="submit" id="submitForm" onclick="$('#registrationForm').submit();" disabled>Register</button>
                                {{ Form::reset('Reset', array('class' => 'btn btn-default')) }}
                            {{ Form::close() }}
                        </div>
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
                <button class="btn btn-primary" id="confirmBtn" onclick="$('#registrationForm').submit();">Confirm</button>
            </div>
        </div>
    </div>
</div>
@stop